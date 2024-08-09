<?php

use App\Http\Middleware\HandleAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers as AppController;
use App\Http\Controllers\SuperAdmin as AppSuperAdminController;

Route::get('/login', AppController\AuthController::class . '@loginForm')->name('login');
Route::post('/login', AppController\AuthController::class . '@login');
Route::get('/logout', AppController\AuthController::class . '@logout')->name('logout');
Route::middleware(HandleAuth::class)->group(function(){
    // admin & staff
    Route::get('/', [AppController\AuthController::class, 'loginForm']);
    Route::get('/profile', function () {
        return view('profile');
    });
    Route::resource('serviceType', AppController\ServiceTypeController::class);
    Route::resource('service', AppController\ServiceController::class);
    Route::resource('productType', AppController\ProductTypeController::class);
    Route::resource('product', AppController\ProductController::class);
    Route::resource('tourType', AppController\TourTypeController::class);
    Route::resource('tour', AppController\TourController::class);
    Route::delete('/attachment/{id}', [AppController\AttachmentController::class, 'destroy']);

    // city by contry
    Route::get('/cityByContry/{iso}', [AppController\CityController::class, 'cityByContry']);

    // superadmin function
    Route::resource('permission', AppSuperAdminController\PermissionController::class);
});


