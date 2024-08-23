@extends('layout.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Notifications</h1>

    @if ($notifications->isEmpty())
        <div class="alert alert-warning" role="alert">
            You have no notifications.
        </div>
    @else
    <div class="list-group">
        @foreach ($notifications as $notification)
            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-start">
                    @if ($notification->type == 'follow')
                        <i class="fas fa-user-plus me-3" style="font-size: 24px;"></i>
                    @elseif ($notification->type == 'like')
                        <i class="fas fa-thumbs-up me-3" style="font-size: 24px;"></i>
                    @elseif ($notification->type == 'comment')
                        <i class="fas fa-comment me-3" style="font-size: 24px;"></i>
                    @elseif ($notification->type == 'comment_reply')
                        <i class="fas fa-reply me-3" style="font-size: 24px;"></i>
                    @elseif ($notification->type == 'new_article')
                        <i class="fas fa-newspaper me-3" style="font-size: 24px;"></i>
                    @endif
                    <div>
                        <h5 class="mb-1">
                            @if ($notification->type == 'follow')
                                {{ $notification->data['follower_id']->name }} started following you
                            @elseif ($notification->type == 'like_id')
                                {{ $notification->data['liker']->name }} liked your article {{ $notification->data['article']->title }}
                            @elseif ($notification->type == 'comment_id')
                                {{ $notification->data['commenter']->name }} commented on your article {{ $notification->data['article']->title }}
                            @elseif ($notification->type == 'comment_id')
                                {{ $notification->data['reply_id']->user->name }} replied to your comment on article {{ $notification->data['article']->title }}
                            @elseif ($notification->type == 'new_article')
                                {{ $notification->data['article_id'] }} new article from {{ $notification->user->name }}
                            @endif
                        </h5>
                        <small>Received at: {{ $notification->created_at->setTimezone(config('app.timezone'))->format('M d, Y H:i:s') }}</small>
                    </div>
                    <form action="{{ route('markAsRead', ['id' => $notification->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-secondary">Mark as read</button>
                    </form>
                </div>
            </a>
        @endforeach
    </div>
    @endif
</div>
@endsection
