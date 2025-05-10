<?php

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Auth\ForgotPasswordController;
use App\Http\Controllers\Web\Auth\GoogleAuthController;
use App\Http\Controllers\Web\FileLinks\FileLinkController;
use App\Http\Controllers\Web\Files\FileController;
use App\Http\Controllers\Web\MainPageController;
use App\Http\Controllers\Web\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'registration']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');


Route::middleware(['auth'])->group(function () {
    Route::get('/main', [MainPageController::class, 'showMainPage'])->name('main');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/files/upload-file', [FileController::class, 'upload'])->name('upload.file');
    Route::delete('/files/{id}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::post('/files/{id}/generate-link', [FileLinkController::class, 'generateLink']);
    Route::get('/files/{fileId}', [FileController::class, 'getFileDetails']);
});

Route::get('/files/view/{fileName}/{token}', [FileLinkController::class, 'viewFile']);
