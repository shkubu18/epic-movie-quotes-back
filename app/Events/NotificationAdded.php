<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationAdded implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Create a new event instance.
	 */
	//	public $notifications;

	public function __construct(public object $notification)
	{
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array<int, PrivateChannel>
	 */
	public function broadcastOn(): array
	{
		return [
			new PrivateChannel('notifications.' . $this->notification->receiver),
		];
	}

	/**
	 * Get the data to broadcast.
	 */
	public function broadcastWith(): array
	{
		return [
			'id'         => $this->notification->id,
			'quote_id'   => (int)$this->notification->quote_id,
			'type'       => $this->notification->type,
			'read'       => $this->notification->read,
			'sender'     => $this->notification->sender,
		];
	}
}
