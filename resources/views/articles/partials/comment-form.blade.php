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
