<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class StockNotificationService
{
    protected $lowStockThreshold = 5;
    protected $outOfStockThreshold = 0;

    public function __construct()
    {
        // يمكن جعل هذه القيم قابلة للتكوين من الإعدادات
        $this->lowStockThreshold = config('app.low_stock_threshold', 5);
        $this->outOfStockThreshold = config('app.out_of_stock_threshold', 0);
    }

    /**
     * فحص جميع المنتجات وإرسال إشعارات المخزون المنخفض
     */
    public function checkAllProductsStock()
    {
        try {
            // فحص المنتجات ذات المخزون المنخفض
            $lowStockProducts = Product::where('stock', '<=', $this->lowStockThreshold)
                ->where('stock', '>', $this->outOfStockThreshold)
                ->get();

            foreach ($lowStockProducts as $product) {
                $this->createLowStockNotification($product);
            }

            // فحص المنتجات التي نفد منها المخزون
            $outOfStockProducts = Product::where('stock', '<=', $this->outOfStockThreshold)
                ->get();

            foreach ($outOfStockProducts as $product) {
                $this->createOutOfStockNotification($product);
            }

            Log::info('Stock check completed', [
                'low_stock_count' => $lowStockProducts->count(),
                'out_of_stock_count' => $outOfStockProducts->count()
            ]);

            return [
                'low_stock_count' => $lowStockProducts->count(),
                'out_of_stock_count' => $outOfStockProducts->count()
            ];

        } catch (\Exception $e) {
            Log::error('Error checking stock: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * فحص منتج محدد
     */
    public function checkProductStock(Product $product)
    {
        if ($product->stock <= $this->outOfStockThreshold) {
            return $this->createOutOfStockNotification($product);
        } elseif ($product->stock <= $this->lowStockThreshold) {
            return $this->createLowStockNotification($product);
        }

        return false;
    }

    /**
     * إنشاء إشعار مخزون منخفض
     */
    protected function createLowStockNotification(Product $product)
    {
        // التحقق من عدم وجود إشعار مشابه غير مقروء
        $existingNotification = Notification::where('type', 'warning')
            ->where('is_read', false)
            ->whereJsonContains('data->product_id', $product->id)
            ->where('created_at', '>=', now()->subHours(24)) // خلال آخر 24 ساعة
            ->first();

        if ($existingNotification) {
            return $existingNotification;
        }

        return Notification::createLowStockNotification($product);
    }

    /**
     * إنشاء إشعار نفاد المخزون
     */
    protected function createOutOfStockNotification(Product $product)
    {
        // التحقق من عدم وجود إشعار مشابه غير مقروء
        $existingNotification = Notification::where('type', 'error')
            ->where('is_read', false)
            ->whereJsonContains('data->product_id', $product->id)
            ->where('created_at', '>=', now()->subHours(24)) // خلال آخر 24 ساعة
            ->first();

        if ($existingNotification) {
            return $existingNotification;
        }

        return Notification::createOutOfStockNotification($product);
    }

    /**
     * الحصول على عدد الإشعارات غير المقروءة
     */
    public function getUnreadNotificationsCount()
    {
        return Notification::unread()->count();
    }

    /**
     * الحصول على الإشعارات الأخيرة
     */
    public function getRecentNotifications($limit = 10)
    {
        return Notification::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * تحديث عتبة المخزون المنخفض
     */
    public function setLowStockThreshold($threshold)
    {
        $this->lowStockThreshold = $threshold;
        return $this;
    }

    /**
     * تحديث عتبة نفاد المخزون
     */
    public function setOutOfStockThreshold($threshold)
    {
        $this->outOfStockThreshold = $threshold;
        return $this;
    }

    /**
     * تنظيف الإشعارات القديمة
     */
    public function cleanOldNotifications($days = 30)
    {
        return Notification::where('created_at', '<', now()->subDays($days))
            ->where('is_read', true)
            ->delete();
    }
}
