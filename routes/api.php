<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProductController;

 Route::get('/menuList', [CategoryController::class, 'menuList']);
 Route::get('/sliders', [HomeController::class, 'sliders']);
 Route::get('/homeCategoryProducts', [HomeController::class, 'homeCategoryProducts']);
 Route::get('/homeCategory', [CategoryController::class, 'homeCategory']);
 Route::get('/category/{category_name}', [CategoryController::class, 'categoryProducts']);
 Route::get('/product/{product_name}', [ProductController::class, 'Products']);
 Route::get('/allProducts', [ProductController::class, 'allProducts']);
 Route::get('/productSearch', [ProductController::class, 'productSearch']);
 Route::get('/singleProductRightCategory/{product_id}', [ProductController::class, 'singleProductRightCategory']);
 