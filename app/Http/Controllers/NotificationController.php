<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SearchNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            $user = auth()->user();
            $notifications = $user->notifications;
            $unreadNotifications = $user->unreadNotifications;

            return view('notification', [
                'unread' => $unreadNotifications,
                'notifications' => $notifications
            ]);
        } else {
            return view('login');
        }
    }

    public function markAsRead($id)
    {

        foreach (Auth::user()->unreadNotifications as $notification) {
            if ($notification->id === $id) {
                $notification->markAsRead();
            }
            return redirect()->back()->with('status', 'Notification marked as read');
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('status', 'All notifications marked as read');
    }
}
