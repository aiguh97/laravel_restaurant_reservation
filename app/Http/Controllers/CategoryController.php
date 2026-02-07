<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //index
    public function index()
    {
        $categories = Category::paginate(10);
        return view('pages.categories.index', compact('categories'));
    }

    //create
    public function create()
    {
        return view('pages.categories.create');
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048',
    ]);

    $filename = null;
    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/categories', $filename);
    }

    Category::create([
        'name' => $request->name,
        'description' => $request->description,
        'image' => $filename,
    ]);

    return redirect()->route('categories.index')->with('success', 'Category created successfully');
}


public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/categories', $filename);
        $category->image = $filename;
    }

    $category->name = $request->name;
    $category->save();

    return redirect()->route('categories.index')->with('success', 'Category updated successfully');
}



    //edit
    public function edit(Category $category)
    {
        return view('pages.categories.edit', compact('category'));
    }



    //destroy
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
