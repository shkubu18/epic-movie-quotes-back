<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\EmailVerification;
use App\Models\User;
use App\Services\VerificationUrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
	public function getUser(Request $request)
	{
		return ['user'  => UserResource::make($request->user())];
	}

	public function update(UpdateUserRequest $request, User $user): JsonResponse
	{
		$validatedData = $request->validated();

		if (isset($validatedData['email'])) {
			unset($validatedData['email']);
			$validatedData['temporary_email'] = $request->email;
			$validatedData['temporary_email_verification_token'] = Str::uuid()->toString();
		}

		$user->update([
			...$validatedData,
			'profile_picture' => $request->hasFile('profile_picture') ? request()->file('profile_picture')->store('users/pictures') : $user->profile_picture,
		]);

		if ($request->email) {
			try {
				$verificationToken = Str::after(VerificationUrlService::generateForNewEmail($user), 'update/');

				Mail::to($user->temporary_email)->send(new EmailVerification($verificationToken, $user->username, $user->temporary_email, 'new'));

				return response()->json(['message' => 'verification email sent successfully']);
			} catch (\Exception) {
				return response()->json(['message' => __('email.sending_failed')], 500);
			}
		}

		return response()->json(['message' => 'user updated successfully']);
	}
}
