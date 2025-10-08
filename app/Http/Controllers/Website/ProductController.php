<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->getAllProducts($request);
        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('website.products.index', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'reviews.user']);
        
        // Get related products
        $relatedProducts = Product::active()
            ->inStock()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('website.products.show', compact('product', 'relatedProducts'));
    }

    public function byCategory(Category $category, Request $request)
    {
        $request->merge(['category_id' => $category->id]);
        $products = $this->productService->getAllProducts($request);
        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('website.products.index', compact('products', 'categories', 'brands', 'category'));
    }

    public function byBrand(Brand $brand, Request $request)
    {
        $request->merge(['brand_id' => $brand->id]);
        $products = $this->productService->getAllProducts($request);
        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('website.products.index', compact('products', 'categories', 'brands', 'brand'));
    }
}
