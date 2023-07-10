<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
	public function index(): array
	{
		$notifications = Notification::where('receiver', Auth::user()->id)->orderBy('id', 'desc')->paginate(6);
		$unreadNotificationsCount = Notification::where('receiver', Auth::user()->id)->where('read', false)->get()->count();

		return [
			'notifications'              => NotificationResource::collection($notifications),
			'last_page'                  => $notifications->lastPage(),
			'unread_notifications_count' => $unreadNotificationsCount,
		];
	}

	public function markAsRead(Notification $notification): JsonResponse
	{
		if ($notification->read === 0) {
			$notification->update(['read' => true]);

			return response()->json(['message' => 'the notification has been marked as read successfully'], 201);
		}

		return response()->json(['message' => 'the notification is already marked as read']);
	}

	public function markAllAsRead(): JsonResponse
	{
		$notifications = Notification::where('receiver', Auth::user()->id)->where('read', false)->get();

		foreach ($notifications as $notification) {
			$notification->update(['read' => true]);
		}

		return response()->json(['message' => 'all notification marked as read']);
	}

	public function destroy(Notification $notification): JsonResponse
	{
		$notification->delete();

		return response()->json(['message' => 'notification of like deleted successfully']);
	}
}
