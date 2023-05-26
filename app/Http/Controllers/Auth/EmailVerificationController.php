<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;

class EmailVerificationController extends Controller
{
	public function verify(string $token): JsonResponse
	{
		event(new Verified(User::where('email_verification_token', $token)->firstOrFail()));

		return response()->json(['message' => 'Email successfully verified'], 200);
	}
}
