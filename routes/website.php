<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\CheckoutController;
use App\Http\Controllers\Website\AccountController;
use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\WishlistController;
use App\Http\Controllers\Website\SearchController;
use App\Http\Controllers\Website\OrderController;
use App\Http\Controllers\Website\WheelController;
use App\Http\Controllers\Website\QuickOrderController;

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
|
| Here is where you can register website routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('website.home');
Route::get('/about', [HomeController::class, 'about'])->name('website.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('website.contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('website.contact.submit');

// Resource Routes
Route::resource('products', ProductController::class)->only(['index', 'show'])->names([
    'index' => 'website.products.index',
    'show' => 'website.products.show'
]);
Route::resource('categories', CategoryController::class)->only(['index', 'show'])->names([
    'index' => 'website.categories.index',
    'show' => 'website.categories.show'
]);

// Additional Product Routes
Route::get('/products/category/{category}', [ProductController::class, 'byCategory'])->name('website.products.category');
Route::get('/products/brand/{brand}', [ProductController::class, 'byBrand'])->name('website.products.brand');

// Search Routes
Route::get('/search', [SearchController::class, 'index'])->name('website.search');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('website.search.suggestions');

// Cart Routes
Route::prefix('cart')->name('website.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Wishlist Routes
Route::prefix('wishlist')->name('website.wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/add', [WishlistController::class, 'add'])->name('add');
    Route::post('/remove', [WishlistController::class, 'remove'])->name('remove');
    Route::post('/toggle', [WishlistController::class, 'toggle'])->name('toggle');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('website.login');
    Route::post('/login', [AuthController::class, 'login'])->name('website.login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('website.register');
    Route::post('/register', [AuthController::class, 'register'])->name('website.register.submit');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('website.password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('website.password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('website.password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('website.password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    
    // Account Resource Routes
    Route::prefix('account')->name('website.account.')->group(function () {
        Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::post('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [AccountController::class, 'orderDetails'])->name('orders.show');
        Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
        Route::get('/reviews', [AccountController::class, 'reviews'])->name('reviews');
        Route::post('/change-password', [AccountController::class, 'changePassword'])->name('change-password');
        
        // Addresses Resource
        Route::resource('addresses', AccountController::class)->except(['show']);
    });
    
    // Checkout Routes
    Route::prefix('checkout')->name('website.checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
        Route::get('/cancel', [CheckoutController::class, 'cancel'])->name('cancel');
    });
    
    // Orders Routes
    Route::prefix('orders')->name('website.orders.')->group(function () {
        Route::get('/{order}/track', [OrderController::class, 'track'])->name('track');
        Route::get('/{order}/invoice', [OrderController::class, 'invoice'])->name('invoice');
    });
});

// Wheel of Fortune Routes
Route::prefix('wheel')->name('website.wheel.')->group(function () {
    Route::get('/', [WheelController::class, 'index'])->name('index');
    Route::post('/spin', [WheelController::class, 'spin'])->name('spin');
    Route::post('/claim', [WheelController::class, 'claim'])->name('claim');
});

// Quick Order
Route::post('/quick-order', [QuickOrderController::class, 'store'])->name('website.quick-order');

// Newsletter
Route::post('/newsletter/subscribe', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'email' => 'required|email'
    ]);
    
    // Here you would typically save the email to database
    // For now, we'll just return success
    
    return redirect()->back()->with('success', __('website.newsletter_subscribed_successfully'));
})->name('website.newsletter.subscribe');

// Language Switching
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale');
