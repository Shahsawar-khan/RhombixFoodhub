<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')->latest()->paginate(10);
        return view('admin.menu-items.index', compact('menuItems'));
    }

    public function create() { return view('admin.menu-items.create'); }
    public function store(\Illuminate\Http\Request $request) { }
    public function show(MenuItem $menuItem) { }
    public function edit(MenuItem $menuItem) { return view('admin.menu-items.edit', compact('menuItem')); }
    public function update(\Illuminate\Http\Request $request, MenuItem $menuItem) { }
    public function destroy(MenuItem $menuItem) { }
}