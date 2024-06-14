@extends('layout.app')

@section('content')
    <div class="container">
        @if ($article)
            <div class="card mb-3">
                <div class="card-header">
                    {{ $article->title }}
                </div>
                <div class="card-body">
                    <small class="text-muted">Created by:
                        @if ($article->user)
                            <a href="{{ route('user.detail', ['id' => $article->user->id]) }}">{{ $article->user->name }}</a>
                        @endif
                    </small><br>
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="img-fluid mb-3">
                    <p class="card-text">{{ $article->content }}</p>
                    <p class="card-text"><small class="text-muted">Created at: {{ $article->created_at->format('M d, Y H:i:s') }}</small></p>

                    <hr>

                    <!-- Like/Unlike Buttons -->
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

                        <!-- Edit Review Modal -->
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

                    <hr>

                    <!-- Review Information -->
                    @if ($article->reviewed)
                        <div class="mt-3">
                            <h5>Review Information</h5>
                            <p>Trust Factor: {{ $article->trustfactor }}</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $article->trustfactor }}%;" aria-valuenow="{{ $article->trustfactor }}" aria-valuemin="0" aria-valuemax="100">{{ $article->trustfactor }}%</div>
                            </div>
                            <p>Admin's Comment: {{ $article->admin_comment }}</p>
                        </div>
                    @endif

                    <hr>

                    <!-- Comment Section -->
                    <h5>Comments</h5>
                    @auth
                        <!-- Form for creating a new comment -->
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <div class="form-group">
                                <label for="content">Add Comment</label>
                                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <hr>
                    @endauth

                    <!-- Display Comments -->
                    @foreach ($article->comments as $comment)
                        <div class="card mb-2">
                            <div class="card-body">
                                <p>{{ $comment->content }}</p>
                                <small class="text-muted">
                                    By: {{ $comment->user->name ?? 'Unknown User' }}, {{ $comment->created_at->diffForHumans() }}
                                    @auth
                                        @if ($comment->user_id === auth()->id() || $article->user_id === auth()->id() || auth()->user()->isAdmin())
                                            <!-- Delete button for the comment -->
                                            <form action="{{ route('comments.destroy', ['id' => $comment->id]) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        @endif
                                    @endauth
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p>Article not found.</p>
        @endif
    </div>
@endsection
