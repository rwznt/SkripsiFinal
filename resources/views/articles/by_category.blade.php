@extends('layout.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Articles in Category: {{ $category->name }}</h1>

        @if ($articles->isEmpty())
            <div class="alert alert-warning" role="alert">
                There are currently no articles available in this category.
            </div>
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
@endsection
