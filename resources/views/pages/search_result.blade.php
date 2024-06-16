@extends('layout.app')

@section('title', 'Search Results')

@section('content')
<div class="container">
    <h1 class="mt-4">Search Results @if (!empty($keyword)) for "{{ $keyword }}" @endif</h1>

    <!-- Display users based on search -->
    <div class="mt-4">
        <h2>Users</h2>
        @if ($users->isEmpty())
            @if (!empty($keyword))
                <p>No users found matching "{{ $keyword }}".</p>
            @else
                <p>Please enter a keyword to search for users.</p>
            @endif
        @else
            <ul class="list-group">
                @foreach ($users as $user)
                    <li class="list-group-item">
                        <a href="{{ route('user.detail', ['id' => $user->id]) }}">{{ $user->name }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Display articles based on search -->
    <div class="mt-4">
        <h2>Articles</h2>
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
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $article->title }}</h5>
                            <small>Created by: {{ $article->user->name }}</small>
                        </div>
                        <p class="mb-1">{{ Str::limit($article->content, 100) }}</p>
                        <small>Last updated: {{ $article->updated_at->diffForHumans() }}</small>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
