@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Review Articles</h1>

        @foreach ($articles as $article)
            <div class="card mb-3">
                <div class="card-header">
                    {{ $article->title }}
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="img-fluid mb-3">
                        <p class="card-text">{{ $article->body }}</p>
                        <p class="card-text"><small class="text-muted">Created at: {{ $article->created_at->format('M d, Y H:i:s') }}</small></p>
                    </div>
                    @if (Auth::user()->isAdmin())
                    <form action="{{ route('articles.review.update', ['article' => $article->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="trustFactor">Trust Factor (1-10)</label>
                            <input type="number" id="trustFactor" name="trustFactor" class="form-control" min="1" max="10" required>
                        </div>
                        <div class="form-group">
                            <label for="comments">Comments</label>
                            <textarea id="comments" name="comments" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
