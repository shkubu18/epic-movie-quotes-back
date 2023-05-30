<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// registration
Route::post('/register', [AuthController::class, 'register'])->name('register.create');

// authorization
Route::post('/login', [AuthController::class, 'login'])->name('login');

// email verification
Route::get('/email/verify/{token}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

// password reset
Route::controller(ResetPasswordController::class)->prefix('password')->group(function () {
	Route::post('email', 'sendResetPasswordEmail')->name('password.email');
	Route::get('reset/{token}', 'showResetPasswordForm')->name('password.reset');
	Route::post('update', 'updatePassword')->name('password.update');
});

Route::middleware('auth:sanctum')->group(function () {
	// logout
	Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
