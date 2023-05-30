<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordEmailRequest;
use App\Http\Requests\Auth\ResetPasswordUpdateRequest;
use App\Mail\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
	public function sendResetPasswordEmail(ResetPasswordEmailRequest $request): JsonResponse
	{
		$existingEmail = DB::table('password_reset_tokens')->where('email', $request->email)->first();

		if ($existingEmail) {
			return response()->json(['message' => 'reset password email is already sent'], 402);
		}

		$token = Str::random(64);

		DB::table('password_reset_tokens')->insert([
			'email'      => $request->email,
			'token'      => $token,
			'created_at' => Carbon::now(),
		]);

		$user = User::where('email', $request->email)->first();

		try {
			Mail::to($request->email)->send(new ResetPassword($token, $user->username));
		} catch (\Exception $e) {
			DB::table('password_reset_tokens')->delete();
			return response()->json(['message' => 'failed to send reset password email'], 500);
		}

		return response()->json(['message' => 'email sent successfully'], 200);
	}

	public function updatePassword(ResetPasswordUpdateRequest $request): JsonResponse
	{
		if (!DB::table('password_reset_tokens')->where(['token' => $request->token])->first()) {
			return response()->json('Unauthorized action', 403);
		}

		$userEmail = DB::table('password_reset_tokens')->first()->email;

		$user = User::where('email', $userEmail)->firstOrFail()->update(['password' => $request->password]);

		DB::table('password_reset_tokens')->where(['token' => $request->token])->delete();

		return response()->json('Password updated successfully', 201);
	}
}
