<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [DashboardController::class, 'home'])->name('index');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/store', [AuthController::class, 'storeLogin'])->name('login.store');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register/store', [AuthController::class, 'storeRegister'])->name('register.store');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/oauth/google', [AuthController::class, 'redirectToProvider'])->name('oauth.google');
Route::get('/oauth/google/callback', [AuthController::class, 'handleGoogleAuth'])->name('oauth.google.callback');

Route::get('/cart', function () {
  return Inertia('cart');
});
// Route::get('/cart', [DashboardController::class, 'carts'])->name('cart');

Route::prefix('products')->name('products.')->group(function () {
  Route::get('/', [DashboardController::class, 'products'])->name('index');
  Route::get('/{product:slug}', [DashboardController::class, 'show'])->name('show');
  Route::prefix('sales')->name('sales.')->group(function () {
    // product discount
  });
});

Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
  Route::get('/', [HomeController::class, 'index'])->name('index');
  Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
  Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/add', [ProductController::class, 'create'])->name('create');
    Route::post('/add', [ProductController::class, 'store'])->name('store');
    Route::get('/edit/{product:slug}', [ProductController::class, 'edit'])->name('edit');
    Route::put('/edit', [ProductController::class, 'update'])->name('update');
    Route::delete('/delete', [ProductController::class, 'destroy'])->name('delete');
    Route::prefix('sales')->name('sales.')->group(function () {
      // product discount
    });
  });
  Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/add', [UserController::class, 'create'])->name('create');
    Route::post('/add', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{user:slug}', [UserController::class, 'edit'])->name('edit');
    Route::put('/edit', [UserController::class, 'update'])->name('update');
    Route::delete('/delete', [UserController::class, 'destroy'])->name('delete');
  });
  Route::prefix('brands')->name('brands.')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('index');
    Route::get('/add', [BrandController::class, 'create'])->name('create');
    Route::post('/store', [BrandController::class, 'store'])->name('store');
    Route::get('/edit/{brand:slug}', [BrandController::class, 'edit'])->name('edit');
    Route::put('/update/{brand:slug}', [BrandController::class, 'update'])->name('update');
    Route::delete('/delete/{brand:slug}', [BrandController::class, 'destroy'])->name('delete');
  });
  Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/add', [CategoryController::class, 'create'])->name('create');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/edit/{category:slug}', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/update/{category:slug}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/delete/{category:slug}', [CategoryController::class, 'destroy'])->name('delete');
    Route::delete('/bulk-destroy', [CategoryController::class, 'bulkDestroy'])->name('bulkDestroy');
  });
  Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::get('/add', [SettingController::class, 'create'])->name('create');
    Route::post('/store', [SettingController::class, 'store'])->name('store');
    Route::get('/edit/{setting:id_setting}', [SettingController::class, 'edit'])->name('edit');
    Route::put('/update/{setting:id_setting}', [SettingController::class, 'update'])->name('update');
    Route::delete('/delete/{setting:id_setting}', [SettingController::class, 'destroy'])->name('delete');
  });
});

Route::fallback(function () {
  return abort(404, 'Page not found');
});
