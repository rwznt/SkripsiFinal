@extends('layout.app')

@section('content')

@if (Auth::check() && (Auth::user()->isAdmin() || Auth::id() === $article->user_id))
    <h1>{{ $article->title }}</h1>
    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
    <p>{{ $article->body }}</p>
    <p class="card-text"><small class="text-muted">Created at: {{ $article->created_at->format('M d, Y H:i:s') }}</small></p>

    @if ($article->trustfactor !== null)
        @php
            $trustFactor = $article->trustfactor;
            $color = $trustFactor >= 70 ? 'green' : ($trustFactor >= 40 ? 'yellow' : 'red');
        @endphp
        <div class="trust-factor">
            <div class="trust-factor-graphic" style="background-color: {{ $color }};">
                Trust Factor: {{ $trustFactor }}
            </div>
        </div>
    @else
        <p>Trust Factor: N/A</p>
    @endif

    <div class="admin-comment mt-4">
        <div>
            <p><strong>Admin's Comment:</strong> {{ $article->admin_comment ?? 'N/A' }}</p>
        </div>
    </div>

    @else
        <p>You do not have permission to view this article.</p>
    @endif
    @auth
        @if (Auth::user()->isAdmin())
            <a href="{{ route('review') }}" class="btn btn-primary">Review</a>
        @endif
    @endauth

<a href="{{ session('previous_url') ?: route('articles.index') }}" class="btn btn-secondary mt-2">Back</a>

@endsection
