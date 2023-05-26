<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\AuthGoogleController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::middleware('guest')->group(function () {
	// registration
	Route::post('/register', [AuthController::class, 'register'])->name('register.create');

	// email verification
	Route::get('/email/verify/{token}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

	// auth with Google
	Route::get('/auth/google', [AuthGoogleController::class, 'redirectToGoogleProvider'])->name('google.login');
	Route::get('/auth/google/callback', [AuthGoogleController::class, 'handleCallback'])->name('google.login.callback');
});
