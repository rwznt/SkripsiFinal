@extends('layout.app')

@section('content')
<style>
    a {
      text-decoration: none;
      color: inherit;
    }
</style>

<div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="my-4 text-left">Notifications</h1>
                <ul class="nav nav-tabs" id="notificationTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="unread-tab" data-bs-toggle="tab" data-bs-target="#unread-list" type="button" role="tab" aria-controls="unread" aria-selected="true">New Notifications</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <div class="d-flex align-items-center">
                            <button class="nav-link" id="read-tab" data-bs-toggle="tab" data-bs-target="#read-list" type="button" role="tab" aria-controls="read" aria-selected="false">Old Notifications</button>
                            <div id="delete-all-button" style="display: none;">
                                <form action="{{ route('notifications.destroy.all') }}" method="post" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete All</button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>

                <div class="tab-content" id="notificationTabsContent">
                    <div class="tab-pane fade show active" id="unread-list" role="tabpanel" aria-labelledby="unread-tab">
                        @if(count($notifications->where('read', 0)) > 0)
                            <ul class="list-group">
                                @foreach($notifications->where('read', 0)->sortByDesc('created_at') as $notification)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5>
                                                @if($notification->type == 'follow')
                                                    <a href="{{ route('read.user', ['id' => $notification->id]) }}" >
                                                        {{ $notification->message }}
                                                    </a>
                                                @elseif($notification->type == 'review')
                                                    <a href="{{ route('read.article', ['id' => $notification->id]) }}">
                                                        {{ $notification->message }}
                                                    </a>
                                                @elseif($notification->type == 'like')
                                                    <a href="{{ route('read.article', ['id' => $notification->id]) }}">
                                                        {{ $notification->message }}
                                                    </a>
                                                @elseif($notification->type == 'comment')
                                                    <a href="{{ route('read.article', ['id' => $notification->id]) }}">
                                                        {{ $notification->message }}
                                                    </a>
                                                @elseif($notification->type == 'reply')
                                                    <a href="{{ route('read.article', ['id' => $notification->id]) }}">
                                                        {{ $notification->message }}
                                                    </a>
                                                @elseif($notification->type == 'newArticle')
                                                    <a href="{{ route('read.article', ['id' => $notification->id]) }}">
                                                        {{ $notification->message }}
                                                    </a>
                                                @elseif($notification->type == 'verify')
                                                    <a href="{{ route('read.article', ['id' => $notification->id]) }}">
                                                        {{ $notification->message }}
                                                    </a>
                                                @endif
                                            </h5>
                                            <p class="mb-1">
                                                <small>at: {{ $notification->created_at->setTimezone('Asia/Jakarta')->format('M d, Y H:i') }}</small>
                                            </p>
                                        </div>
                                        <form action="{{ route('notifications.destroy.one', ['id' => $notification->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">You have no unread notifications.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="read-list" role="tabpanel" aria-labelledby="read-tab">
                        @if(count($notifications->where('read', 1)) > 0)
                            <ul class="list-group">
                                @foreach($notifications->where('read', 1)->sortByDesc('created_at') as $notification)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5>
                                                @if($notification->type == 'follow')
                                                    <a href="{{ route('users.show', ['user' => $notification->from_user_id]) }}" >
                                                        {{ notification->message }}
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
                                                    <a href="{{ route('users.show', ['user' => $notification->from_user_id]) }}" >
                                                        {{ $notification->message }}
                                                    </a>
                                                @endif
                                            </h5>
                                            <p class="mb-1">
                                                <small>at: {{ $notification->created_at->setTimezone('Asia/Jakarta')->format('M d, Y H:i') }}</small>
                                            </p>
                                        </div>
                                        <form action="{{ route('notifications.destroy.one', ['id' => $notification->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">You have no read notifications.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection