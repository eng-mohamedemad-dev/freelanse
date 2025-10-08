<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with(['category', 'brand']);
        
        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Filter by brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);
        
        $products = $query->paginate(20);
        $categories = Category::active()->root()->with('children')->get();
        $brands = Brand::active()->get();
        
        return view('website.products.index', compact('products', 'categories', 'brands'));
    }
    
    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'reviews']);
        
        // Get related products
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['category', 'brand'])
            ->limit(4)
            ->get();
            
        return view('website.products.show', compact('product', 'relatedProducts'));
    }
    
    public function byCategory(Category $category)
    {
        $products = Product::active()
            ->where('category_id', $category->id)
            ->with(['category', 'brand'])
            ->paginate(20);
            
        $categories = Category::active()->root()->with('children')->get();
        $brands = Brand::active()->get();
        
        return view('website.products.index', compact('products', 'categories', 'brands', 'category'));
    }
    
    public function byBrand(Brand $brand)
    {
        $products = Product::active()
            ->where('brand_id', $brand->id)
            ->with(['category', 'brand'])
            ->paginate(20);
            
        $categories = Category::active()->root()->with('children')->get();
        $brands = Brand::active()->get();
        
        return view('website.products.index', compact('products', 'categories', 'brands', 'brand'));
    }
}