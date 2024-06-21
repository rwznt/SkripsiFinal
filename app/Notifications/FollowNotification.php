<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class FollowNotification extends Notification
{
    use Queueable;

    private $user;
    private $follower;

    public function __construct(User $user, User $follower)
    {
        $this->user = $user;
        $this->follower = $follower;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'You have a new follower!',
            'follower_name' => $this->follower->name,
        ];
    }
}
