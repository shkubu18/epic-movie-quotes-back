<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthGoogleController extends Controller
{
	public function redirectToGoogleProvider(): RedirectResponse
	{
		return Socialite::driver('google')->stateless()->redirect();
	}

	public function handleCallback(): JsonResponse
	{
		try {
			$user = Socialite::driver('google')->stateless()->user();
		} catch (\Exception $exception) {
			return response()->json(['message' => 'Authentication failed'], 500);
		}

		$existingUser = User::where('google_id', $user->id)->first();

		if ($existingUser) {
			Auth::login($existingUser, true);
		} else {
			$newUser = User::create([
				'username'                 => $user->name,
				'email'                    => $user->email,
				'google_id'                => $user->id,
			]);

			Auth::login($newUser, true);
		}

		session()->regenerate();

		return response()->json(['message' => 'Authentication successful'], 200);
	}
}
