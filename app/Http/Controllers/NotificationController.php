<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'unread_count' => $user->unreadNotifications()->count(),
            'unread' => $user->unreadNotifications()->get(),
            'read' => $user->readNotifications()->get(),
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->unreadNotifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['ok' => true]);
    }

    public function markAllRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return response()->json(['ok' => true]);
    }
}
