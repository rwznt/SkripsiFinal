@extends('layout.app')

@section('content')
<style>
    body {
        background: white;
    }

    .card {
        border: none;
    }

    .card-header {
        background-color: #f8f9fa; /* Light gray background for header */
        border-bottom: 1px solid #dee2e6; /* Border bottom for separation */
        font-weight: bold; /* Bold header text */
    }

    .form-control {
        border: 1px solid #ced4da; /* Gray border for form controls */
    }

    .form-control:focus {
        border-color: #007bff; /* Focus color for form controls */
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25); /* Focus box shadow */
    }

    .btn-outline-primary {
        color: #007bff; /* Bootstrap primary color for button text */
        border-color: #007bff; /* Bootstrap primary color for button border */
    }

    .btn-outline-primary:hover {
        color: #fff; /* White text on hover */
        background-color: #007bff; /* Bootstrap primary color for background */
        border-color: #007bff;
    }

    .text-md-end {
        text-align: end; /* Right align text for medium size and larger screens */
    }

    .text-decoration-none {
        color: #007bff; /* Bootstrap primary color for links */
    }
</style>

<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">Login</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-outline-primary">
                                    {{ __('Login') }}
                                </button>
                                <div class="mt-2">
                                    <p>Don’t have an account? <a href="/register" class="text-decoration-none">Sign Up</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
