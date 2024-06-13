@extends('layout.app')

@section('content')
<style>
    body{
        background: white;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-light"><a href="/" class="text-light text-decoration-none">Home</a></li>
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
                                <td width="10">:</td>
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
                            <tr>
                                <a href="{{ url('editprofile')}}" class="btn btn-outline-dark bi bi-person-gear">   Edit Profile</a>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
