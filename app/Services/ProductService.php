<?php

namespace App\Services;

use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
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
                $term = '%' . $request->search . '%';
                $q->where('name_ar', 'like', $term)
                  ->orWhere('name_en', 'like', $term)
                  ->orWhere('description_ar', 'like', $term)
                  ->orWhere('description_en', 'like', $term);
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

        // Extract variants data
        $variants = $data['variants'] ?? [];
        unset($data['variants']);

        $product = Product::create($data);

        // Create variants
        if (!empty($variants)) {
            $this->createVariants($product, $variants);
        }

        return $product;
    }

    public function updateProduct(Product $product, array $data)
    {
        // تحديث يعتمد مباشرة على الحقول الجديدة
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

        // Extract variants data
        $variants = $data['variants'] ?? [];
        unset($data['variants']);

        $product->update($data);

        // Update variants
        if (isset($variants)) {
            $this->updateVariants($product, $variants);
        }

        return $product;
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

    private function createVariants(Product $product, array $variants)
    {
        foreach ($variants as $variantData) {
            if (empty($variantData['size_id']) && empty($variantData['color_id'])) {
                continue; // Skip if no size or color selected
            }

            // Handle variant images
            $variantImages = [];
            if (isset($variantData['images']) && is_array($variantData['images'])) {
                foreach ($variantData['images'] as $image) {
                    $variantImages[] = $this->uploadImage($image);
                }
            }

            ProductVariant::create([
                'product_id' => $product->id,
                'size_id' => $variantData['size_id'] ?? null,
                'color_id' => $variantData['color_id'] ?? null,
                'price' => $variantData['price'] ?? $product->price,
                'stock' => $variantData['stock'] ?? 0,
                'images' => $variantImages,
            ]);
        }
    }

    private function updateVariants(Product $product, array $variants)
    {
        // Delete existing variants
        $product->variants()->delete();

        // Create new variants
        if (!empty($variants)) {
            $this->createVariants($product, $variants);
        }
    }

    public function getFeaturedProducts($limit = 8)
    {
        return Product::active()
            ->featured()
            ->inStock()
            ->with(['category'])
            ->limit($limit)
            ->get();
    }

    public function getProductsByCategory(Category $category, $limit = 20)
    {
        return Product::active()
            ->inStock()
            ->where('category_id', $category->id)
            ->with(['category'])
            ->limit($limit)
            ->get();
    }

    public function searchProducts($searchTerm, $limit = 20)
    {
        return Product::active()
        ->inStock()
            ->where(function($q) use ($searchTerm) {
                $term = '%' . $searchTerm . '%';
                $q->where('name_ar', 'like', $term)
                  ->orWhere('name_en', 'like', $term)
                  ->orWhere('description_ar', 'like', $term)
                  ->orWhere('description_en', 'like', $term);
            })
            ->with(['category'])
            ->limit($limit)
            ->get();
    }
}
