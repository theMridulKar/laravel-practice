<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\ProductController::class)->group(function () {
    Route::get("/", "index")->name('product.index');
    Route::get("/create", "create")->name('product.create');
    Route::post("/create", "store");
    Route::get("/edit/{id}", "edit")->name('product.edit');
    Route::put("/edit/{id}", "update");
    Route::get("/delete/{id}", "destroy")->name('product.destroy');
    Route::get("/status/{id}", "status")->name('product.status');
});
