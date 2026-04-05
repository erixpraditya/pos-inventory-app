<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.app');
// });

Route::redirect('/', '/categories');
Route::resource('/categories', CategoryController::class);
Route::resource('/products', ProductController::class);
