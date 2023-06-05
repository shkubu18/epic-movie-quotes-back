<?php

namespace App\Http\Requests\Movie;

use App\Rules\EnglishText;
use App\Rules\GeorgianText;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
	public function rules(): array
	{
		return [
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
			'picture'         => 'image',
		];
	}

	public function attributes(): array
	{
		return [
			'name_en'        => 'Name in English',
			'name_ka'        => 'Name in Georgian',
			'director_en'    => 'Director',
			'director_ka'    => 'Director',
			'description_en' => 'Description',
			'description_ka' => 'Description',
		];
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'name'             => ['en' => $this->name_en, 'ka' => $this->name_ka],
			'genres'           => explode(',', $this->genres),
			'director'         => ['en' => $this->director_en, 'ka' => $this->director_ka],
			'description'      => ['en' => $this->description_en, 'ka' => $this->description_ka],
		]);
	}
}
