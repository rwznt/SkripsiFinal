<div class="container">

    <div class="text-center mb-4">
        <h1 class="display-3">Latest Articles</h1>
    </div>

    @if($articles->isEmpty())
        <div class="alert alert-warning" role="alert">
            There are no articles available.
        </div>
    @else
        <div class="list-group mt-4">
            @foreach ($articles as $article)
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex align-items-start">
                        <img src="{{ $article->image? asset($article->image) : asset('images/default-article.jpg') }}" class="rounded me-3" style="width: 150px; height: 100px; object-fit: cover;" alt="{{ $article->title }}">
                        <div>
                            <h5 class="mb-1">{{ $article->title }}</h5>
                            <p class="mb-1 text-muted">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                            <small class="text-muted">Created by: {{ $article->user->name }} at {{ $article->created_at->setTimezone(config('app.timezone'))->format('M d, Y H:i') }}</small>
                            <a href="{{ route('articles.show', ['article' => $article->id]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
