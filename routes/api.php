<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Movies\GenreController;
use App\Http\Controllers\Movies\MovieController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Quotes\CommentController;
use App\Http\Controllers\Quotes\LikeController;
use App\Http\Controllers\Quotes\QuoteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::controller(EmailVerificationController::class)->prefix('email')->group(function () {
	Route::get('verify/{token}/{hash}', 'verify')->name('verification.verify');
	Route::post('resend/verify-email', 'resendVerificationEmail')->name('verification.resend');
});

// password reset
Route::controller(ResetPasswordController::class)->prefix('password')->group(function () {
	Route::post('email', 'sendResetPasswordEmail')->name('password.email');
	Route::post('update', 'updatePassword')->name('password.update');
});

// language
Route::get('locale/{language}', [LanguageController::class, 'setLocale'])->name('locale');

Route::middleware('auth:sanctum')->group(function () {
	Route::get('/user', [UserController::class, 'getUser'])->name('user');
	Route::get('/authenticated', function () {
		return true;
	});

	// logout
	Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

	// movies
	Route::controller(MovieController::class)->prefix('movies')->group(function () {
		Route::get('/', 'index')->name('movies.index');
		Route::post('/', 'store')->name('movies.store');
		Route::get('{movie}', 'get')->name('movies.get');
		Route::post('{movie}', 'update')->name('movies.update');
		Route::delete('/{movie}', 'destroy')->name('movies.destroy');
	});

	// genres
	Route::get('genres', [GenreController::class, 'get'])->name('genres.get');

	// quotes
	Route::controller(QuoteController::class)->prefix('quotes')->group(function () {
		Route::get('/', 'index')->name('quotes.index');
		Route::post('/', 'store')->name('quotes.store');
		Route::get('{quote}', 'get')->name('quotes.get');
		Route::post('{quote}', 'update')->name('quotes.update');
		Route::delete('/{quote}', 'destroy')->name('quotes.destroy');
		Route::get('search', 'searchQuotes')->name('quotes.search');
	});

	// comments
	Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

	// likes
	Route::controller(LikeController::class)->prefix('likes')->group(function () {
		Route::post('/', 'like')->name('like');
		Route::get('/quotes', 'getLikedQuotes')->name('like.quotes');
	});

	// notifications
	Route::controller(NotificationController::class)->prefix('notifications')->group(function () {
		Route::get('/', 'index')->name('notifications.index');
		Route::post('/{notification}/mark-as-read', 'markAsRead')->name('notifications.mark_as_read');
		Route::delete('/{notification}', 'destroy')->name('notifications.destroy');
	});
});
