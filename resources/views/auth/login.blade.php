@extends('layouts.guest')
@section('content')
<div class="container">
    <div class="col-6 text-center mx-auto">
        <button class="btn btn-custom btn-lg">Login</button>
        <button class="btn btn-custom btn-lg">Register</button>
    </div>
    <form method="POST" action="{{ route('auth.login') }}" class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="mb-3">
                <label for="email_address" class="form-label fw-bolder">Email address</label>
                <input type="email" class="form-control" id="email_address" name="email_address" placeholder="name@example.com">
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bolder">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-custom-success btn-lg mb-3">Proceed</button>
            <a href="#" class="btn-link d-block">Forgot your passowrd?</a>
        </div>
    </form>
</div>
@endsection