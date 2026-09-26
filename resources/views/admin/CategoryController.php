<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('menuItems')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create() { return view('admin.categories.create'); }
    public function store(\Illuminate\Http\Request $request) { }
    public function show(Category $category) { }
    public function edit(Category $category) { return view('admin.categories.edit', compact('category')); }
    public function update(\Illuminate\Http\Request $request, Category $category) { }
    public function destroy(Category $category) { }
}