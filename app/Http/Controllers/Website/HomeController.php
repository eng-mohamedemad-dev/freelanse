<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('status', 'active')->where('featured', true)->latest()->take(8)->get();
        $latestProducts = Product::where('status', 'active')->latest()->take(12)->get();
        $categories = Category::latest()->take(8)->get();

        return view('website.home', compact('featuredProducts', 'latestProducts', 'categories'));
    }
}


