<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendVerificationEmailRequest;
use App\Http\Requests\Email\EmailVerificationRequest;
use App\Http\Requests\Email\UpdateUserEmailRequest;
use App\Mail\EmailVerification;
use App\Models\User;
use App\Services\VerificationUrlService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
	public function verify(EmailVerificationRequest $request, string $token): JsonResponse
	{
		$expirationDateTime = Carbon::createFromTimestamp($request->expires);

		try {
			if ($expirationDateTime->isPast()) {
				return response()->json(['message' => 'email verification link is expired'], 410);
			}

			event(new Verified(User::where('email_verification_token', $token)->firstOrFail()));

			return response()->json(['message' => 'email verified successfully']);
		} catch (\Exception $exception) {
			return response()->json($exception->getMessage(), 409);
		}
	}

	public function resendVerificationEmail(ResendVerificationEmailRequest $request): JsonResponse
	{
		$user = User::where('email', $request->email)->first();

		$verificationToken = Str::after(VerificationUrlService::generate($user), 'verify/');

		try {
			Mail::to($user->email)->send(new EmailVerification($verificationToken, $user->username, $user->email));
		} catch (\Exception) {
			$user->delete();
			return response()->json(['message' => __('email.sending_failed')], 500);
		}

		return response()->json(['message' => 'email verification link sent successfully']);
	}

	public function updateUserEmail(UpdateUserEmailRequest $request, string $token): JsonResponse
	{
		$expirationDateTime = Carbon::createFromTimestamp($request->expires);

		if ($expirationDateTime->isPast()) {
			return response()->json(['message' => 'email verification link is expired'], 403);
		}

		try {
			$user = User::where('temporary_email_verification_token', $token)->firstOrFail();

			$user->update([
				'email'                              => $user->temporary_email,
				'email_verified_at'                  => now(),
				'temporary_email'                    => null,
				'temporary_email_verification_token' => null,
			]);

			return response()->json(['message' => 'email updated successfully']);
		} catch (\Exception) {
			return response()->json(['message' => 'email is already updated'], 403);
		}
	}
}
