<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordUpdateRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'password'                      => ['required', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/'],
			'password_confirmation'         => ['required_with:password', 'same:password'],
		];
	}
}
