<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::with('category')->where('is_available', true);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $menuItems = $query->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('menu.index', compact('menuItems', 'categories'));
    }

    public function show($slug)
    {
        $item = MenuItem::with('category')->where('slug', $slug)->firstOrFail();
        $relatedItems = MenuItem::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->take(4)
            ->get();

        return view('menu.show', compact('item', 'relatedItems'));
    }
}