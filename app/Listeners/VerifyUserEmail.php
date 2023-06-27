<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Validation\ValidationException;

class VerifyUserEmail
{
	/**
	 * Handle the event.
	 *
	 * @throws ValidationException
	 */
	public function handle(Verified $event): void
	{
		if ($event->user instanceof MustVerifyEmail && !$event->user->hasVerifiedEmail()) {
			$event->user->markEmailAsVerified();
		} else {
			throw ValidationException::withMessages(['message' => 'Your email is already verified']);
		}
	}
}
