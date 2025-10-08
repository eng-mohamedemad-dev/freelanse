<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $categoryId = $request->get('category_id');
        
        $products = Product::active()
            ->when($query, function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('sku', 'like', '%' . $query . '%');
            })
            ->when($categoryId, function($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->with(['category', 'brand'])
            ->paginate(20);
            
        $categories = Category::active()->get();
        
        return view('website.search.index', compact('products', 'categories', 'query', 'categoryId'));
    }
}