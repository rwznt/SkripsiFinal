@extends('layout.app')

@section('content')
<style>
    body{
        background: white;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('profile') }}" class="btn btn-outline-light mt-2 mb-2 bi bi-chevron-left"><i class=""></i> Back</a>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-light"><a href="/"class="text-light text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-light" aria-current="page"><a href="{{ url('profile')}}" class="text-light text-decoration-none">Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
            </ol>
        </nav>
        <div class="col-md-12 mt-2">
            <div class="card shadow">
                <div class="card-body">
                    <h4><i class="bi bi-person-gear"></i> Edit Profile</h4>
                    <form method="POST" action="{{ url('editprofile') }}">
                        @csrf

                        <div class="form-group mb-3 row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="nohp" class="col-md-2 col-form-label text-md-right">Mobile Phone</label>

                            <div class="col-md-6">
                                <input id="nohp" type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp" value="{{ $user->nohp }}" required autocomplete="nohp" autofocus>

                                @error('nohp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="alamat" class="col-md-2 col-form-label text-md-right">Address</label>

                            <div class="col-md-6">
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" required="">{{ $user->address }}</textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-outline-dark">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
