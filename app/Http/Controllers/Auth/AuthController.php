<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Mail\EmailVerification;
use App\Models\User;
use App\Services\VerificationUrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
	public function register(RegistrationRequest $request): JsonResponse
	{
		$user = User::create($request->validated());

		$verificationUrl = VerificationUrlService::generate($user);

		try {
			Mail::to($user->email)->send(new EmailVerification($verificationUrl, $user->username));
		} catch (\Exception $e) {
			$user->delete();
			return response()->json(['message' => 'failed to send email verification link'], 500);
		}

		return response()->json(['message' => 'user created successfully'], 201);
	}
}
