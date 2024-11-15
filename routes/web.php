<?php

use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Головна сторінка
Route::get('/', function () {
    return view('auth.login');
});

// Група маршрутів, захищених аутентифікацією
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Доступ для 'user'
    Route::middleware([RoleMiddleware::class.':user'])->group(function () {
        Route::resource('userPosts', UserPostController::class)->only(['index', 'store', 'show', 'edit', 'update', 'destroy']);
        Route::post('posts/{post}/likes/toggle', [LikeController::class, 'toggle'])->name('likes.toggle');
        Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    });

    // Доступ для 'admin' \
    Route::middleware([RoleMiddleware::class.':admin'])->group(function () {
        Route::resource('posts', PostController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);

        Route::post('/users/set-current', [UserController::class, 'setCurrent'])->name('users.setCurrent');

        // Лайки
        Route::post('/likes', [LikeController::class, 'store'])->name('likes.store');
        Route::delete('/likes/{post}/{user}', [LikeController::class, 'destroy'])->name('likes.destroy');

        Route::resource('category-products', CategoryProductController::class);
        Route::resource('products', ProductController::class);
    });

    // Коментарі
    Route::get('posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Усі товари
    Route::get('/user-products', [UserProductController::class, 'index'])->name('userProducts.index');
    Route::get('/user-products/{id}', [UserProductController::class, 'show'])->name('userProducts.show');

    // Кошик
    Route::prefix('cart')->group(function () {
        // Показати кошик
        Route::get('/{userId}', [CartController::class, 'show'])->name('carts.show');
        // Створити кошик для користувача
        Route::post('/create/{userId}', [CartController::class, 'create'])->name('carts.create');
        // Очистити кошик
        Route::delete('/{userId}/clear', [CartController::class, 'clear'])->name('carts.clear');
    });

// Елементи кошика
    Route::prefix('cart/{cartId}/items')->group(function () {
        // Додати товар у кошик
        Route::post('/', [CartItemController::class, 'store'])->name('cartItems.store');
        // Видалити товар з кошика
        Route::delete('/{itemId}', [CartItemController::class, 'destroy'])->name('cartItems.destroy');
        // Оновити кількість товару
        Route::patch('/{itemId}', [CartItemController::class, 'update'])->name('cartItems.update');
    });
});

// Обробка неіснуючих маршрутів
Route::fallback(function() {
    return redirect()->route('posts.index');
});

// Підключення маршрутів аутентифікації
require __DIR__.'/auth.php';
