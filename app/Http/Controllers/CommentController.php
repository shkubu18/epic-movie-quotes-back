<?php

namespace App\Http\Controllers;

use App\Events\CommentAdded;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Movie;
use App\Models\Quote;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request): JsonResponse
	{
		event(new CommentAdded(Comment::create($request->validated())));

		$movieId = Quote::where('id', $request->quote_id)->first()->movie_id;
		$commentedQuoteAuthorId = Movie::where('id', $movieId)->first()->user_id;

		if ($request->user_id !== $commentedQuoteAuthorId) {
			NotificationService::addNotification($request, 'comment');
		}

		return response()->json(['message' => 'comment added successfully'], 201);
	}
}
