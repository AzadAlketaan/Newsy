<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\Web\AuthController;
use App\Http\Controllers\APIs\Web\ArticleController;
use App\Http\Controllers\APIs\Web\UserFavoriteController;
use App\Http\Controllers\APIs\Web\SourceController;
use App\Http\Controllers\APIs\Web\CategoryController;
use App\Http\Controllers\APIs\Web\AuthorController;

Route::prefix('auth')->group(function () {
        
    Route::prefix('login')->group(function () {
        Route::POST('/', [AuthController::class, 'login'])->name('login');
    });
    
    Route::POST('signup', [AuthController::class, 'signup'])->name('signup');
    Route::POST('logout', [AuthController::class, 'logout']);
});

Route::prefix('articles')->group(function () {
    Route::GET('/', [ArticleController::class, 'index']);
    Route::GET('/newsFeed', [ArticleController::class, 'newsFeed']);
});

Route::prefix('users')->group(function () {
    Route::prefix('favorites')->group(function () {
        Route::GET('/', [UserFavoriteController::class, 'index']);
        Route::POST('/store', [UserFavoriteController::class, 'store'])->middleware('auth:api');
    });
});

Route::prefix('utils')->group(function () {
    Route::GET('/sources', [SourceController::class, 'index']);
    Route::GET('/categories', [CategoryController::class, 'index']);
    Route::GET('/authors', [AuthorController::class, 'index']);
});