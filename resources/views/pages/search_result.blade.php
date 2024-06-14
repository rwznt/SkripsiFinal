@extends('layout.app')

@section('title', 'Search Results')

@section('content')
    <div class="container">
        <h1 class="mt-4">Search Results</h1>

        {{-- Accounts Section --}}
        <div class="mt-4">
            <h2>Accounts</h2>
            @if ($accounts->isEmpty())
                <p>No accounts found.</p>
            @else
                <ul class="list-group">
                    @foreach ($accounts as $account)
                        <li class="list-group-item">
                            <a href="{{ route('account.detail', ['id' => $account->id]) }}">{{ $account->name }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Articles Section --}}
        <div class="mt-4">
            <h2>Articles</h2>
            @if ($articles->isEmpty())
                <p>No articles found.</p>
            @else
                <div class="list-group">
                    @foreach ($articles as $article)
                        <a href="{{ route('article.show', ['id' => $article->id]) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $article->title }}</h5>
                                <small>Created by: {{ $article->user->name }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($article->content, 100) }}</p>
                            <small>Last updated: {{ $article->updated_at->diffForHumans() }}</small>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
