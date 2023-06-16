<?php

namespace App\Http\Controllers;

use App\Events\Likes\LikeAdded;
use App\Events\Likes\LikeRemoved;
use App\Http\Requests\Like\LikeRequest;
use App\Models\Like;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

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

		NotificationService::addNotification($request, 'like');

		$like = ['quote_id' => (int)$request->quote_id];

		event(new LikeAdded($like));

		return response()->json(['message' => 'like added successfully']);
	}
}
