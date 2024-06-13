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
                                    <h5>{{ $article->title }}</h5>
                                    <p>{{ Str::limit($article->content, 100) }}</p>
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
