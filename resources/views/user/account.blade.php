@extends('layout.app')

@section('title', $title)

@section('content')

<style>
    .profile-picture {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        margin: 20px auto;
    }
    .profile-stats {
        text-align: center;
        margin-top: 20px;
    }
    .profile-stats span {
        display: inline-block;
        margin: 0 15px;
    }
    .follow-button {
        margin-top: 10px;
    }
    .article-list-item {
        cursor: pointer; /* Optional: Add pointer cursor for list items */
    }

    /* Responsive Styling */
    @media (max-width: 576px) {
        .profile-picture {
            width: 120px;
            height: 120px;
            margin: 10px auto;
        }
        .profile-stats {
            margin-top: 10px;
        }
        .article-list-item {
            padding: 10px; /* Add padding to list items for better touch interaction */
        }
    }
</style>

<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    {{-- User Profile Header --}}
                    @include('user.partials.profile_header')
                </div>

                <div class="card-body">
                    {{-- Articles Section --}}
                    @include('user.partials.articles_section')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
