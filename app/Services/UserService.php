<?php

namespace App\Services;

use App\Models\User;
use App\Utils\Utils;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UserService
{
    // Create a new user
    public function createUser(array $data, string $password = "password"): User
    {
        $data['password'] = Hash::make($data['password'] ?? $password);
        return User::query()->create($data);
    }

    // Get all users with optional role and status filters
    public function getUsersByFilters(?string $role = null, ?string $status = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = User::query();

        if ($role && in_array($role, Utils::ROLES)) {
            $query->where('role', $role);
        }

        if ($status && in_array($status, Utils::STATUSES)) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    // Get user by ID
    public function getUserById(int $id): User | bool
    {
        try {
            return User::query()->findOrFail($id);
        }catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }

    // Update user
    public function updateUser(int $id, array $data): User
    {
        $user = $this->getUserById($id);

        if (isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user;
    }

    // Toggle user status between active/inactive
    public function toggleUserStatus(int $id): User
    {
        $user = $this->getUserById($id);
        $user->status = $user->status === Utils::STATUS_ACTIVE ? Utils::STATUS_INACTIVE : Utils::STATUS_ACTIVE;
        $user->save();

        return $user;
    }

    // Delete a user
    public function deleteUser(int $id): void
    {
        $user = $this->getUserById($id);
        $user->delete();
    }

    public function findById(int $id)
    {
        return User::query()->findOrFail($id);
    }
}
