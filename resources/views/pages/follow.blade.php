@if (Auth::check())
    @if ($article->followers()->where('user_id', Auth::id())->exists())
        <form action="{{ route('articles.unfollow', $article) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Unfollow</button>
        </form>
    @else
        <form action="{{ route('articles.follow', $article) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Follow</button>
        </form>
    @endif
@endif
