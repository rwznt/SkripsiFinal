<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user = new User();
        $notifications = $user->notifications();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();
        $title = 'Notifications';

        return view('pages.notifications', compact('notifications', 'title'));
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::find($id);
        $notification->read_at = now();
        $notification->save();

        return redirect()->back();
    }
}

