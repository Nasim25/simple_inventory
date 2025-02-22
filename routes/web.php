<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(SupplierController::class)->prefix('supplier')->group(function () {
        Route::get('/', 'index')->name('supplier.index');
        Route::get('/list', 'getSuppliers')->name('suppliers.list');
        Route::post('/store', 'store')->name('suppliers.store');
    });

    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('/', 'index')->name('products.index');
        Route::get('/list', 'getProducts')->name('products.list');
        Route::post('/store', 'store')->name('products.store');
    });

    Route::controller(PurchaseController::class)->prefix('purchase')->group(function () {
        Route::get('/', 'index')->name('purchase.index');
        Route::get('/create', 'create')->name('purchase.create');
        Route::get('/view/{id}', 'getProductById')->name('purchase.view');
        Route::get('/list', 'getPurchases')->name('purchase.list');
        Route::post('/store', 'store')->name('purchase.store');
    });
});

require __DIR__ . '/auth.php';
