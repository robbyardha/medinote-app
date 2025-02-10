<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiPostController;
use App\Http\Controllers\Api\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('/user', ApiUserController::class);
Route::resource('/post', ApiPostController::class);
Route::post('/show-comment-post', [ApiPostController::class, 'showCommentDetailPost']);
Route::post('/like-post', [ApiPostController::class, 'likePost']);
Route::post('/comment-post', [ApiPostController::class, 'commentPost']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::get('/logout', [ApiAuthController::class, 'logout']);
