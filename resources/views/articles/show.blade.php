@extends('layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Articles</div>
                <div class="card-body">
                    @if($articles->isEmpty())
                        <p>No articles found.</p>
                    @else
                        <ul class="list-group">
                            @foreach($articles as $article)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>{{ $article->title }}</h5>
                                        <small class="text-muted">Created by: {{ $article->user->name }}</small>
                                    </div>
                                    <p>{{ Str::limit($article->content, 200) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Created at: {{ $article->created_at->format('M d, Y H:i:s') }}</small>
                                        <a href="{{ route('article.show', ['article' => $article->id]) }}" class="btn btn-sm btn-primary">Read More</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
