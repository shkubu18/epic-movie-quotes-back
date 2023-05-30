<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordEmailRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'email' => 'required|exists:users,email',
		];
	}
}
