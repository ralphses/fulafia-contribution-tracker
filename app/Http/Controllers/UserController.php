<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\FilterUsersRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Show all users (with optional filters)
    public function index(FilterUsersRequest $request): View
    {
        $users = $this->userService->getUsersByFilters(
            $request->input('role'),
            $request->input('status'),
            $request->input('per_page', 10)
        );

        return view('users.index', compact('users'));
    }

    // Show create user form
    public function create(): View
    {
        return view('users.create');
    }

    // Handle user creation
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->createUser($request->validated());
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Show specific user details
    public function show(int $id): View
    {
        $user = $this->userService->getUserById($id);
        return view('users.show', compact('user'));
    }

    // Show edit form
    public function edit(int $id): View
    {
        $user = $this->userService->getUserById($id);
        return view('users.edit', compact('user'));
    }

    // Handle user update
    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $this->userService->updateUser($id, $request->validated());
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Toggle user status
    public function toggleStatus(int $id): RedirectResponse
    {
        $this->userService->toggleUserStatus($id);
        return back()->with('success', 'User status toggled successfully.');
    }

    // Handle user deletion
    public function destroy(int $id): RedirectResponse
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
