<div class="card comment-card ml-{{ isset($isNested) && $isNested ? '4' : '2' }}"> {{-- Adjust margin for nested replies --}}
    <div class="card-body">
        <p>{{ $reply->content }}</p>
        <small class="text-muted">
            By: {{ $reply->user->name ?? 'Unknown User' }}, {{ $reply->created_at->format('M d, Y H:i:s') }}
            @can('delete', $reply)
                <form action="{{ route('comments.destroy', ['id' => $reply->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            @endcan
        </small>

        {{-- Check if this is a direct reply to a comment --}}
        @if (!isset($isNested) || !$isNested)
            <div class="nested-comments">
                <small class="text-muted">
                    In reply to {{ $parentName }}:
                </small>
                <p>
                    {{ $parentContent }}
                </p>
            </div>
        @endif

        {{-- Reply Form for Nested Reply --}}
        @auth
            <div class="reply-form mt-2">
                <form action="{{ route('comments.reply', ['id' => $reply->parent_id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="2" placeholder="Reply to this comment..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                </form>
            </div>
        @endauth

        {{-- Display Nested Replies --}}
        @foreach ($reply->replies as $nestedReply)
            @include('articles.partials.comment-reply', [
                'reply' => $nestedReply,
                'isNested' => true,
                'parentName' => $reply->user->name,
                'parentContent' => $reply->content
            ])
        @endforeach
    </div>
</div>
