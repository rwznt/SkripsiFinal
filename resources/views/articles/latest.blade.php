@extends('layout.app')
@section('content')
    <div class="container">
        <h1>{{$title}}</h1>

        @foreach ($articles as $article)
            <a href="{{ route('article', ['article' => $article->id]) }}" class="text-decoration-none">
                <div class="card mb-3">
                    <div class="card-header">
                        {{ $article->title }}
                    </div>
                    <div class="card-body">
                        <p class="card-text"><small class="text-muted">Created at: {{ $article->created_at->format('M d, Y H:i:s') }}</small></p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
