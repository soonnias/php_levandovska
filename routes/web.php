<?php

use Illuminate\Support\Facades\Route;

// default path
Route::get('/', function(){
    return redirect()->route('posts.index');
});

use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserPostController;

Route::resource('userPosts', UserPostController::class);
Route::resource('posts', PostController::class);
Route::resource('categories', CategoryController::class);
Route::resource('users', UserController::class);
Route::post('/users/set-current', [UserController::class, 'setCurrent'])->name('users.setCurrent');

// comments
Route::resource('comments', CommentController::class)->only(['index', 'store', 'destroy']);
Route::get('posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// likes
Route::post('/likes', [LikeController::class, 'store'])->name('likes.store');
Route::delete('/likes/{post}/{user}', [LikeController::class, 'destroy'])->name('likes.destroy');

// Обробка неіснуючих маршрутів
Route::fallback(function() {
    return redirect()->route('posts.index'); 
});

