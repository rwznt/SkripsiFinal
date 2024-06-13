@extends('layout.app') <!-- Assuming 'layout.app' is your master layout file -->

@section('content')
    <div class="container">
        <h1 class="my-4">Articles in Category: {{ $category->name }}</h1>

        <div class="list-group">
            @foreach ($articles as $article)
                <a href="{{ route('article', ['article' => $article->id]) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $article->title }}</h5>
                        <small>Created at: {{ $article->created_at->format('M d, Y H:i:s') }}</small>
                    </div>
                    <p class="mb-1">{{ $article->body }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endsection
