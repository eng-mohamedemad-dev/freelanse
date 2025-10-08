<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()->root()->with('children')->get();
        
        return view('website.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = Product::active()
            ->where('category_id', $category->id)
            ->with(['category', 'brand'])
            ->paginate(20);
            
        return view('website.categories.show', compact('category', 'products'));
    }
}
