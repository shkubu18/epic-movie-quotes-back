<?php

namespace App\Broadcasting;

use App\Models\User;

class NotificationChannel
{
	/**
	 * Authenticate the user's access to the channel.
	 */
	public function join(User $user, int $userId): bool
	{
		return $user->id === $userId;
	}
}
