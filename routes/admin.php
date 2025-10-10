<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;

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
Route::prefix('admin')->name('admin.')->middleware(['auth', 'web'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('sales-data', [DashboardController::class, 'getSalesData'])->name('dashboard.sales-data');
    
    // Resource Routes
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
    
    // Additional Routes for Products
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
    
    // Additional Routes for Categories
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    
    // Additional Routes for Brands
    Route::post('brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');
    
    // Additional Routes for Orders
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::post('orders/{order}/mark-completed', [OrderController::class, 'markAsCompleted'])->name('orders.mark-completed');
    Route::post('orders/{order}/mark-cancelled', [OrderController::class, 'markAsCancelled'])->name('orders.mark-cancelled');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    
    // Additional Routes for Users
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Reports
    Route::get('reports/sales', [DashboardController::class, 'salesReport'])->name('reports.sales');
    Route::get('reports/products', [DashboardController::class, 'productsReport'])->name('reports.products');
    Route::get('reports/customers', [DashboardController::class, 'customersReport'])->name('reports.customers');
    
    // File Uploads
    Route::post('upload/image', [DashboardController::class, 'uploadImage'])->name('upload.image');
    Route::post('upload/file', [DashboardController::class, 'uploadFile'])->name('upload.file');
    
    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    
    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
