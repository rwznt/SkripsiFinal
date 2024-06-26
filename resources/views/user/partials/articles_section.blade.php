<div class="mt-4">
    <h2 class="text-center mb-4">Articles Created by {{ $user->name }}</h2>

    @if ($articles->isEmpty())
        <div class="alert alert-info" role="alert">
            No articles found.
        </div>
    @else
        <div class="list-group">
            @foreach ($articles as $article)
                <a href="{{ route('articles.show', ['article' => $article->id]) }}" class="list-group-item list-group-item-action article-list-item">
                    <div class="d-flex align-items-center">
                        @if ($article->image)
                            <img src="{{ asset($article->image) }}" class="rounded me-3" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $article->title }}">
                        @else
                            <img src="{{ asset('images/default-article.jpg') }}" class="rounded me-3" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $article->title }}">
                        @endif
                        <div>
                            <h5 class="mb-1">{{ $article->title }}</h5>
                            <small>Created by: {{ $article->user->name }}</small>
                            <p class="mb-1">{{ Str::limit($article->content, 100) }}</p>
                            <small>Created at: {{ $article->created_at->setTimezone(config('app.timezone'))->format('M d, Y H:i:s') }}</small>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>

