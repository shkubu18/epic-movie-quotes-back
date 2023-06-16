<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'                    => $this->id,
			'quote_id'              => $this->quote_id,
			'receiver'              => $this->receiver,
			'sender'                => [
				'username'        => $this->senderUser->username,
				'profile_picture' => $this->senderUser->profile_picture,
			],
			'type' => $this->type,
			'read' => $this->read,
		];
	}
}
