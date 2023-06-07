<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenreResource;
use App\Models\Genre;

class GenreController extends Controller
{
	public function get(): array
	{
		return ['genres' => GenreResource::collection(Genre::all())];
	}
}
