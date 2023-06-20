<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GeorgianText implements Rule
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
		return preg_match('/^[ა-ჰ0-9_\'";?!:.,\s-]+$/', $value);
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		return __('letters.georgian_letters', ['attribute' => $this->attributeName]);
	}
}
