<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Website\HomeController as WebsiteHomeController;
use App\Http\Controllers\Website\ProductController as WebsiteProductController;
use App\Http\Controllers\Website\CartController as WebsiteCartController;
use App\Http\Controllers\Website\CheckoutController as WebsiteCheckoutController;
use App\Http\Controllers\Website\AboutController as WebsiteAboutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Website routes
Route::get('/', [WebsiteHomeController::class, 'index'])->name('website.home');

Route::prefix('products')->name('website.products.')->group(function () {
    Route::get('/', [WebsiteProductController::class, 'index'])->name('index');
    Route::get('{product}', [WebsiteProductController::class, 'show'])->name('show');
    Route::get('{product}/quick-view', [WebsiteProductController::class, 'quickView'])->name('quick-view');
});

Route::prefix('cart')->name('website.cart.')->group(function () {
    Route::get('/', [WebsiteCartController::class, 'index'])->name('index');
    Route::post('/', [WebsiteCartController::class, 'store'])->name('store');
    Route::patch('/{product}', [WebsiteCartController::class, 'update'])->name('update');
    Route::delete('/{product}', [WebsiteCartController::class, 'destroy'])->name('destroy');
    Route::delete('/', [WebsiteCartController::class, 'clear'])->name('clear');
});

Route::get('/checkout', [WebsiteCheckoutController::class, 'index'])->name('website.checkout.index');
Route::post('/checkout', [WebsiteCheckoutController::class, 'store'])->name('website.checkout.store');

// About pages
Route::prefix('about')->name('website.about.')->group(function () {
    Route::get('/', [WebsiteAboutController::class, 'index'])->name('index');
    Route::get('/contact', [WebsiteAboutController::class, 'contact'])->name('contact');
});

// Add login route for Laravel's default authentication (admin area)
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Customer Authentication Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
});

// Language switching route
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        // Save to session
        session(['locale' => $locale]);
        
        // Always return JSON for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'locale' => $locale]);
        }
        
        // Redirect back for non-AJAX requests
        return redirect()->back();
    }
    return redirect()->back();
})->name('locale');

// Include route files
require_once __DIR__ . '/admin.php';
