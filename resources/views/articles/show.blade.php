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
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .article-content {
        margin-top: 2rem;
        text-align: justify;
    }

    .article-meta {
        margin-top: 1rem;
        font-size: 0.9rem;
    }

    .comment-section {
        margin-top: 2rem;
    }

    .comment-card {
        margin-bottom: 1rem;
    }

    .reply-form {
        margin-top: 1rem;
        margin-left: 20px;
    }

    .nested-comments {
        margin-left: 20px;
    }
</style>

<div class="container">
    @if(session('success'))
    <div id="success-alert" class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="article-title">{{ $article->title }}</h1>

            <div>
                @can('update', $article)
                    <a href="{{ route('articles.edit', ['id' => $article->id]) }}" class="btn btn-primary me-2">Edit</a>
                @endcan

                @can('delete', $article)
                    <form action="{{ route('articles.destroy', ['id' => $article->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                    </form>
                @endcan
            </div>
        </div>

        <div class="card-body">
            @if ($article->image)
                <img src="{{ asset($article->image) }}" class="article-image" alt="{{ $article->title }}">
            @else
                <p>No image available for this article.</p>
            @endif

            <div class="article-content">
                @foreach (explode("\n", $article->content) as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach

                <div class="article-meta">
                    <small class="text-muted">
                        Created by:
                        <a href="{{ route('user.detail', ['id' => $article->user->id]) }}">{{ $article->user->name }}</a>
                        on {{ $article->created_at->format('M d, Y H:i:s') }}
                    </small>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center mb-3">
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
            </div>

            @if ($article->reviewed)
                <div class="mb-3">
                    <h5>Review Information</h5>
                    <p>Trust Factor: {{ $article->trustfactor }}</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ $article->trustfactor }}%; {{ $article->trustfactor <= 30 ? 'background-color: #dc3545;' : ($article->trustfactor <= 70 ? 'background-color: #ffc107;' : 'background-color: #28a745;') }}" aria-valuenow="{{ $article->trustfactor }}" aria-valuemin="0" aria-valuemax="100">{{ $article->trustfactor }}%</div>
                    <div class="legend">
                        <span style="background-color: #dc3545; display: inline-block; width: 20px; height: 20px; margin-right: 10px;"></span> <span>0-30: Low Credibility</span><br>
                        <span style="background-color: #ffc107; display: inline-block; width: 20px; height: 20px; margin-right: 10px;"></span> <span>31-70: Medium Credibility</span><br>
                        <span style="background-color: #28a745; display: inline-block; width: 20px; height: 20px; margin-right: 10px;"></span> <span>71-100: High Credibility</span><br>
                    </div>
                    <p>Admin's Comment: {{ $article->admin_comment }}</p>
                </div>
            @endif

            <hr>

            <div class="comment-section">
                <h5>Comments</h5>

                @include('articles.partials.comment-form')

                @foreach ($article->comments()->whereNull('parent_id')->get() as $comment)
                    @include('articles.partials.comment', ['comment' => $comment])
                @endforeach

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.transition = "opacity 0.5s ease";
                successAlert.style.opacity = 0;
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }
        }, 5000);
    });
</script>

@endsection
