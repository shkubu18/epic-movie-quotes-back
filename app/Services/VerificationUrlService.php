<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerificationUrlService
{
	public static function generate(User $user): string
	{
		return URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(30),
			[
				'token' => $user->email_verification_token,
				'hash'  => sha1($user->getEmailForVerification()),
			]
		);
	}

	public static function generateForNewEmail(User $user): string
	{
		return URL::temporarySignedRoute(
			'email.update',
			Carbon::now()->addMinutes(60),
			[
				'token' => $user->temporary_email_verification_token,
				'hash'  => sha1($user->getEmailForVerification()),
			]
		);
	}
}
