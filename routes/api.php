<?php

use App\Http\Controllers\Auth\Api\AuthApiController;
use App\Http\Controllers\Auth\Api\ForgotPasswordApiController;
use App\Http\Controllers\Users\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthApiController::class, 'register']);
    Route::post('/login', [AuthApiController::class, 'login']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    Route::post('/password/email', [ForgotPasswordApiController::class, 'sendResetLinkEmail']);
    Route::post('/password/reset', [ForgotPasswordApiController::class, 'resetPassword']);
});

Route::put('/users/{id}', [UserApiController::class, 'update']);
