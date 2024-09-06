@extends('layout.app')

@section('content')

<div class="container">
    <h1 class="mt-4">Notifications</h1>

    @if(count($notifications) > 0)
        <div class="list-group mt-4">
            @foreach($notifications as $notification)
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex align-items-start">
                        <div>
                            <h5 class="mb-1">
                                @if($notification->type == 'follow')
                                    <a href="{{ route('users.show', ['user' => $notification->from_user_id]) }}" >
                                        {{ $notification->message }}
                                    </a>
                                @elseif($notification->type == 'review')
                                    <a href="{{ route('articles.show', ['article' => $notification->at_article_id]) }}">
                                        {{ $notification->message }}
                                    </a>
                                @elseif($notification->type == 'like')
                                    <a href="{{ route('articles.show', ['article' => $notification->at_article_id]) }}">
                                        {{ $notification->message }}
                                    </a>
                                @elseif($notification->type == 'comment')
                                    <a href="{{ route('articles.show', ['article' => $notification->at_article_id]) }}">
                                        {{ $notification->message }}
                                    </a>
                                @elseif($notification->type == 'reply')
                                    <a href="{{ route('articles.show', ['article' => $notification->at_article_id]) }}">
                                        {{ $notification->message }}
                                    </a>
                                @elseif($notification->type == 'newArticle')
                                    <a href="{{ route('articles.show', ['article' => $notification->at_article_id]) }}">
                                        {{ $notification->message }}
                                    </a>
                                @elseif($notification->type == 'verify')
                                    <a href="{{ route('articles.show', ['article' => $notification->at_article_id]) }}">
                                        {{ $notification->message }}
                                    </a>
                                @endif
                            </h5>
                            <p class="mb-1">
                                <small>at: {{ $notification->created_at->setTimezone(config('app.timezone'))->format('M d, Y H:i') }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="alert alert-warning" role="alert">You have no notifications.</p>
    @endif
</div>

@endsection