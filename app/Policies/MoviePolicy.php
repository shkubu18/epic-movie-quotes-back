<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MoviePolicy
{
	public function authorizeMovieAccess(User $user, Movie $movie): Response
	{
		return $user->id === $movie->user_id
			? Response::allow()
			: Response::deny(__('messages.movie_access'));
	}
}
