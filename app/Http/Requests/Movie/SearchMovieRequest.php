<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class SearchMovieRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'search' => 'required',
		];
	}
}
