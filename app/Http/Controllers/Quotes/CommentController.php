<?php

namespace App\Http\Controllers\Quotes;

use App\Events\CommentAdded;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request): JsonResponse
	{
		event(new CommentAdded(Comment::create($request->validated())));

		NotificationService::addNotification($request, 'comment');

		return response()->json(['message' => 'comment added successfully']);
	}
}
