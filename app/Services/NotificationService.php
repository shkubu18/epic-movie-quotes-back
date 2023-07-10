<?php

namespace App\Services;

use App\Events\NotificationAdded;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Like\LikeRequest;
use App\Models\Movie;
use App\Models\Notification;
use App\Models\Quote;
use App\Models\User;

class NotificationService
{
	public static function addNotification(StoreCommentRequest|LikeRequest $request, $notificationType): void
	{
		$movieId = Quote::where('id', $request->quote_id)->first()->movie_id;
		$receiverUserId = Movie::where('id', $movieId)->first()->user_id;

		$newNotification = Notification::create([
			'quote_id'   => $request->quote_id,
			'receiver'   => $receiverUserId,
			'sender'     => $request->user_id,
			'type'       => $notificationType,
		]);

		if ($receiverUserId !== $request->user_id) {
			$senderUser = User::where('id', $newNotification->sender)->first();

			$notification = (object)[
				'id'         => $newNotification->id,
				'quote_id'   => $request->quote_id,
				'receiver'   => $newNotification->receiver,
				'type'       => $newNotification->type,
				'read'       => false,
				'sender'     => [
					'username'        => $senderUser->username,
					'profile_picture' => $senderUser->profile_picture,
				],
				'created_at' => $newNotification->created_at,
			];

			event(new NotificationAdded($notification));
		}
	}
}
