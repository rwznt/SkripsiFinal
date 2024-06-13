@if (Auth::check())
    @if ($article->likes()->where('user_id', Auth::id())->exists())
        <form action="{{ route('articles.unlike', $article) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Unlike</button>
        </form>
    @else
        <form action="{{ route('articles.like', $article) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Like</button>
        </form>
    @endif
@endif
<p>{{ $article->likes()->count() }} likes</p>
