<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/login', function () {
    return view('sign-in');
});
