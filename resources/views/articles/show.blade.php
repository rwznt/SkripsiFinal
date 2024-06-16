@extends('layout.app')

@section('content')

<style>
    .article-title {
        font-size: 3rem;
        font-weight: bold;
    }

    .article-image {
        display: block;
        margin: 0 auto;
    }

    .article-content p {
        margin-top: 18%;
        margin-bottom: 1rem;
    }
</style>

<div class="container">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <div class="card mb-3">
        <div class="card-header">
            <h1 class="article-title">{{ $article->title }}</h1>

            @if (!$article->reviewed && auth()->id() === $article->user->id)
                @can('update', $article)
                    <a href="{{ route('articles.edit', ['id' => $article->id]) }}" class="btn btn-primary float-end ms-2">Edit</a>
                @endcan
            @endif

            @can('delete', $article)
                <form action="{{ route('articles.destroy', ['id' => $article->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger float-end" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                </form>
            @endcan
        </div>

        <div class="card-body">
            @if ($article->image)
                <img src="{{ asset($article->image) }}" class="rounded mx-auto d-block" width="50%" alt="{{ $article->title }}">
            @else
                <p>No image available for this article.</p>
            @endif

            <p class="card-text">{{ $article->content }}</p>

            <div class="mb-3">
                <small class="text-muted">
                    Created by:
                    <a href="{{ route('user.detail', ['id' => $article->user->id]) }}">{{ $article->user->name }}</a>
                    on {{ $article->created_at->format('M d, Y') }}
                </small>
            </div>

            <div class="mb-3">
                @if ($article->likedBy(auth()->id()))
                    <form action="{{ route('article.unlike', ['id' => $article->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-link">
                            <i class="bi bi-heart-fill text-danger"></i> Unlike ({{ $article->likes()->count() }})
                        </button>
                    </form>
                @else
                    <form action="{{ route('article.like', ['id' => $article->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-link">
                            <i class="bi bi-heart text-danger"></i> Like ({{ $article->likes()->count() }})
                        </button>
                    </form>
                @endif
            </div>

            @auth
            @if (auth()->user()->isAdmin())
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editReviewModal">Edit Review</button>
                <div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('article.review.update', ['id' => $article->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="trustFactor">Trust Factor (1-100)</label>
                                        <input type="number" id="trustFactor" name="trustFactor" class="form-control" min="1" max="100" value="{{ $article->trustfactor ?? '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="adminComment">Admin's Comment</label>
                                        <textarea id="adminComment" name="adminComment" class="form-control" rows="3">{{ $article->admin_comment ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @endauth

            @if ($article->reviewed)
                <hr>
                <div class="mb-3">
                    <h5>Review Information</h5>
                    <p>Trust Factor: {{ $article->trustfactor }}</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ $article->trustfactor }}%;" aria-valuenow="{{ $article->trustfactor }}" aria-valuemin="0" aria-valuemax="100">{{ $article->trustfactor }}%</div>
                    </div>
                    <p>Admin's Comment: {{ $article->admin_comment }}</p>
                </div>
            @endif

            <hr>
            <h5>Comments</h5>

            @auth
                <form action="{{ route('comments.store') }}" method="POST" class="mb-3">
                    @csrf
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <div class="form-group">
                        <label for="content">Add Comment</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            @endauth

            @forelse ($article->comments as $comment)
                <div class="card mb-2">
                    <div class="card-body">
                        <p>{{ $comment->content }}</p>
                        <small class="text-muted">
                            By: {{ $comment->user->name ?? 'Unknown User' }}, {{ $comment->created_at->diffForHumans() }}
                            @can('delete', $comment)
                                <form action="{{ route('comments.destroy', ['id' => $comment->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endcan
                        </small>
                    </div>
                </div>
            @empty
                <p>No comments yet. Be the first to comment!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
