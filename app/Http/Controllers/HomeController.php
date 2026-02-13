<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['category', 'images'])
            ->featured()
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::withCount('products')->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}
