<?php

namespace App\Policies;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuotePolicy
{
	public function authorizeQuoteAccess(User $user, Quote $quote): Response
	{
		return $user->id === $quote->movie->user_id
			? Response::allow()
			: Response::deny(__('messages.quote_access'));
	}

	public function create(User $user, $movieId): Response
	{
		return $user->movies()->where('id', $movieId)->exists()
			? Response::allow()
			: Response::deny(__('messages.movie_access'));
	}
}
