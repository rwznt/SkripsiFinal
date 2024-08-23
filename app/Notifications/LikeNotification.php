<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Like;
use App\Models\User;

class LikeNotification extends Notification
{
    use Queueable;

    private $like;
    private $user;
    private $liker;

    public function __construct(Like $like, User $user, User $liker)
    {
        $this->like = $like;
        $this->user = $user;
        $this->liker = $liker;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'article_id' => $this->like->article_id,
            'liker_id' => $this->liker->id,
        ];
    }

    public function notifiable()
    {
        return $this->user;
    }
}
