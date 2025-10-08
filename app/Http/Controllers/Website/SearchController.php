<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display search results
     */
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category');
        $brand = $request->get('brand');
        $sort = $request->get('sort', 'name_asc');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        
        $products = Product::active()
            ->inStock()
            ->with(['category', 'brand']);
        
        // Search query
        if ($query) {
            $products->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('sku', 'like', '%' . $query . '%');
            });
        }
        
        // Category filter
        if ($category) {
            $products->where('category_id', $category);
        }
        
        // Brand filter
        if ($brand) {
            $products->where('brand_id', $brand);
        }
        
        // Price range filter
        if ($minPrice) {
            $products->where('price', '>=', $minPrice);
        }
        
        if ($maxPrice) {
            $products->where('price', '<=', $maxPrice);
        }
        
        // Sorting
        switch ($sort) {
            case 'name_asc':
                $products->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $products->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $products->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $products->orderBy('price', 'desc');
                break;
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
            default:
                $products->orderBy('name', 'asc');
        }
        
        $products = $products->paginate(20);
        
        // Get categories and brands for filters
        $categories = \App\Models\Category::active()->get();
        $brands = \App\Models\Brand::active()->get();
        
        return view('website.search.index', compact(
            'products', 
            'query', 
            'categories', 
            'brands',
            'category',
            'brand',
            'sort',
            'minPrice',
            'maxPrice'
        ));
    }
    
    /**
     * Get search suggestions
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $products = Product::active()
            ->inStock()
            ->where('name', 'like', '%' . $query . '%')
            ->limit(5)
            ->get(['id', 'name', 'price', 'image']);
        
        $suggestions = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->final_price,
                'image' => $product->image,
                'url' => route('website.products.show', $product)
            ];
        });
        
        return response()->json($suggestions);
    }
}
