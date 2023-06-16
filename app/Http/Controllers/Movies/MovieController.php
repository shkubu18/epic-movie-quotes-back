<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
	public function index(): array
	{
		$movies = Movie::where('user_id', Auth::user()->id)->latest()->get();

		if ($movies->isEmpty()) {
			return response()->json(['message' => 'no movies found'], 204);
		}

		return ['movies' => MovieResource::collection($movies)];
	}

	public function store(StoreMovieRequest $request): JsonResponse
	{
		try {
			$movie = DB::transaction(function () use ($request) {
				$movie = Movie::create([...$request->validated(),
					'picture'  => request()->file('picture')->store('movies/pictures'),
				]);
				return $movie;
			});

			$movie->genres()->attach($request->genres, ['created_at' => now(), 'updated_at' => now()]);

			return response()->json(['message' => 'movie created successfully'], 201);
		} catch (\Exception $e) {
			return response()->json(['message' => 'failed to create movie. Please try again later.'], 500);
		}
	}

	public function get(Movie $movie): array
	{
		$this->authorize('authorizeMovieAccess', $movie);

		return ['movie'  => MovieResource::make($movie)];
	}

	public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
	{
		$this->authorize('authorizeMovieAccess', $movie);

		try {
			DB::transaction(function () use ($request, $movie) {
				$movie->update([...$request->validated(),
					'picture'  => $request->hasFile('picture') ? request()->file('picture')->store('movies/pictures') : $movie->picture,
				]);
				return $movie;
			});

			$movie->genres()->detach();
			$movie->genres()->attach($request->genres, ['created_at' => now(), 'updated_at' => now()]);

			return response()->json(['message' => 'movie updated successfully'], 200);
		} catch (\Exception $e) {
			return response()->json(['message' => 'failed to update movie. please try again later.'], 500);
		}
	}

	public function destroy(Movie $movie): JsonResponse
	{
		$this->authorize('authorizeMovieAccess', $movie);

		$movie->delete();

		return response()->json(['message' => 'movie deleted successfully'], 200);
	}
}
