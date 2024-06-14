@extends('layout.app')

@section('content')

<style>
    .words {
        text-align: center;
        margin-top: 50px;
    }

    .leadword h1 {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .leaddesc p {
        font-size: 1.2rem;
        margin-top: 20px;
    }

    .button {
        text-align: center;
        margin-top: 30px;
    }

    .category-scroll-wrapper {
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .start {
        background-color: #f7f7f7;
        padding: 50px 0;
    }

    .start h2 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .start p {
        font-size: 1.1rem;
        line-height: 1.6;
    }
</style>

<div class="container">
    <div class="category-scroll-wrapper text-center">
        <div class="row flex-nowrap overflow-auto">
            @foreach ($categories as $kategori)
                <div class="col-auto">
                    <a href="{{ route('articles.by_category', ['category' => $kategori->id]) }}" class="btn btn-primary">{{ $kategori->name }}</a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="welcome-section">
    <div class="container">
        <div class="words">
            <div class="leadword">
                <h1>Welcome To</h1>
                <h1>ArtiCreate</h1>
            </div>
            <div class="leaddesc">
                <p>A website that lets you channel your ideas into writings in the form of an article</p>
            </div>
        </div>
        <div class="button">
            @auth
                <a href="{{ route('create') }}" class="btn btn-dark btn-lg">Start Writing</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-dark btn-lg">Log in to Start Writing</a>
            @endauth
        </div>
    </div>
</div>

<div class="start">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <h2>You can also read articles</h2>
            </div>
            <div class="col-md-6">
                <p>Start reading by clicking the categories that interest you at the top, or use the search bar to find specific articles.</p>
            </div>
        </div>
    </div>
</div>

@endsection
