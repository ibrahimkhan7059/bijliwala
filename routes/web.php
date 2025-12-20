<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [HomeController::class, 'product'])->name('product.show');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');

// Test route for custom login (temporary)
Route::get('/test-login', function () {
    return view('auth.login');
})->name('test.login');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Customer Dashboard
Route::get('/dashboard', function () {
    // Check if user is admin and redirect to admin dashboard
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes (Protected with auth and admin middleware)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Product Management
    Route::resource('products', AdminProductController::class);
    
    // Category Management
    Route::resource('categories', AdminCategoryController::class);
    
    // Order Management
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store', 'edit']);
    
    // Customer Management
    Route::resource('customers', AdminCustomerController::class);
    
    // Settings Management
    Route::prefix('settings')->group(function () {
        Route::get('/', [AdminSettingsController::class, 'index'])->name('settings.index');
        Route::post('/general', [AdminSettingsController::class, 'updateGeneral'])->name('settings.general');
        Route::post('/email', [AdminSettingsController::class, 'updateEmail'])->name('settings.email');
        Route::post('/security', [AdminSettingsController::class, 'updateSecurity'])->name('settings.security');
        Route::post('/clear-cache', [AdminSettingsController::class, 'clearCache'])->name('settings.clear-cache');
        Route::post('/backup-database', [AdminSettingsController::class, 'backupDatabase'])->name('settings.backup-database');
    });
});

// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar');
    Route::patch('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.preferences');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Order History
    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [ProfileController::class, 'showOrder'])->name('orders.show');
    
    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

require __DIR__.'/auth.php';
