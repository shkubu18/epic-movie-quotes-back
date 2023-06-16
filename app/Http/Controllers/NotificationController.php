<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
	public function index(): array
	{
		$notifications = Notification::latest()->paginate(5);

		return ['notifications' => NotificationResource::collection($notifications), 'last_page' => $notifications->lastPage()];
	}

	public function markAsRead(Notification $notification): JsonResponse
	{
		if ($notification->read === 0) {
			$notification->update(['read' => true]);

			return response()->json(['message' => 'the notification has been marked as read successfully']);
		}

		return response()->json(['message' => 'the notification is already marked as read']);
	}

	public function destroy(Notification $notification): JsonResponse
	{
		$notification->delete();

		return response()->json(['message' => 'notification of like deleted successfully']);
	}
}
