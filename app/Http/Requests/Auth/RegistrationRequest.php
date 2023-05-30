<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RegistrationRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'username'                      => ['required', 'min:3', 'max:15', 'regex:/^[a-z0-9 ]+$/', 'unique:users'],
			'email'                         => ['required', 'email', 'unique:users'],
			'email_verification_token'      => ['required', 'string'],
			'password'                      => ['required', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/'],
			'password_confirmation'         => ['required_with:password', 'same:password'],
		];
	}

	protected function prepareForValidation(): void
	{
		$this->merge([
			'email_verification_token' => Str::uuid()->toString(),
		]);
	}
}
