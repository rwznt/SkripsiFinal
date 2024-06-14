@extends('layout.app')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    @if($articles->isEmpty())
        <div class="alert alert-warning" role="alert">
            There are no articles available.
        </div>
    @else
        <div class="row">
            @foreach ($articles as $article)
                <div class="col-md-6 mb-4">
                    <a href="{{ route('articles.show', ['article' => $article->id]) }}" class="text-decoration-none">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text">{{ Str::limit($article->body, 150) }}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Created at: {{ $article->created_at->format('M d, Y H:i:s') }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
