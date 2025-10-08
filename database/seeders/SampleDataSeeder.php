<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء فئات
        $categories = [
            ['name' => 'إلكترونيات', 'description' => 'أجهزة إلكترونية متنوعة'],
            ['name' => 'ملابس', 'description' => 'ملابس رجالية ونسائية'],
            ['name' => 'منزل', 'description' => 'أدوات منزلية'],
            ['name' => 'رياضة', 'description' => 'معدات رياضية'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // إنشاء علامات تجارية
        $brands = [
            ['name' => 'Apple', 'description' => 'شركة آبل'],
            ['name' => 'Samsung', 'description' => 'شركة سامسونج'],
            ['name' => 'Nike', 'description' => 'شركة نايك'],
            ['name' => 'Adidas', 'description' => 'شركة أديداس'],
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }

        // إنشاء منتجات
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'أحدث هاتف من آبل مع معالج A17 Pro',
                'price' => 4500.00,
                'sale_price' => 4200.00,
                'sku' => 'IPH15PRO',
                'stock' => 50,
                'category_id' => 1,
                'brand_id' => 1,
                'featured' => true,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'هاتف سامسونج الجديد مع كاميرا متطورة',
                'price' => 3800.00,
                'sale_price' => null,
                'sku' => 'SGS24',
                'stock' => 30,
                'category_id' => 1,
                'brand_id' => 2,
                'featured' => true,
            ],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'حذاء رياضي مريح وأنيق',
                'price' => 800.00,
                'sale_price' => 650.00,
                'sku' => 'NAM270',
                'stock' => 100,
                'category_id' => 4,
                'brand_id' => 3,
                'featured' => false,
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'description' => 'حذاء رياضي عالي الأداء',
                'price' => 900.00,
                'sale_price' => null,
                'sku' => 'AUB22',
                'stock' => 75,
                'category_id' => 4,
                'brand_id' => 4,
                'featured' => true,
            ],
            [
                'name' => 'MacBook Pro M3',
                'description' => 'لابتوب احترافي مع معالج M3',
                'price' => 12000.00,
                'sale_price' => 11000.00,
                'sku' => 'MBP13M3',
                'stock' => 25,
                'category_id' => 1,
                'brand_id' => 1,
                'featured' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
