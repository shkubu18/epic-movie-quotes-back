<?php

namespace App\Http\Controllers;

use App\Http\Requests\Like\LikeRequest;
use App\Models\Like;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
	public function like(LikeRequest $request): JsonResponse
	{
		$existingLike = Like::where('user_id', $request->user_id)->where('quote_id', $request->quote_id)->first();

		if ($existingLike) {
			$existingLike->delete();

			return response()->json(['message' => 'existing like deleted successfully']);
		}

		Like::create($request->validated());

		return response()->json(['message' => 'like added successfully']);
	}
}
