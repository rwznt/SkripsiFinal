@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Search Articles by Category</h1>
        <form action="{{ route('articles.search') }}" method="GET">
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">Select a Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <h2 class="mt-5">Search Results</h2>
        @if($articles->isNotEmpty())
            @foreach ($articles as $article)
                <div class="card mb-3">
                    <div class="card-body">
                        <h2>{{ $article->title }}</h2>
                        <p>{{ $article->created_at->format('M d, Y') }}</p>
                        <p>{{ Str::limit($article->content, 150) }}</p>
                        <a href="{{ route('articles.show', $article) }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            @endforeach

            {{ $articles->links() }}
        @else
            <p>No articles found for the selected category.</p>
        @endif
    </div>
@endsection
