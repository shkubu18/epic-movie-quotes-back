<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthGoogleController extends Controller
{
	public function redirect(): RedirectResponse
	{
		return Socialite::driver('google')->redirect();
	}

	public function callback(): RedirectResponse
	{
		try {
			$googleUser = Socialite::driver('google')->user();
		} catch (\Exception $exception) {
			return redirect(env('FRONTEND_URL'));
		}

		$existingUser = User::where('username', $googleUser->name)
			->orWhere('google_id', $googleUser->id)->first();

		if ($existingUser) {
			if ($existingUser->email !== $googleUser->email) {
				$existingUser->update(['email' => $googleUser->email]);
			}

			Auth::login($existingUser, true);
		} else {
			$newUser = User::create([
				'username'                 => $googleUser->name,
				'email'                    => $googleUser->email,
				'google_id'                => $googleUser->id,
				'email_verified_at'        => now(),
			]);

			Auth::login($newUser, true);
		}

		return redirect(env('FRONTEND_NEWSFEED_URL'));
	}
}
