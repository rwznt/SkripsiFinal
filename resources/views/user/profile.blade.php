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
    .card {
        border: none;
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
    }
    .card-body {
        padding: 2rem;
    }
    .table td:first-child {
        font-weight: bold;
        width: 150px;
    }
    .table td:nth-child(2) {
        width: 10px;
    }
    .btn-outline-dark {
        color: #007bff;
        border-color: #007bff;
    }
    .btn-outline-dark:hover {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    .profile-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #dee2e6;
    }
</style>

<div class="container">
    @if(session('success'))
    <div id="success-alert" class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-12 mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <h4><i class="bi bi-person"></i> My Profile</h4>
                    <div class="text-center mb-4">
                        @if ($user->image)
                            <img src="{{ asset('storage/profile_image/' . $user->image) }}" class="profile-img" alt="Profile Picture">
                        @else
                            <img src="{{ asset('images/default-picture.jpg') }}" class="profile-img" alt="Default Profile Picture">
                        @endif
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td>Email Address</td>
                                <td>:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>Mobile Phone</td>
                                <td>:</td>
                                <td>{{ $user->nohp }}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                <td>{{ $user->gender === 'L' ? 'Male' : 'Female' }}</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td>:</td>
                                <td>{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d M Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>{{ $user->address }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{ route('editprofile') }}" class="btn btn-outline-dark bi bi-person-gear"> Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.transition = "opacity 0.5s ease";
                successAlert.style.opacity = 0;
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }
        }, 5000);
    });
</script>
@endsection
