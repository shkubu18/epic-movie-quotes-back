<?php

namespace App\Http\Requests\Movie;

use App\Rules\EnglishText;
use App\Rules\GeorgianText;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMovieRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'user_id'         => ['required', Rule::exists('users', 'id')],
			'name_en'         => ['required', new EnglishText],
			'name_ka'         => ['required', new GeorgianText],
			'name'            => 'array',
			'genres'          => 'required',
			'release_date'    => 'required|numeric',
			'director_en'     => ['required', new EnglishText],
			'director_ka'     => ['required', new GeorgianText],
			'director'        => 'array',
			'description_en'  => ['required', new EnglishText],
			'description_ka'  => ['required', new GeorgianText],
			'description'     => 'array',
			'picture'         => 'required|image',
		];
	}

	public function attributes(): array
	{
		return [
			'name_en'        => 'Name in English',
			'name_ka'        => 'Name in Georgian',
			'director_en'    => 'Director name in English',
			'director_ka'    => 'Director name in Georgian',
			'description_en' => 'Description in English',
			'description_ka' => 'Description in Georgian',
		];
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'user_id'         => auth()->user()->id,
			'name'            => ['en' => $this->name_en, 'ka' => $this->name_ka],
			'genres'          => explode(',', $this->genres),
			'director'        => ['en' => $this->director_en, 'ka' => $this->director_ka],
			'description'     => ['en' => $this->description_en, 'ka' => $this->description_ka],
		]);
	}
}
