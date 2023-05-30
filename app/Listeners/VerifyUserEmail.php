<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class VerifyUserEmail
{
	/**
	 * Handle the event.
	 */
	public function handle(Verified $event): void
	{
		if ($event->user instanceof MustVerifyEmail && !$event->user->hasVerifiedEmail()) {
			$event->user->markEmailAsVerified();
		}
	}
}
