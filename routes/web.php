<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PrelovedController as AdminPrelovedController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\PromotedListingController;
use App\Http\Controllers\Admin\SellerController as AdminSellerController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Preloved\DashboardController as PrelovedDashboardController;
use App\Http\Controllers\Preloved\ProductController as PrelovedProductController;
use App\Http\Controllers\Preloved\ProfileController as PrelovedProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PrelovedController as PublicPrelovedController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Public\SitemapController;
use App\Http\Controllers\Public\StoreController as PublicStoreController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\ProfileController as SellerProfileController;
use App\Http\Controllers\Seller\StoreController as SellerStoreController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

// Halaman publik
Route::middleware('track.visitor')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [PublicProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.show');
    Route::get('/stores', [PublicStoreController::class, 'index'])->name('stores.index');
    Route::get('/stores/{store}', [PublicStoreController::class, 'show'])->name('stores.show');
    Route::get('/preloved', [PublicPrelovedController::class, 'index'])->name('preloved.index');
    Route::get('/preloved/{product}', [PublicPrelovedController::class, 'show'])->name('preloved.show');
});

// Halaman seller
Route::middleware(['auth', 'verified'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/', [SellerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [SellerProductController::class, 'index'])->name('products');
    Route::get('/products/create', [SellerProductController::class, 'create'])->name('products.create');
    Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [SellerProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [SellerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/store', [SellerStoreController::class, 'index'])->name('store');
    Route::put('/store', [SellerStoreController::class, 'update'])->name('store.update');
    Route::get('/profile', [SellerProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [SellerProfileController::class, 'update'])->name('profile.update');
});

// Halaman preloved
Route::middleware(['auth', 'verified'])->prefix('preloved-user')->name('preloved-user.')->group(function () {
    Route::get('/', [PrelovedDashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [PrelovedProductController::class, 'index'])->name('products');
    Route::get('/products/create', [PrelovedProductController::class, 'create'])->name('products.create');
    Route::post('/products', [PrelovedProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [PrelovedProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [PrelovedProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [PrelovedProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/profile', [PrelovedProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [PrelovedProfileController::class, 'update'])->name('profile.update');
});

// Halaman admin-bd
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::middleware(['auth', 'verified', 'superadmin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/products', [AdminProductController::class, 'index'])->name('products');
        Route::patch('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::get('/preloved', [AdminPrelovedController::class, 'index'])->name('preloved');
        Route::patch('/preloved/{product}', [AdminPrelovedController::class, 'update'])->name('preloved.update');
        Route::resource('categories', AdminCategoryController::class)->only(['index', 'store', 'update'])->parameters(['categories' => 'category']);
        Route::get('/stores', [AdminStoreController::class, 'index'])->name('stores');
        Route::get('/sellers', [AdminSellerController::class, 'index'])->name('sellers');
        Route::get('/settings', [SettingsController::class, 'edit'])->name('settings');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
        Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::resource('promotions', PromotedListingController::class)->except(['show'])->parameters(['promotions' => 'promotion']);
    });
});

Route::get('/dashboard', [SellerDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
