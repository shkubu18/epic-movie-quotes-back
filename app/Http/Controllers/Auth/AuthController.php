<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Mail\EmailVerification;
use App\Models\User;
use App\Services\AuthService;
use App\Services\VerificationUrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
	public function login(LoginRequest $request): JsonResponse
	{
		$user = User::where($request->login_type, $request->username_or_email)->first();

		if ($user && Hash::check($request->password, $user->password)) {
			Auth::login($user, $request->remember);

			AuthService::checkEmailVerification($request);

			session()->regenerate();

			return response()->json([
				'message' => 'authorization successfully',
				'user'    => UserResource::make(Auth::user()),
			], 200);
		} else {
			return response()->json(['message' => __('auth.incorrect_credentials')], 422);
		}
	}

	public function logout(): JsonResponse
	{
		Auth::guard('web')->logout();

		return response()->json(['message' => 'logout successfully'], 200);
	}

	public function register(RegistrationRequest $request): JsonResponse
	{
		$user = User::create($request->validated());

		$verificationToken = Str::after(VerificationUrlService::generate($user), 'verify/');

		try {
			Mail::to($user->email)->send(new EmailVerification($verificationToken, $user->username, $user->email));
		} catch (\Exception $e) {
			$user->delete();
			return response()->json(['message' => __('email.sending_failed')], 500);
		}

		return response()->json(['message' => 'user created successfully'], 201);
	}
}
