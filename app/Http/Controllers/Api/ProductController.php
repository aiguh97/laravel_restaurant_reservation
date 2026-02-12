<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $data = Cache::tags(['products'])->remember(
        'products.all',
        now()->addMinutes(10),
        function () {
            return Product::with('category')
                ->latest()
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'image' => $product->image
                            ? Storage::disk('minio')->url('products/' . $product->image)
                            : null,
                        'is_best_seller' => $product->is_best_seller,
                        'category_id' => $product->category_id,
                        'category' => $product->category?->name,
                        'created_at' => $product->created_at,
                        'updated_at' => $product->updated_at,
                    ];
                });
        }
    );

    return response()->json([
        'success' => true,
        'message' => 'List Data Product',
        'data' => $data
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        // upload ke MinIO
        $filename = uniqid() . '.' . $request->image->extension();
        Storage::disk('minio')->putFileAs(
            'products',
            $request->image,
            $filename
        );

        $product = Product::create([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'category_id' => $request->category_id,
            'image' => $filename,
            'is_favorite' => $request->is_favorite ?? false,
        ]);

        // invalidate cache
        Cache::forget('api:products:all');

        return response()->json([
            'success' => true,
            'message' => 'Product Created',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
   public function show(string $id)
{
    $data = Cache::tags(['products'])->remember(
        "products.$id",
        now()->addMinutes(10),
        function () use ($id) {

            $product = Product::with('category')->find($id);

            if (!$product) return null;

            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'image' => $product->image
                    ? Storage::disk('minio')->url('products/' . $product->image)
                    : null,
                'category' => $product->category?->name,
            ];
        }
    );

    if (!$data) {
        return response()->json([
            'success' => false,
            'message' => 'Product not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|min:3',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image' => 'sometimes|image|mimes:png,jpg,jpeg|max:2048',
            'description' => 'nullable|string'
        ]);

        // update image
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('minio')->delete('products/' . $product->image);
            }

            $filename = uniqid() . '.' . $request->image->extension();
            Storage::disk('minio')->putFileAs(
                'products',
                $request->image,
                $filename
            );

            $product->image = $filename;
        }

        $product->fill($request->only([
            'name',
            'price',
            'stock',
            'category_id',
            'description'
        ]));

        $product->save();

        // invalidate cache
        Cache::forget('api:products:all');
        Cache::forget('api:products:' . $id);
        Cache::tags(['products'])->flush();

        return response()->json([
            'success' => true,
            'message' => 'Product Updated',
            'data' => $product->load('category')
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        try {
            if ($product->image) {
                Storage::disk('minio')->delete('products/' . $product->image);
            }

            $product->delete();

            Cache::forget('api:products:all');
            Cache::tags(['products'])->flush();

            return response()->json([
                'success' => true,
                'message' => 'Product Deleted'
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete product because it is linked to other records'
            ], 409);
        }
    }
}
