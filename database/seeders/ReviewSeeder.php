<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $users = User::all();

        if ($products->count() == 0 || $users->count() == 0) {
            $this->command->warn('No products or users found. Please run ProductSeeder and UserSeeder first.');
            return;
        }

        $reviews = [
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => 5,
                'comment' => 'منتج رائع جداً، أنصح به بشدة! الجودة ممتازة والسعر مناسب.',
                'status' => 'approved'
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => 4,
                'comment' => 'جيد جداً، لكن يمكن تحسين التغليف قليلاً.',
                'status' => 'approved'
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => 3,
                'comment' => 'متوسط، لا بأس به لكن ليس استثنائياً.',
                'status' => 'pending'
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => 5,
                'comment' => 'ممتاز! تجربة رائعة، سأطلب مرة أخرى بالتأكيد.',
                'status' => 'approved'
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => 2,
                'comment' => 'لم يعجبني كثيراً، الجودة أقل من المتوقع.',
                'status' => 'rejected'
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => 4,
                'comment' => 'جيد جداً، التوصيل كان سريع والمنتج كما هو موصوف.',
                'status' => 'approved'
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => 5,
                'comment' => 'رائع! أفضل منتج اشتريته من هذا الموقع.',
                'status' => 'approved'
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => 1,
                'comment' => 'سيء جداً، لا أنصح به أبداً.',
                'status' => 'rejected'
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => 4,
                'comment' => 'جيد، لكن السعر مرتفع قليلاً مقارنة بالجودة.',
                'status' => 'pending'
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => 5,
                'comment' => 'ممتاز! الجودة والخدمة على أعلى مستوى.',
                'status' => 'approved'
            ],
            // Reviews without users (guest reviews)
            [
                'user_id' => null,
                'product_id' => $products->random()->id,
                'rating' => 4,
                'comment' => 'منتج جيد، التوصيل كان سريع.',
                'status' => 'approved'
            ],
            [
                'user_id' => null,
                'product_id' => $products->random()->id,
                'rating' => 3,
                'comment' => 'لا بأس، لكن يمكن تحسينه.',
                'status' => 'pending'
            ],
            [
                'user_id' => null,
                'product_id' => $products->random()->id,
                'rating' => 5,
                'comment' => 'رائع جداً! أنصح به.',
                'status' => 'approved'
            ],
        ];

        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }

        $this->command->info('Reviews seeded successfully!');
    }
}

