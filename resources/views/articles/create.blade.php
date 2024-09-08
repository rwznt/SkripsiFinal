@extends('layout.app')

@php
$isAdmin = Auth::user()->isAdmin();
@endphp

@section('content')

<style>
    .note-editor .dropdown-toggle::after {
        all: unset;
    }

    .note-editor .note-dropdown-menu {
        box-sizing: content-box;
    }

	.note-editor .note-modal-footer {
        box-sizing: content-box;
    }

    .note-editor .note-editable {
        line-height: 1;
    }

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

<div class="container">
    <h1 class="my-4 text-left">Create New Article</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <div class="form-group">
            @if ($isAdmin)
            <input type="hidden" name="is_admin" value="{{ $isAdmin ? 1 : 0 }}">
            @endif
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
        
        @if ($isAdmin)
        <div class="form-group">
            <label for="article-type">Article Type:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="article-type" id="article-type-article" value="article" checked>
                <label class="form-check-label" for="article-type-article">Article</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="article-type" id="article-type-development" value="development">
                <label class="form-check-label" for="article-type-development">Articreate Development</label>
            </div>
        </div>
        @endif

        <div class="form-group information">
            <label for="information-source">Information Source:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="information-source" id="source-others" value="others" checked>
                <label class="form-check-label" for="source-others">From Others</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="information-source" id="source-personal" value="personal">
                <label class="form-check-label" for="source-personal">From Personal</label>
            </div>
            <div id="source-others-input" style="display: block;">
                <input type="text" id="source-link" name="source-link" class="form-control" placeholder="Enter link">
            </div>
            <div id="source-personal-input" style="display: none;">
                <input type="text" id="source-text" name="source-text" class="form-control" placeholder="Enter text">
                <label for="source-file">Upload file (video, mp3, or image):</label>
                <input type="file" id="source-file" name="source-file" accept="video/*, audio/*, image/*" class="form-control-file">
            </div>
        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" class="form-control content" placeholder="Content" rows="6" required></textarea>
            <div class="invalid-feedback">Please enter the content.</div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </form>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" integrity="sha512-ZbehZMIlGA8CTIOtdE+M81uj3mrcgyrh6ZFeG33A4FHECakGrOsTPlPQ8ijjLkxgImrdmSVUHn1j+ApjodYZow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" integrity="sha512-lVkQNgKabKsM1DA/qbhJRFQU8TuwkLF2vSN3iU/c7+iayKs08Y8GXqfFxxTZr1IcpMovXnf2N/ZZoMgmZep1YQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $('#content').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            autofocus: false,
            toolbar: [
              ['style', ['bold', 'italic', 'underline']],
              ['font', ['strikethrough', 'superscript', 'subscript']],
              ['fontname', ['fontname']],
              ['fontsize', ['fontsize']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['height', ['height']],
              ['insert', ['link', 'picture', 'video']]
            ],
            // callbacks: {
            //     onImageUpload: function(files, editor, welEditable) {
            //         console.log('onImageUpload callback function triggered');
            //         var formData = new FormData();
            //         formData.append('image', files[0]);
            //         formData.append('_token', '{{ csrf_token() }}'); // Add CSRF token
                
            //         $.ajax({
            //             url: '/upload-image',
            //             type: 'POST',
            //             data: formData,
            //             cache: false,
            //             contentType: false,
            //             processData: false,
            //             success: function(data) {
            //                 console.log('Image uploaded successfully:', data);
            //                 if (data.url) {
            //                     editor.summernote('editor.insertImage', data.url);
            //                 } else {
            //                     console.error('Error uploading image: no URL returned');
            //                 }
            //             },
            //             error: function(xhr, status, error) {
            //                 console.error('Error uploading image:', error);
            //             }
            //         });
            //     }
            // }
        });

        $('input[name="information-source"]').on('change', function() {
            if ($(this).val() == 'others') {
                $('#source-others-input').show();
                $('#source-personal-input').hide();
            } else {
                $('#source-others-input').hide();
                $('#source-personal-input').show();
            }
        });

        $('input[name="article-type"]').on('change', function() {
            if ($(this).val() == 'development') {
                $('.information').hide();
            } else {
                $('.information').show();
            }
        });
    });

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
