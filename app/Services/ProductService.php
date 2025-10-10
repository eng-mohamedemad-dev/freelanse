<?php

namespace App\Services;

use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductService implements ProductServiceInterface
{
    public function getAllProducts(Request $request)
    {
        $query = Product::with(['category']);

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        return $query->paginate(10);
    }

    public function createProduct(array $data)
    {
        // Handle image uploads
        if (isset($data['images']) && is_array($data['images'])) {
            $uploadedImages = [];
            foreach ($data['images'] as $image) {
                $uploadedImages[] = $this->uploadImage($image);
            }
            $data['images'] = $uploadedImages;
        }

        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        // Handle image uploads
        if (isset($data['images']) && is_array($data['images'])) {
            $uploadedImages = [];
            foreach ($data['images'] as $image) {
                if (is_string($image)) {
                    // Existing image
                    $uploadedImages[] = $image;
                } else {
                    // New uploaded image
                    $uploadedImages[] = $this->uploadImage($image);
                }
            }
            $data['images'] = $uploadedImages;
        }

        return $product->update($data);
    }

    public function deleteProduct(Product $product)
    {
        // Delete associated images
        if ($product->images) {
            foreach ($product->images as $image) {
                $this->deleteImage($image);
            }
        }

        return $product->delete();
    }

    private function uploadImage($image)
    {
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $uploadPath = public_path('uploads/products');
        
        // إنشاء المجلد إذا لم يكن موجوداً
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // نقل الملف
        $image->move($uploadPath, $filename);
        
        return 'uploads/products/' . $filename;
    }

    private function deleteImage($imagePath)
    {
        $fullPath = public_path($imagePath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function getFeaturedProducts($limit = 8)
    {
        return Product::active()
            ->featured()
            ->inStock()
            ->with(['category', 'brand'])
            ->limit($limit)
            ->get();
    }

    public function getProductsByCategory(Category $category, $limit = 20)
    {
        return Product::active()
            ->inStock()
            ->where('category_id', $category->id)
            ->with(['category', 'brand'])
            ->limit($limit)
            ->get();
    }

    public function searchProducts($searchTerm, $limit = 20)
    {
        return Product::active()
            ->inStock()
            ->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%')
                      ->orWhere('sku', 'like', '%' . $searchTerm . '%');
            })
            ->with(['category', 'brand'])
            ->limit($limit)
            ->get();
    }
}
