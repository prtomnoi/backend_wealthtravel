<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductTypeController;
use App\Http\Controllers\Api\ServiceTypeController;
use App\Http\Controllers\Api\TourTypeController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('tours', TourController::class);

Route::apiResource('services', ServiceController::class);

Route::apiResource('products', ProductController::class);

Route::apiResource('product-types', ProductTypeController::class)->only(['index', 'show']);
Route::apiResource('service-types', ServiceTypeController::class)->only(['index', 'show']);
Route::apiResource('tour-types', TourTypeController::class)->only(['index', 'show']);