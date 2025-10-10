<?php

use Illuminate\Support\Facades\Route;

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

// Redirect root to admin login
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Add login route for Laravel's default authentication
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Language switching route
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        // Save to session
        session(['locale' => $locale]);
        
        // Log for debugging
        \Log::info('Language changed to: ' . $locale);
        
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
