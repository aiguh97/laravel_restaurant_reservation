<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  public function index(Request $request)
{
    $products = Product::with('category')
        ->when($request->name, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->name . '%');
        })
        ->latest()
        ->paginate(10);

    return view('pages.products.index', compact('products'));
}



    public function create()
    {
        $categories = Category::all();
        return view('pages.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $filename = null;
        // if ($request->hasFile('image')) {
        //     $filename = time() . '.' . $request->image->extension();
        //     $request->image->storeAs('public/products', $filename);
        // }
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();

            Storage::disk('minio')->putFileAs(
                'products',
                $request->file('image'),
                $filename
            );
        }

        $product = new Product();
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category_id = $request->category_id;
        $product->image = $filename;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.products.edit', compact('product', 'categories'));
    }

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required|min:3|unique:products,name,' . $product->id,
        'price' => 'required|integer',
        'stock' => 'required|integer',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
    ]);

    DB::beginTransaction();

    try {
        // simpan nama image lama
        $oldImage = $product->image;

        // kalau upload image baru
        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->image->extension();

            // upload ke MinIO (PATH BENAR)
            Storage::disk('minio')->putFileAs(
                'products',
                $request->file('image'),
                $filename
            );

            // set image baru ke model
            $product->image = $filename;
        }

        // update data
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category_id = $request->category_id;
        $product->save();

        // kalau upload sukses & ada image lama → hapus
        if ($request->hasFile('image') && $oldImage) {
            Storage::disk('minio')->delete('products/' . $oldImage);
        }

        DB::commit();

        return redirect()
            ->route('product.index')
            ->with('success', 'Product successfully updated');

    } catch (\Throwable $e) {
        DB::rollBack();

        return back()->withErrors([
            'error' => 'Update failed: ' . $e->getMessage()
        ]);
    }
}


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && Storage::exists('public/products/' . $product->image)) {
            Storage::delete('public/products/' . $product->image);
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
