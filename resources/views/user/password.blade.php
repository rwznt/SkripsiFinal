@extends('layout.app')
@section('content')
<style>
    body{
        background: white;
    }
</style>
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header">Change Password</div>

                <div class="card-body ">
                    <form action="{{ route('password.action') }}" method="POST">
                        @csrf
                        <div class="mb-3 ">
                            <label>Password <span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="old_password" />
                        </div>
                        <div class="mb-3 ">
                            <label>New Password <span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="new_password" />
                        </div>
                        <div class="mb-3 ">
                            <label>New Password Confirmation<span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="new_password_confirmation" />
                        </div>
                        <div class="mb-3 ">
                            <button class="btn btn-outline-primary">Change</button>
                            <a class="btn btn-outline-danger" href="/">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
