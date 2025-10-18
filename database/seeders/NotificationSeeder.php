<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\Product;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء إشعارات تجريبية للمنتجات ذات المخزون المنخفض
        $products = Product::where('stock', '<=', 5)->get();
        
        foreach ($products as $product) {
            if ($product->stock <= 0) {
                Notification::createOutOfStockNotification($product);
            } else {
                Notification::createLowStockNotification($product);
            }
        }
        
        // إنشاء إشعارات تجريبية إضافية
        Notification::create([
            'type' => 'info',
            'title' => 'مرحباً بك في النظام',
            'message' => 'تم تسجيل الدخول بنجاح إلى لوحة التحكم',
            'message_en' => 'Welcome to the system. You have successfully logged into the dashboard',
            'data' => null,
            'is_read' => false
        ]);
        
        Notification::create([
            'type' => 'success',
            'title' => 'تم تحديث النظام',
            'message' => 'تم تحديث النظام بنجاح إلى أحدث إصدار',
            'message_en' => 'System updated successfully to the latest version',
            'data' => null,
            'is_read' => false
        ]);
    }
}
