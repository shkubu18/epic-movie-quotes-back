<?php

namespace App\Http\Requests\Quote;

use Illuminate\Foundation\Http\FormRequest;

class SearchQuoteRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'search'     => 'required',
		];
	}
}
