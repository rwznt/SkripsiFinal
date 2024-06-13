@extends('layout.app')
@section('content')

<style>
    .image-placeholder {
        display: inline-block;
        width: 150px;
        height: 150px;
        border: 2px dashed #ccc;
        background: url('/images/placeholder-image.png') center center / cover no-repeat;
        cursor: pointer;
    }

    .image-placeholder img {
        width: 100%;
        height: 100%;
        display: none;
    }

    .image-placeholder input[type="file"] {
        display: none;
    }
</style>

<h1> Create an Article </h1>
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
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
