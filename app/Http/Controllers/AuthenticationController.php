<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Show Registration Form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle User Registration
    public function register(StoreUserRequest $request): RedirectResponse
    {
        // Validate the registration request
        $validatedData = $request->validated();

        // Create the user using the UserService
        $user = $this->userService->createUser($validatedData);

        // Log in the user after successful registration
        Auth::login($user);

        // Redirect to the dashboard or home page
        return redirect()->route('dashboard');
    }

    // Show Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle User Login

    /**
     * @throws ValidationException
     */
    public function login(Request $request): RedirectResponse
    {
        // Validate the login request
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Redirect to the dashboard after successful login
            return redirect()->route('dashboard');
        }

        // If authentication fails, redirect back with an error
        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    // Handle User Logout
    public function logout(): RedirectResponse
    {
        // Log the user out
        Auth::logout();

        // Redirect to the homepage or login page
        return redirect()->route('login');
    }
}
