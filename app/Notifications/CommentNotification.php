<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Comment;
use App\Models\User;

class CommentNotification extends Notification
{
    use Queueable;

    private $comment;
    private $user;
    private $commenter;

    public function __construct(Comment $comment, User $user, User $commenter)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->commenter = $commenter;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->commenter->name. 'ommented on your article '. $this->comment->article->title,
            'data' => [
                'article_id' => $this->comment->article_id,
                'commenter_id' => $this->commenter->id,
            ],
        ];
    }
}
