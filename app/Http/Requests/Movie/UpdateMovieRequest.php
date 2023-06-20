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
			'name_en'         => ['required', new EnglishText(__('movies.name_in_english'))],
			'name_ka'         => ['required', new GeorgianText(__('movies.name_in_georgian'))],
			'name'            => 'array',
			'genres'          => 'required',
			'release_date'    => 'required|numeric',
			'director_en'     => ['required', new EnglishText(__('movies.director_in_english'))],
			'director_ka'     => ['required', new GeorgianText(__('movies.director_in_georgian'))],
			'director'        => 'array',
			'description_en'  => ['required', new EnglishText(__('movies.description_in_english'))],
			'description_ka'  => ['required', new GeorgianText(__('movies.description_in_georgian'))],
			'description'     => 'array',
			'picture'         => 'image',
		];
	}

	public function attributes(): array
	{
		return [
			'name_en'        => __('movies.name_in_english'),
			'name_ka'        => __('movies.name_in_georgian'),
			'director_en'    => __('movies.director_in_english'),
			'director_ka'    => __('movies.director_in_georgian'),
			'description_en' => __('movies.description_in_english'),
			'description_ka' => __('movies.description_in_georgian'),
		];
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'name'             => ['en' => $this->name_en, 'ka' => $this->name_ka],
			'genres'           => $this->genres ? explode(',', $this->genres) : null,
			'director'         => ['en' => $this->director_en, 'ka' => $this->director_ka],
			'description'      => ['en' => $this->description_en, 'ka' => $this->description_ka],
		]);
	}
}
