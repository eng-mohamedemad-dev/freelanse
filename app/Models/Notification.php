<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'message_en',
        'data',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Methods
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null
        ]);
    }

    // Static methods for creating notifications
    public static function createLowStockNotification($product)
    {
        return self::create([
            'type' => 'warning',
            'title' => 'مخزون منخفض',
            'message' => "المنتج '{$product->name}' لديه مخزون منخفض ({$product->stock} وحدة متبقية)",
            'message_en' => "Product '{$product->name}' has low stock ({$product->stock} units remaining)",
            'data' => [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'current_stock' => $product->stock,
                'threshold' => 5
            ]
        ]);
    }

    public static function createOutOfStockNotification($product)
    {
        return self::create([
            'type' => 'error',
            'title' => 'نفاد المخزون',
            'message' => "المنتج '{$product->name}' نفد من المخزون",
            'message_en' => "Product '{$product->name}' is out of stock",
            'data' => [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'current_stock' => $product->stock
            ]
        ]);
    }

    // Get localized message
    public function getLocalizedMessage($locale = 'ar')
    {
        if ($locale === 'en' && $this->message_en) {
            return $this->message_en;
        }
        return $this->message;
    }

    // Get localized title
    public function getLocalizedTitle($locale = 'ar')
    {
        $titles = [
            'warning' => $locale === 'en' ? 'Low Stock' : 'مخزون منخفض',
            'error' => $locale === 'en' ? 'Out of Stock' : 'نفاد المخزون',
            'info' => $locale === 'en' ? 'Information' : 'معلومات',
            'success' => $locale === 'en' ? 'Success' : 'نجح'
        ];

        return $titles[$this->type] ?? $this->title;
    }
}
