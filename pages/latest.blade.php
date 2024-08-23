@extends('layout.app')

@section('content')

<style>
    .pagination {
        margin-top: 20px;
    }

    .pagination .page-item .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        border-radius: 0.25rem;
    }
</style>

<div class="container">

    <h1>{{ $title }}</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert" id="success-alert">
            {{ session('success') }}
        </div>
    @endif

    @if($articles->isEmpty())
        <div class="alert alert-warning" role="alert">
            There are no articles available.
        </div>
    @else
        <div class="list-group mt-4">
            @foreach ($articles as $article)
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex align-items-start">
                        @if ($article->image)
                            <img src="{{ asset($article->image) }}" class="rounded me-3" style="width: 150px; height: 100px; object-fit: cover;" alt="{{ $article->title }}">
                        @else
                            <img src="{{ asset('images/default-article.jpg') }}" class="rounded me-3" style="width: 150px; height: 100px; object-fit: cover;" alt="{{ $article->title }}">
                        @endif
                        <div>
                            <h5 class="mb-1">{{ $article->title }}</h5>
                            <p class="mb-1">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                            <small>Created by: {{ $article->user->name }}</small>
                            <p>
                                <small>at: {{ $article->created_at->setTimezone(config('app.timezone'))->format('M d, Y H:i') }}</small>
                            </p>
                            <a href="{{ route('articles.show', ['article' => $article->id]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $articles->links('vendor.pagination.bootstrap-4') }}
        </div>
    @endif
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
