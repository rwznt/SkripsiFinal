@extends('layout.app')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if($articles->isEmpty())
        <div class="alert alert-warning" role="alert">
            There are no articles available.
        </div>
    @else
        <div class="list-group mt-4">
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
                            <p class="mb-1">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                            <small>Created at: {{ $article->created_at->setTimezone(config('app.timezone'))->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
