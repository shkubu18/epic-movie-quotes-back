<?php

use App\Http\Controllers\Auth\AuthGoogleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

// auth with Google
Route::controller(AuthGoogleController::class)->prefix('oauth/google')->group(function () {
	Route::get('redirect', 'redirectToGoogleProvider')->name('google.redirect');
	Route::get('callback', 'handleCallback')->name('google.callback');
});
