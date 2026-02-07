<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'image' => $product->image ? asset('storage/products/' . $product->image) : null,
                'is_best_seller' => $product->is_best_seller,
                'category_id' => $product->category_id,
                'category' => $product->category ? $product->category->name : null,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'List Data Product',
            'data' => $data
        ], 200);
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

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);

        $category = Category::find($request->category_id);

        $product = Product::create([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'category_id' => $request->category_id,
            'category' => $category->name,
            'image' => $filename,
            'is_favorite' => $request->is_favorite ?? false,
        ]);

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
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock' => $product->stock,
            'image' => $product->image ? asset('storage/products/' . $product->image) : null,
            'is_best_seller' => $product->is_best_seller,
            'category_id' => $product->category_id,
            'category' => $product->category ? $product->category->name : null,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
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

    // 1. Validasi Data
    $validatedData = $request->validate([
        'name' => 'sometimes|required|min:3',
        'price' => 'sometimes|required|numeric',
        'stock' => 'sometimes|required|integer',
        'category_id' => 'sometimes|required|exists:categories,id',
        'image' => 'sometimes|image|mimes:png,jpg,jpeg|max:2048',
        'description' => 'nullable|string'
    ]);

    // 2. Logika Update Image (Multipart Form Data)
    if ($request->hasFile('image')) {
        // Hapus image lama jika ada
        if ($product->image && Storage::exists('public/products/' . $product->image)) {
            Storage::delete('public/products/' . $product->image);
        }

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);

        // Simpan hanya nama filenya saja ke database
        $product->image = $filename;
    }

    // 3. Update Fields menggunakan fill()
    // Pastikan 'category' tidak ada di dalam array ini karena akan menyebabkan error SQL
    $product->fill($request->only([
        'name',
        'price',
        'stock',
        'category_id',
        'description'
    ]));

    // 4. Eksekusi Simpan
    $product->save();

    // 5. Load relasi agar response data lengkap untuk Flutter
    $product->load('category');

    return response()->json([
        'success' => true,
        'message' => 'Product Updated successfully',
        'data' => $product
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
            // Hapus image jika ada
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product Deleted'
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // Bisa jadi ada foreign key constraint (misal order_items)
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete product because it is linked to other records'
            ], 409);
        }
    }
}
