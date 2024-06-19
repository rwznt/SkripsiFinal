@extends('layout.app')

@section('title', 'Articles Needing Review')

@section('content')
<div class="container">
    <h1 class="mt-4">Articles Needing Review</h1>

    @if ($articles->isEmpty())
        <div class="alert alert-warning" role="alert">
            There are no articles needing review at the moment.
        </div>
    @else
        <div class="list-group mt-4">
            @foreach ($articles as $article)
                <a href="{{ route('articles.show', ['article' => $article->id]) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $article->title }}</h5>
                        <small>Created by: {{ $article->user->name }}</small>
                    </div>
                    @if ($article->image)
                        <img src="{{ asset($article->image) }}" class="rounded mb-2" style="max-width: 100%; height: auto;" alt="{{ $article->title }}">
                    @else
                        <img src="{{ asset('images/default-article.jpg') }}" class="rounded mb-2" style="max-width: 100%; height: auto;" alt="Default Image">
                    @endif
                    <p class="mb-1">{{ Str::limit(strip_tags($article->content), 200) }}</p>
                    <small>Created at: {{ $article->created_at->format('M d, Y H:i') }}</small>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
