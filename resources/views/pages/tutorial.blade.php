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

    .tutorial {
        background-color: #f7f7f7;
        padding: 50px 0;
    }

    .tutorial h2 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .tutorial p {
        font-size: 1.1rem;
        line-height: 1.6;
    }
</style>

<div class="welcome-section">
    <div class="container">
        <div class="words text-center">
            <div class="leadword">
                <h1 class="display-3">Tutorial on creating an article</h1>
                <h1 class="display-3">in ArtiCreate</h1>
            </div>
        </div>
    </div>
</div>

<div class="tutorial py-5">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="display-5">Steps to create article</h2>
                <p class="lead">Here are the steps that you have to do to create an article in ArtiCreate:</p>
                <ol>
                    <li>Find the topic needed or want to be discussed.</li>
                    <li>Look for valid data that supports the topic you choose.
                        The data you are looking for can come from anywhere, such as:</li>
                    <ul>
                        <li>
                            Search through the internet through journals that discuss the topic you choose.
                            If the topic you choose has an institution that is a valid source, you can quote information from that institution.
                        </li>
                    </ul>
                    <li>After finding valid data related to the selected topic, Compile the content of your article. </li>
                    <li>Click "create" to start creating an article.</li>
                    <li>Select the category of article.</li>
                    <li>Input desired title for the article.</li>
                    <li>Input an image related to the article.</li>
                    <li>Write the content of the article in the designated column.</li>
                    <li>If it's everything, click "create" in the lower right corner.</li>
                    <li>Created Articles will be evaluated by admins.</li>
                </ol>
            </div>
        </div>

        <div class="button text-center">
            <p class="display-5">Ready to start?</p>
            @auth
                <a href="{{ route('set-from-tutorial') }}" class="btn btn-dark btn-lg">Start Articreating</a>
            @else
                <a href="{{ route('set-from-tutorial') }}" class="btn btn-dark btn-lg">Log in to Start Articreating </a>
            @endauth
        </div>

    </div>
</div>

@endsection
