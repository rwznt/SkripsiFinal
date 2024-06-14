@extends('layout.app')

@section('title', $user->name)

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>{{ $user->name }}</h1>
                </div>

                <div class="card-body">
                    <h2>Articles Created by {{ $user->name }}</h2>

                    @if ($articles->isEmpty())
                        <p>No articles found.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($articles as $article)
                                <li class="list-group-item">{{ $article->title }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
