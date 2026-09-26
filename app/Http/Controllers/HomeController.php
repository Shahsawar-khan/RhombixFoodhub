<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $featuredItems = MenuItem::where('is_available', true)
            ->where('is_featured', true)
            ->take(6)
            ->get();
        $menuItems = MenuItem::where('is_available', true)
            ->with('category')
            ->latest()
            ->take(9)
            ->get();

        return view('home', compact('categories', 'featuredItems', 'menuItems'));
    }
}