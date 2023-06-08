<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request): JsonResponse
	{
		Comment::create($request->validated());

		return response()->json(['message' => 'comment added successfully']);
	}
}
