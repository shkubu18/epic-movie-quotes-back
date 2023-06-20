<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnglishText implements Rule
{
	public function __construct(public string $attributeName)
	{
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param string $attribute
	 * @param mixed  $value
	 *
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		return preg_match('/^[a-zA-Z0-9_\'";?!:.,\s-]+$/', $value);
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		return __('letters.english_letters', ['attribute' => $this->attributeName]);
	}
}
