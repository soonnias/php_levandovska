<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('welcome');
});

use App\Http\Controllers\LabController;
use App\Http\Middleware\CheckAge;

use App\Http\Middleware\CheckName;

Route::get('/lab1', [LabController::class, 'index']);
Route::get('/about', [LabController::class, 'about'])->middleware(CheckAge::class);;
Route::get('/contact', [LabController::class, 'contact']);
Route::get('/hobbies', [LabController::class, 'hobbies'])->middleware(CheckName::class);;
