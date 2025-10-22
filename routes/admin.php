<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\ReviewController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group.
|
*/

// Admin Login Routes (outside middleware)
Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // إنشاء مدير افتراضي (للتطوير فقط)
    Route::get('/create-admin', [AdminAuthController::class, 'createDefaultAdmin'])->name('create-admin');
});

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['web', 'auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('sales-data', [DashboardController::class, 'getSalesData'])->name('dashboard.sales-data');
    
    // Resource Routes with Permissions
    Route::resource('products', ProductController::class)->middleware('permission:view_products');
    Route::resource('categories', CategoryController::class)->middleware('permission:view_categories');
    Route::resource('orders', OrderController::class)->middleware('permission:view_orders');
    Route::resource('users', UserController::class)->middleware('permission:view_users');
    Route::resource('coupons', CouponController::class)->middleware('permission:view_coupons');
    Route::resource('reviews', ReviewController::class);
    
    // Additional Routes for Products
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
    
    // Additional Routes for Categories
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    
    // Additional Routes for Orders
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::post('orders/{order}/mark-completed', [OrderController::class, 'markAsCompleted'])->name('orders.mark-completed');
    Route::post('orders/{order}/mark-cancelled', [OrderController::class, 'markAsCancelled'])->name('orders.mark-cancelled');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    
    // Additional Routes for Users
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Additional Routes for Coupons
    Route::post('coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
    Route::post('coupons/bulk-action', [CouponController::class, 'bulkAction'])->name('coupons.bulk-action');
    Route::delete('coupons/{coupon}/delete-image', [CouponController::class, 'deleteImage'])->name('coupons.delete-image');
    
    // Additional Routes for Reviews
    Route::post('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::post('reviews/bulk-action', [ReviewController::class, 'bulkAction'])->name('reviews.bulk-action');
    
    // Reports
    Route::get('reports/sales', [DashboardController::class, 'salesReport'])->name('reports.sales');
    Route::get('reports/products', [DashboardController::class, 'productsReport'])->name('reports.products');
    Route::get('reports/customers', [DashboardController::class, 'customersReport'])->name('reports.customers');

    // Statistics
    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('statistics/products', [StatisticsController::class, 'products'])->name('statistics.products');
    Route::get('statistics/users', [StatisticsController::class, 'users'])->name('statistics.users');
    
    // File Uploads
    Route::post('upload/image', [DashboardController::class, 'uploadImage'])->name('upload.image');
    Route::post('upload/file', [DashboardController::class, 'uploadFile'])->name('upload.file');
    
    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    
    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Notifications
    Route::get('notifications', [DashboardController::class, 'notifications'])->name('notifications');
    Route::get('notifications/api', [DashboardController::class, 'getNotifications'])->name('notifications.api');
    Route::get('notifications/header', [DashboardController::class, 'getHeaderNotifications'])->name('notifications.header');
    Route::post('notifications/{id}/read', [DashboardController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [DashboardController::class, 'markAllNotificationsAsRead'])->name('notifications.read-all');
    Route::delete('notifications/{id}', [DashboardController::class, 'deleteNotification'])->name('notifications.delete');
});
