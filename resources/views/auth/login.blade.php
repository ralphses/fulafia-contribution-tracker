@extends('layouts.simple')

@section('content')
    <!-- Page Content -->
    <div class="bg-gd-dusk">
        <div class="hero-static content content-full bg-body-extra-light">
            <!-- Header -->
            <div class="py-4 px-1 text-center mb-4">
                <!-- Logo with Image and Name -->
                <a class="link-fx fw-bold" href="{{ route("login") }}">
                    <img src="{{ asset('media/photos/logo_new.png') }}" alt="Logo" style="max-height: 120px; margin-right: 80px;">
                </a>

                <h1 class="h3 fw-bold mt-5 mb-2">FULAFIA COOPERATIVE CONTRIBUTIONS</h1>
                <h2 class="h5 fw-medium text-muted mb-0">Sign In to Your Account</h2>
            </div>
            <!-- END Header -->

            <!-- Login Form -->
            <div class="row justify-content-center px-1">
                <div class="col-sm-8 col-md-6 col-xl-4">
                    <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js -->
                    <form class="js-validation-signin" action="{{ route('login') }}" method="POST">
                        @csrf <!-- Include CSRF Token for Laravel form submission -->

                        <!-- Email Input -->
                        <div class="form-floating mb-4">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="login-email" name="email" value="{{ old('email') }}"
                                   placeholder="Enter your email" required>
                            <label class="form-label" for="login-email">Email Address</label>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="login-password" name="password" placeholder="Enter your password" required>
                            <label class="form-label" for="login-password">Password</label>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-sm mb-4">
                            <div class="col-12 mb-2">
                                <button type="submit" style="color: #FFFFFF; background-color: #57430ED9" class="btn btn-lg btn-alt-primary w-100 py-3 fw-semibold">
                                    Sign In
                                </button>
                            </div>
                            <div class="col-12 mt-3">
                                <p class="text-muted text-center" style="color: #57430ED9">Don't have an account? <a
                                        href="{{ route('register') }}" class="fw-semibold" style="color: #000000">Register</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Login Form -->
        </div>
    </div>
    <!-- END Page Content -->
@endsection
