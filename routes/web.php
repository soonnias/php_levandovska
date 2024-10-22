<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserPostController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Головна сторінка
Route::get('/', function () {
    return view('auth.login');
});

// Сторінка Dashboard з перевіркою аутентифікації
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    });

    // Коментарі
    Route::get('posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Обробка неіснуючих маршрутів
Route::fallback(function() {
    return redirect()->route('posts.index'); 
});

// Підключення маршрутів аутентифікації
require __DIR__.'/auth.php';
