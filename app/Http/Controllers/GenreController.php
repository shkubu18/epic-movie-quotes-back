<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
	public function get(): JsonResponse
	{
		return response()->json(['genres' => Genre::all()], 200);
	}
}
