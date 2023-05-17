<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::resource('/posts', PostController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('/user/posts', UserPostController::class);
    Route::post('/posts/{id}/comments/create', [CommentController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/posts/search/{id}', [PostController::class, 'search']);
