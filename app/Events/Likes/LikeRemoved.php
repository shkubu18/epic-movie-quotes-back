<?php

namespace App\Events\Likes;

use App\Models\Movie;
use App\Models\Notification;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LikeRemoved implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Create a new event instance.
	 */
	public function __construct(public object $removedLike)
	{
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array<int, Channel>
	 */
	public function broadcastOn(): array
	{
		return [
			new Channel('likes'),
		];
	}

	/**
	 * Get the data to broadcast.
	 */
	public function broadcastWith(): array
	{
		$movieId = Quote::where('id', $this->removedLike->quote_id)->first()->movie_id;
		$receiverUserId = Movie::where('id', $movieId)->first()->user_id;

		$notification = Notification::where('quote_id', $this->removedLike->quote_id)
			->where('receiver', $receiverUserId)
			->where('sender', $this->removedLike->user_id)
			->where('type', 'like')->first();

		$senderUser = User::where('id', $this->removedLike->user_id)->first();

		$broadcastData = [
			'quote_id'    => (int)$this->removedLike->quote_id,
			'sender'      => $senderUser->username,
		];

		if ($notification) {
			$broadcastData['notification_id'] = $notification->id;
		}

		return $broadcastData;
	}
}
