<div class="card comment-card">
    <div class="card-body">
        <p>{{ $comment->content }}</p>
        <small class="text-muted">
            By: {{ $comment->user->name ?? 'Unknown User' }}, {{ $comment->created_at->format('M d, Y H:i:s') }}
            @can('delete', $comment)
                <form action="{{ route('comments.destroy', ['id' => $comment->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            @endcan
        </small>

        @auth
            <div class="reply-form mt-2">
                <form action="{{ route('comments.reply', ['id' => $comment->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="2" placeholder="Reply to this comment..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                </form>
            </div>
        @endauth

        {{-- Display Nested Replies --}}
        @foreach ($comment->replies as $reply)
            @include('articles.partials.comment-reply', [
                'reply' => $reply,
                'isNested' => true
            ])
        @endforeach
    </div>
</div>
