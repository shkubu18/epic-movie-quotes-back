<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentAdded implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Create a new event instance.
	 */
	public function __construct(public string $comment)
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
			new Channel('comments'),
		];
	}

	/**
	 * Get the data to broadcast.
	 */
	public function broadcastWith(): array
	{
		$senderUser = User::where('id', $this->comment->user_id)->first();

		return [
			'id'       => $this->comment->id,
			'quote_id' => (int)$this->comment->quote_id,
			'body'     => $this->comment->body,
			'sender'   => [
				'username'        => $senderUser->username,
				'profile_picture' => $senderUser->profile_picture,
			],
		];
	}
}
