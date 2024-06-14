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
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $article->title }}</h5>
                            <small>Created at: {{ $article->created_at->format('M d, Y H:i:s') }}</small>
                        </div>
                        <p class="mb-1">{{ $article->body }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
