<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('welcome');
});


use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
//use App\Http\Middleware\CheckAge;
//Route::get('/about', [LabController::class, 'about'])->middleware(CheckAge::class);;

use App\Http\Controllers\UserController;

Route::resource('posts', PostController::class);
Route::resource('categories', CategoryController::class);
Route::resource('users', UserController::class);
