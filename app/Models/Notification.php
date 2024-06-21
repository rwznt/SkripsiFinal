<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Notifications\FollowNotification;
use App\Notifications\LikeNotification;
use App\Notifications\NewArticleNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'data->follower_id');
    }

    public function liker()
    {
        return $this->belongsTo(User::class, 'data->liker_id');
    }

    public function commenter()
    {
        return $this->belongsTo(User::class, 'data->commenter_id');
    }

    public function reply()
    {
        return $this->belongsTo(Comment::class, 'data->reply_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'data->article_id');
    }

    public static function createFollowNotification(User $user)
    {
        $notification = new Notification();
        $notification->notifiable_type = get_class($user); // e.g. App\Models\User
        $notification->notifiable_id = $user->id;
        $notification->user_id = Auth::id();
        $notification->type = 'follow';
        $notification->data = ['follower_id' => Auth::id()];
        $notification->save();

        $user->notify(new FollowNotification($user, Auth::user()));
    }

    public static function createLikeNotification(Like $like, User $user)
    {
        $notification = new Notification();
        $notification->notifiable_type = get_class($user); // e.g. App\Models\User
        $notification->notifiable_id = $user->id;
        $notification->user_id = $like->user_id;
        $notification->type = 'like';
        $notification->data = ['article_id' => $like->article_id, 'liker_id' => Auth::id()];
        $notification->save();

        $user->notify(new LikeNotification($like, $user, Auth::user()));
    }

    public static function createCommentNotification(Comment $comment, User $user)
    {
        $notification = new Notification();
        $notification->notifiable_type = get_class($user); // e.g. App\Models\User
        $notification->notifiable_id = $user->id;
        $notification->user_id = $comment->user_id;
        $notification->type = 'comment';
        $notification->data = ['article_id' => $comment->article_id, 'commenter_id' => Auth::id()];
        $notification->save();

        $user->notify(new CommentNotification($comment, $user, Auth::user()));

        if ($comment->user_id !== $comment->article->user_id) {
            $notification = new Notification();
            $notification->notifiable_type = get_class($user); // e.g. App\Models\User
            $notification->notifiable_id = $user->id;
            $notification->user_id = $comment->user_id;
            $notification->type = 'comment_reply';
            $notification->data = ['article_id' => $comment->article_id, 'reply_id' => $comment->id];
            $notification->save();

            $user->notify(new CommentNotification($comment, $user, Auth::user()));
        }
    }

    public static function createNewArticleNotification(Article $article, User $user)
    {
        $followers = $article->user->followers;
        foreach ($followers as $follower) {
            $notification = new Notification();
            $notification->notifiable_type = get_class($follower); // e.g. App\Models\User
            $notification->notifiable_id = $follower->id;
            $notification->user_id = $article->user_id;
            $notification->type = 'new_article';
            $notification->data = ['article_id' => $article->id];
            $notification->save();

            $follower->notify(new NewArticleNotification($article, $user));
        }
    }

    public function scopeLatest($query)
    {
        Log::info('Getting latest notifications for user '. Auth::id());
        return $query->orderBy('created_at', 'desc');
    }

    public function markAsRead()
    {
        $this->read_at = now();
        $this->save();
    }
}
