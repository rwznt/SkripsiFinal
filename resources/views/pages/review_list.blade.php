@extends('layout.app')

@section('title', 'Articles Needing Review')

@section('content')
    <div class="container">
        <h1 class="mt-4">Articles Needing Review</h1>

        @if ($articles->isEmpty())
            <p>No articles need review at the moment.</p>
        @else
            <div class="list-group mt-4">
                @foreach ($articles as $article)
                    <a href="{{ route('articles.show', ['article' => $article->id]) }}" class="list-group-item list-group-item-action">
                        <h5 class="mb-1">{{ $article->title }}</h5>
                        <small>Created by: {{ $article->user->name }}</small>
                        <p class="mb-1">{{ Str::limit($article->content, 200) }}</p>
                        <small>Last updated: {{ $article->updated_at->diffForHumans() }}</small>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
