<?php

use Illuminate\Support\Facades\Route;

// Dashboard Route
Route::get('/', [App\Http\Controllers\DashboardController::class, 'backend_dashboard'])->name('dashboard');

// Category Resource Route
Route::resource('category', \App\Http\Controllers\Backend\CategoryController::class);
Route::get('category/status/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'status'])->name('category.status');

// Product Group Route with prefix
Route::controller(\App\Http\Controllers\Backend\ProductController::class)->prefix('product')->group(function () {
    Route::get("/data-table", "getProduct")->name('product.data.table');
    Route::get("/", "index")->name('product.index');
    Route::get("/create", "create")->name('product.create');
    Route::post("/store", "store")->name('product.store');
    Route::get("/edit/{id}", "edit")->name('product.edit');
    Route::put("/edit/{id}", "update");
    Route::delete("/delete/{id}", "destroy")->name('product.destroy');
    Route::get("/status/{id}", "status")->name('product.status');
});

// Cart
Route::get("/cart", [\App\Http\Controllers\Backend\CartController::class, 'cart'])->name('cart.index');
Route::post("/add-to-cart", [\App\Http\Controllers\Backend\CartController::class, 'add_to_cart'])->name('add.to.cart');
Route::get("/product/remove/{id}", [\App\Http\Controllers\Backend\CartController::class, 'remove_from_cart'])->name('cart.from.cart');

