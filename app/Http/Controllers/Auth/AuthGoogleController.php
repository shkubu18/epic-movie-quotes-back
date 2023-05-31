<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthGoogleController extends Controller
{
	public function redirectToGoogleProvider(): RedirectResponse
	{
		return Socialite::driver('google')->stateless()->redirect();
	}

	public function handleCallback(): RedirectResponse
	{
		try {
			$googleUser = Socialite::driver('google')->stateless()->user();
		} catch (\Exception $exception) {
			return redirect(env('FRONTEND_URL'));
		}

		$existingUser = User::where('google_id', $googleUser->id)->first();

		if ($existingUser) {
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

		return redirect(env('FRONTEND_URL') . '/newsfeed');
	}
}
