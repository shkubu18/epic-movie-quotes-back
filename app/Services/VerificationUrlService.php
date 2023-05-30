<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerificationUrlService
{
	public static function generate(User $user): string
	{
		return URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'token' => $user->email_verification_token,
				'hash'  => sha1($user->getEmailForVerification()),
			]
		);
	}
}
