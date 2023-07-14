<?php

namespace App\Http\Requests\User;

use App\Rules\NotSamePassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'username'                      => ['min:3', 'max:15', 'regex:/^[a-z0-9 ]+$/', 'unique:users'],
			'email'                         => ['email', 'unique:users'],
			'password'                      => ['min:8', 'max:15', 'regex:/^[a-z0-9]+$/', new NotSamePassword],
			'password_confirmation'         => ['required_with:password', 'same:password'],
			'picture'                       => ['image'],
		];
	}
}
