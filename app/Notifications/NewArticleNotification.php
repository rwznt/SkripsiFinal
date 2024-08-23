<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Article;
use App\Models\User;

class NewArticleNotification extends Notification
{
    use Queueable;

    private $article;
    private $user;

    public function __construct(Article $article, User $user)
    {
        $this->article = $article;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id,
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
        ];
    }
}
