@extends('layout.app')

@section('content')
<style>
    body {
        background: white;
    }
    .breadcrumb {
        background-color: #f8f9fa; /* Light gray background for better contrast */
        border-radius: 0.25rem; /* Slightly rounded corners */
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d; /* Gray color for separators */
    }
    .breadcrumb-item a {
        color: #007bff; /* Bootstrap primary color for links */
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #6c757d; /* Gray color for active item */
    }
    .card {
        border: none;
    }
    .card-body {
        padding: 2rem;
    }
    .table td:first-child {
        font-weight: bold;
        width: 150px; /* Adjust width as needed */
    }
    .table td:nth-child(2) {
        width: 10px; /* Colon width */
    }
    .btn-outline-dark {
        color: #007bff; /* Bootstrap primary color for button text */
        border-color: #007bff; /* Bootstrap primary color for button border */
    }
    .btn-outline-dark:hover {
        color: #fff;
        background-color: #007bff; /* Bootstrap primary color for button background on hover */
        border-color: #007bff;
    }
</style>

<div class="container">
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
                                <td>Address</td>
                                <td>:</td>
                                <td>{{ $user->address }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{ url('editprofile') }}" class="btn btn-outline-dark bi bi-person-gear"> Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
