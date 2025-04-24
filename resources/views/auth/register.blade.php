@php use App\Utils\Utils; @endphp
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

                <h1 class="h3 fw-bold mt-5 mb-2">FULAFIA COORPERATIVE CONTRIBUTIONS</h1>
                <h2 class="h5 fw-medium text-muted mb-0">Join Us!</h2>
            </div>
            <!-- END Header -->


            <!-- Registration Form -->
            <div class="row justify-content-center px-1">
                <div class="col-sm-8 col-md-6 col-xl-4">
                    <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js -->
                    <form class="js-validation-signin" action="{{ route('register') }}" method="POST">
                        @csrf <!-- Include CSRF Token for Laravel form submission -->

                        <!-- Name Input -->
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="register-name" name="name" value="{{ old('name') }}"
                                   placeholder="Enter your name" required>
                            <label class="form-label" for="register-name">Full Name</label>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div class="form-floating mb-4">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="register-email" name="email" value="{{ old('email') }}"
                                   placeholder="Enter your email" required>
                            <label class="form-label" for="register-email">Email Address</label>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="register-password" name="password" placeholder="Enter your password" required>
                            <label class="form-label" for="register-password">Password</label>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="form-floating mb-4">
                            <input type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   id="register-password-confirm" name="password_confirmation"
                                   placeholder="Confirm your password" required>
                            <label class="form-label" for="register-password-confirm">Confirm Password</label>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role Input (if applicable) -->
                        <div class="form-floating mb-4">
                            <select class="form-control @error('role') is-invalid @enderror" id="register-role"
                                    name="role" required>
                                <option value="" disabled selected>Select Role</option>
                                <!-- Assuming you have an array of roles in your Utils class -->
                                @foreach (Utils::ROLES as $role)
                                    <option
                                        value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="register-role">Role</label>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number Input -->
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                   id="register-phone" name="phone_number" value="{{ old('phone_number') }}"
                                   placeholder="Enter your phone number">
                            <label class="form-label" for="register-phone">Phone Number</label>
                            @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-sm mb-4">
                            <div class="col-12 mb-2">
                                <button type="submit" style="color: #FFFFFF; background-color: #57430ED9" class="btn btn-lg btn-alt-primary w-100 py-3 fw-semibold">
                                    Register
                                </button>
                            </div>
                            <div class="col-12 mt-3">
                                <p class="text-muted text-center" style="color: #57430ED9">Already have an account? <a
                                        href="{{ route('login') }}" class="fw-semibold" style="color: #000000">Sign In</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Registration Form -->
        </div>
    </div>
    <!-- END Page Content -->
@endsection
