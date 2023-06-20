<?php

namespace App\Http\Requests\Quote;

use App\Rules\EnglishText;
use App\Rules\GeorgianText;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'name_en'         => ['required', new EnglishText(__('quotes.name_in_english'))],
			'name_ka'         => ['required', new GeorgianText(__('quotes.name_in_georgian'))],
			'name'            => 'array',
			'picture'         => 'image',
		];
	}

	public function attributes(): array
	{
		return [
			'name_en'        => __('quotes.name_in_english'),
			'name_ka'        => __('quotes.name_in_georgian'),
		];
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'name'     => ['en' => $this->name_en, 'ka' => $this->name_ka],
		]);
	}
}
