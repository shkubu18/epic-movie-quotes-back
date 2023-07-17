<?php

namespace App\Http\Controllers;

use App\Events\Likes\LikeAdded;
use App\Events\Likes\LikeRemoved;
use App\Http\Requests\Like\LikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Like;
use App\Models\Movie;
use App\Models\Quote;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
	public function like(LikeRequest $request): JsonResponse
	{
		$existingLike = Like::where('user_id', $request->user_id)->where('quote_id', $request->quote_id)->first();

		if ($existingLike) {
			$existingLike->delete();

			$removedLike = (object)['quote_id' => $request->quote_id, 'user_id'  => $request->user_id];

			event(new LikeRemoved($removedLike));

			return response()->json(['message' => 'existing like deleted successfully']);
		}

		Like::create($request->validated());

		$movieId = Quote::where('id', $request->quote_id)->first()->movie_id;
		$likedQuoteAuthorId = Movie::where('id', $movieId)->first()->user_id;

		if ($request->user_id !== $likedQuoteAuthorId) {
			NotificationService::addNotification($request, 'like');
		}

		$like = ['quote_id' => (int)$request->quote_id, 'sender' => Auth::user()->username];

		event(new LikeAdded($like));

		return response()->json(['message' => 'like added successfully'], 201);
	}

	public function getLikedQuotes(): JsonResponse
	{
		$likedQuotes = Auth::user()->likes()->pluck('quote_id')->toArray();

		return response()->json(LikeResource::make($likedQuotes));
	}
}
