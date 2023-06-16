<?php

namespace App\Events\Likes;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LikeAdded implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Create a new event instance.
	 */
	public function __construct(public array $like)
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
}
