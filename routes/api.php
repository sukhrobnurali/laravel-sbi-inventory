<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::apiResources([
    'categories' => CategoryController::class,
    'products' => ProductController::class
]);
