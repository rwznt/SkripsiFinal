<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function MarkAsRead($id)
    {
        $notification = Notification::find($id);
        $notification->read = 1;
        $notification->save();
        return response()->json(['success' => true]); // Return a JSON response to indicate success
    }
}
