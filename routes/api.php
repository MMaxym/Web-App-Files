<?php

use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Api\Auth\ForgotPasswordApiController;
use App\Http\Controllers\Api\FileLinks\FileLinkApiController;
use App\Http\Controllers\Api\Files\FileApiController;
use App\Http\Controllers\Api\Users\UserApiController;
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
    Route::get('/{user_id}/file-links/disposable-links-count', [FileLinkApiController::class, 'getTotalDisposableLinksCount']);
    Route::get('/{user_id}/file-links/used-disposable-links-count', [FileLinkApiController::class, 'getUsedDisposableLinksCount']);
    Route::put('/{id}', [UserApiController::class, 'update']);
    Route::delete('/{userId}/files/{fileId}', [FileApiController::class, 'delete']);
});


Route::prefix('files')->group(function () {
    Route::get('/{id}', [FileApiController::class, 'getFileDetails']);
    Route::get('/view/{fileName}/{token}', [FileLinkApiController::class, 'viewFileByToken']);
    Route::post('/upload', [FileApiController::class, 'upload']);
    Route::post('/{id}/generate-link', [FileLinkApiController::class, 'generateLink']);
});

