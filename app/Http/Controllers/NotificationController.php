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
}
