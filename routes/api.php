<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('posts', [PostController::class, 'index']);


Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('comment', [CommentController::class, 'store']);


    Route::post('posts', [PostController::class, 'store']);
    Route::middleware(['post.owner'])->group(function () {
        Route::put('posts/{id}', [PostController::class, 'update']);
        Route::delete('posts/{id}', [PostController::class, 'destroy']);
    });

    Route::middleware(['comment.owner'])->group(function () {
        Route::put('comment', [CommentController::class, 'update']);
        Route::delete('comment/{id}', [CommentController::class, 'destroy']);
    });
});