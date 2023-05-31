<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthService
{
	public static function checkEmailVerification(LoginRequest $request): void
	{
		if (!User::where($request->login_type, $request->username_or_email)->first()->hasVerifiedEmail()) {
			auth()->logout();
			throw ValidationException::withMessages([
				'email_verify' => 'Your email is not verified. Please verify your email before logging in',
			]);
		}
	}
}
