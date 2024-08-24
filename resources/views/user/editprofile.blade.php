@extends('layout.app')

@section('content')
<style>
    body {
        background: white;
    }
    .breadcrumb {
        background-color: #f8f9fa;
        border-radius: 0.25rem;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }
    .breadcrumb-item a {
        color: #007bff;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #6c757d;
    }
    .btn-outline-light {
        color: #007bff;
        border-color: #007bff;
    }
    .btn-outline-light:hover {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    .card {
        border: none;
    }
    .card-body {
        padding: 2rem;
    }
    .form-group label {
        font-weight: bold;
    }
    .form-control {
        border-radius: 0.25rem;
    }
    .invalid-feedback {
        display: block;
    }
    .image-placeholder {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 150px;
        height: 150px;
        border: 2px dashed #ccc;
        border-radius: 10px;
        background: url('{{ $user->image ? asset("profile/" . $user->image) : asset("images/placeholder-image.png") }}') center center / cover no-repeat;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .image-placeholder:hover {
        background-color: #f0f0f0;
    }
    .image-placeholder img {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        display: none;
    }
    .image-placeholder input[type="file"] {
        display: none;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url()->previous() }}" class="btn btn-outline-light mt-2 mb-2 bi bi-chevron-left"> Back</a>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
            </ol>
        </nav>
        <div class="col-md-12 mt-2">
            <div class="card shadow">
                <div class="card-body">
                    <h4><i class="bi bi-person-gear"></i> Edit Profile</h4>
                    <form method="POST" action="{{ route('updateprofile') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3 row">
                            <label for="image" class="col-md-2 col-form-label text-md-right">Image</label>
                            <div class="col-md-6">
                                <label class="image-placeholder">
                                    <img id="image-preview" src="{{ $user->image ? asset('profile/' . $user->image) : asset('images/placeholder-image.png') }}" alt="Image Preview" class="img-fluid">
                                    <input type="file" name="image" accept="image/*" id="image" onchange="previewImage(event)" class="form-control-file">
                                </label>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">E-Mail Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
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
                                <input id="nohp" type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp" value="{{ old('nohp', $user->nohp) }}">
                                @error('nohp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="col-md-2 col-form-label text-md-right">Gender</label>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_male" value="L" {{ old('gender', $user->gender) === 'L' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender_male">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_female" value="P" {{ old('gender', $user->gender) === 'P' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender_female">
                                        Female
                                    </label>
                                </div>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="date_of_birth" class="col-md-2 col-form-label text-md-right">Date of Birth</label>
                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}">
                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="address" class="col-md-2 col-form-label text-md-right">Address</label>
                            <div class="col-md-6">
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="just_registered" value="{{ session('just_registered') ? 'true' : 'false' }}">

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

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

@endsection
