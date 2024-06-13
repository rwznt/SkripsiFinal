@extends('layout.app')

@section('content')
    @if (Auth::check() && (Auth::user()->isAdmin() || Auth::id() === $article->user_id))
        <h1>{{ $article->title }}</h1>
        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
        <p>{{ $article->body }}</p>
        @php
            $creatorName = App\Models\User::findOrFail($article->user_id)->name;
        @endphp
        <p>Created by: {{ $creatorName }}</p>
        @auth
            @if (Auth::user()->level == 'admin')
            <a href="{{ route('review') }}" class="btn btn-primary">Review</a>
            @endif
        @endauth
        <a href="{{ route('articles.index') }}">Back to Articles</a>
    @else
        <p>You do not have permission to view this article.</p>
        <a href="{{ route('articles.index') }}">Back to Articles</a>
    @endif
@endsection
