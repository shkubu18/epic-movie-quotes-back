<?php

namespace App\Http\Requests\Like;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LikeRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'user_id'  => ['required', Rule::exists('users', 'id')],
			'quote_id' => ['required', Rule::exists('quotes', 'id')],
		];
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'user_id' => auth()->user()->id,
		]);
	}
}
