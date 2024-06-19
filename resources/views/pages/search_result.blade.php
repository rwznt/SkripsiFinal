@extends('layout.app')

@section('title', 'Search Results')

@section('content')
<div class="container">
    <h1 class="mt-4">Search Results @if (!empty($keyword)) for "{{ $keyword }}" @endif</h1>

    <ul class="nav nav-tabs mt-4" id="searchTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="true">Users</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles" type="button" role="tab" aria-controls="articles" aria-selected="false">Articles</button>
        </li>
    </ul>

    <div class="tab-content" id="searchTabsContent">
        <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
            <h2 class="mt-4">Users</h2>
            @if ($users->isEmpty())
                @if (!empty($keyword))
                    <p>No users found matching "{{ $keyword }}".</p>
                @else
                    <p>Please enter a keyword to search for users.</p>
                @endif
            @else
                <ul class="list-group">
                    @foreach ($users as $user)
                        <li class="list-group-item d-flex align-items-center">
                            @if ($user->image)
                                <img src="{{ asset($user->image) }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $user->name }}">
                            @else
                                <img src="{{ asset('images/default-profile.jpg') }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $user->name }}">
                            @endif
                            <a href="{{ route('user.detail', ['id' => $user->id]) }}">{{ $user->name }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="tab-pane fade" id="articles" role="tabpanel" aria-labelledby="articles-tab">
            <h2 class="mt-4">Articles</h2>
            @if ($articles->isEmpty())
                @if (!empty($keyword))
                    <p>No articles found matching "{{ $keyword }}".</p>
                @else
                    <p>Please enter a keyword to search for articles.</p>
                @endif
            @else
                <div class="list-group">
                    @foreach ($articles as $article)
                        <a href="{{ route('articles.show', ['article' => $article->id]) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-start">
                                @if ($article->image)
                                    <img src="{{ asset($article->image) }}" class="rounded me-3" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $article->title }}">
                                @else
                                    <img src="{{ asset('images/default-article.jpg') }}" class="rounded me-3" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $article->title }}">
                                @endif
                                <div>
                                    <h5 class="mb-1">{{ $article->title }}</h5>
                                    <small>Created by: {{ $article->user->name }}</small>
                                    <p class="mb-1">{{ Str::limit($article->content, 100) }}</p>
                                    <small>Created at: {{ $article->created_at->setTimezone(config('app.timezone'))->format('M d, Y H:i:s') }}</small>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
