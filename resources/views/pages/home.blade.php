@extends('layout.app')

@section('content')

<style>
    .words {
      text-align: left;
      margin-left: 27px;
    }

    .leadword {
        margin-top: 27px;
        size: 360px;
    }

    .leaddesc {
        margin-top: 40px;
        size: 144px;
    }

    .button {
      text-align: right;
      margin-right: 27px;
      margin-top: 60px;
    }

    .welcome-section{
        width: 100%;
        height: 500px;
    }
    .start{
        width: 100%;
        height: 500px;
    }
</style>

<div class="container">
    <div class="category-scroll-wrapper text-center">
        <div class="row flex-nowrap overflow-auto">
            @foreach ($categories as $kategori)
                <div class="col-auto">
                    <button class="btn btn-primary">{{ $kategori->name }}</button>
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
        <div class='button'>
            <button class="btn btn-dark btn-lg">Start Writing</button>
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
                <p>Start Reading by clicking the Categories that you like at the top or you can search it using the Search bar</p>
            </div>
        </div>
    </div>
</div>

@endsection


