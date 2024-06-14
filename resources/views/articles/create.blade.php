@extends('layout.app')
@section('content')

<style>
    .image-placeholder {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 150px;
        height: 150px;
        border: 2px dashed #ccc;
        border-radius: 10px;
        background: url('/images/placeholder-image.png') center center / cover no-repeat;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .image-placeholder:hover {
        background-color: #f0f0f0;
    }

    .image-placeholder img {
        width: 100%;
        height: 100%;
        display: none;
        border-radius: 10px;
    }

    .image-placeholder input[type="file"] {
        display: none;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-group .invalid-feedback {
        display: none;
    }

    .form-group input:invalid ~ .invalid-feedback,
    .form-group textarea:invalid ~ .invalid-feedback,
    .form-group select:invalid ~ .invalid-feedback {
        display: block;
    }

    .btn-primary {
        background-color: #00AEEF;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #007bb5;
    }
</style>

<h1 class="my-4 text-center">Create an Article</h1>
<form action="{{ route('create') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="dropdown">Choose a category:</label>
        <select name="dropdown" id="dropdown" class="form-control" required>
            <option value="">Select Category...</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">Please select a category.</div>
    </div>
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="form-control" placeholder="Title" required>
        <div class="invalid-feedback">Please enter a title.</div>
    </div>
    <div class="form-group">
        <label for="image">Image:</label>
        <label class="image-placeholder">
            <img id="image-preview" src="" alt="Image Preview" class="img-fluid">
            <input type="file" name="image" accept="image/*" id="image" onchange="previewImage(event)" class="form-control-file">
        </label>
    </div>
    <div class="form-group">
        <label for="content">Content:</label>
        <textarea id="content" name="content" class="form-control" placeholder="Content" rows="6" required></textarea>
        <div class="invalid-feedback">Please enter the content.</div>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Submit</button>
</form>

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
