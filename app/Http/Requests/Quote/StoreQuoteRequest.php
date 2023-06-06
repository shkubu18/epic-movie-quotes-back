<?php

namespace App\Http\Requests\Quote;

use App\Rules\EnglishText;
use App\Rules\GeorgianText;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuoteRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'name_en'         => ['required', new EnglishText],
			'name_ka'         => ['required', new GeorgianText],
			'name'            => 'array',
			'movie_id'        => ['required', Rule::exists('movies', 'id')],
			'picture'         => 'required|image',
		];
	}

	public function attributes(): array
	{
		return [
			'name_en'        => 'Name in English',
			'name_ka'        => 'Name in Georgian',
		];
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'name'     => ['en' => $this->name_en, 'ka' => $this->name_ka],
		]);
	}
}
