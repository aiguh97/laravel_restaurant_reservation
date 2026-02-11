<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // Base URL untuk storage public
    private function fullImageUrl(?string $image): string
    {
        if (!$image) {
            return asset('storage/categories/default.png'); // fallback jika null
        }
        return asset('storage/categories/' . $image);
    }

    // GET /api/categories
    public function index()
    {
        $categories = Category::all()->map(function ($category) {
            if ($category->image) {
                // Gunakan titik (.) untuk menggabungkan string
                // ltrim digunakan untuk menghapus slash di awal nama image jika ada
                $path = 'categories/' . ltrim($category->image, '/');

                $category->image = Storage::disk('minio')->url($path);
            }
            return $category;
        });

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }



    // GET /api/categories/{id}
    public function show(Category $category)
    {
        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    // POST /api/categories
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $filename = null;
        // if ($request->hasFile('image')) {
        //     $filename = time() . '.' . $request->image->extension();
        //     $request->image->storeAs('public/categories', $filename);
        // }
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();

            Storage::disk('minio')->putFileAs(
                'categories',
                $request->file('image'),
                $filename
            );
        }

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $filename,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $category
        ], 201);
    }

    // PUT /api/categories/{id}
    // update API
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Hanya update jika field ada
        if ($request->filled('name')) {
            $category->name = $request->name;
        }

        if ($request->filled('description')) {
            $category->description = $request->description;
        }

        // if ($request->hasFile('image')) {
        //     if ($category->image) {
        //         Storage::delete('public/categories/' . $category->image);
        //     }
        //     $filename = time() . '.' . $request->image->extension();
        //     $request->image->storeAs('public/categories', $filename);
        //     $category->image = $filename;
        // }

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('minio')->delete('categories/' . $category->image);
            }

            $filename = time() . '.' . $request->image->extension();

            Storage::disk('minio')->putFileAs(
                'categories',
                $request->file('image'),
                $filename
            );

            $category->image = $filename;
        }
        $category->save();

        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }


    // DELETE /api/categories/{id}
    public function destroy(Category $category)
    {
        // Hapus file jika ada
        // if ($category->image) {
        //     Storage::delete('public/categories/' . $category->image);
        // }
        if ($category->image) {
            Storage::disk('minio')->delete('categories/' . $category->image);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ]);
    }
}
