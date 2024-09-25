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

use App\Http\Controllers\CommentController;

// Додати маршрут для встановлення користувача
Route::post('set-user', function () {
    session(['user_id' => 2]); // Встановіть ID користувача, якого хочете використовувати (тут 1 - це приклад)
    return redirect()->back()->with('success', 'Користувача встановлено.');
})->name('set.user');


Route::resource('comments', CommentController::class)->only(['index', 'store', 'destroy']);
Route::get('posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
