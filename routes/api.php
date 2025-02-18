<?php

use App\Http\Controllers\Auth\Api\AuthApiController;
use App\Http\Controllers\Auth\Api\ForgotPasswordApiController;
use App\Http\Controllers\Files\Api\FileApiController;
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


Route::prefix('users')->group(function () {
    Route::get('/{user_id}/files', [FileApiController::class, 'getUserFiles']);
    Route::get('/{user_id}/files/total-count', [FileApiController::class, 'getUserFilesCount']);
    Route::get('/{user_id}/files/total-views', [FileApiController::class, 'getTotalViews']);
    Route::get('/{user_id}/files/existing-count', [FileApiController::class, 'getExistingFilesCount']);
    Route::get('/{user_id}/files/deleted-count', [FileApiController::class, 'getDeletedFilesCount']);
    Route::put('/{id}', [UserApiController::class, 'update']);
    Route::delete('/{userId}/files/{fileId}', [FileApiController::class, 'delete']);
});


Route::prefix('files')->group(function () {
    Route::get('/{id}', [FileApiController::class, 'getFileDetails']);
    Route::post('/upload', [FileApiController::class, 'upload']);
});
