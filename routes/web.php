<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('posts.index') : view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/like-ajax', [LikeController::class, 'likeAjax'])->name('posts.like.ajax');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/posts/{post}/comments-ajax', [CommentController::class, 'storeAjax'])->name('comments.store.ajax');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::delete('/comments/{comment}/ajax', [CommentController::class, 'destroyAjax'])->name('comments.destroy.ajax');

    Route::post('/users/{user}/follow', [FollowController::class, 'follow'])->name('users.follow');
    Route::post('/users/{user}/follow-ajax', [FollowController::class, 'followAjax'])->name('users.follow.ajax');

    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');