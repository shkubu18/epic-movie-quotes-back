<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class EmailVerificationRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'expires' => 'required',
		];
	}
}
