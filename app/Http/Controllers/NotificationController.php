<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function MarkAsUser($id)
    {
        $notification = Notification::find($id);
        $notification->read = 1;
        $notification->save();
        
        // Redirect to users.show with the from_user_id
        return redirect()->route('users.show', ['user' => $notification->from_user_id]);
    }

    public function MarkAsArticle($id)
    {
        $notification = Notification::find($id);
        $notification->read = 1;
        $notification->save();
        
        // Redirect to articles.show with the at_article_id
        return redirect()->route('articles.show', ['article' => $notification->at_article_id]);
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);
        $notification->delete();
        return back()->with('success', 'Notification deleted successfully.');
    }
    
    public function destroyAll()
    {
        $notifications = Notification::where('read', 1)->get();
        foreach ($notifications as $notification) {
            $notification->delete();
        }
        return back()->with('success', 'All read notifications deleted successfully.');
    }
}
