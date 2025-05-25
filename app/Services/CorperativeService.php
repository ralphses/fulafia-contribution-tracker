<?php

namespace App\Services;

use App\Models\ContributionScheme;
use App\Models\Corperative;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CorperativeService
{
    public function listCorperatives($perPage = 10)
    {
        return Corperative::with('members')->latest()->paginate($perPage);
    }

    public function createCorperative(array $data): Corperative
    {
        return Corperative::create([
            'name' => $data['name'],
            'status' => Utils::STATUS_ACTIVE,
            'user_id' => Auth::id(),
        ]);
    }

    public function updateCorperative(Corperative $corperative, array $data): bool
    {
        return $corperative->update([
            'name' => $data['name'],
            'status' => $data['status'],
        ]);
    }

    public function deleteCorperative(Corperative $corperative): bool
    {
        return $corperative->delete();
    }

    public function addMember(Corperative $corperative, User $user)
    {
        return $corperative->members()->syncWithoutDetaching([$user->id]);
    }

    public function removeMember(Corperative $corperative, User $user)
    {
        return $corperative->members()->detach($user->id);
    }

    public function getCorperativeDetails(Corperative $corperative): Corperative
    {
        return $corperative->load('users', 'createdBy');
    }

    /**
     * Get cooperatives where a specific user is a member.
     */
    public function getCorperativesForMember(User $user, $perPage = 10)
    {
        return $user->corperatives()->with('users')->paginate($perPage);
    }

    /**
     * Get all cooperatives with pagination.
     */
    public function getAllCorperatives($perPage = 10)
    {
        return Corperative::with('users', 'createdBy')->paginate($perPage);
    }

    /**
     * Get all cooperatives created by a specific user.
     */
    public function getCorperativesCreatedByUser(User $user, $perPage = 10)
    {
        return Corperative::where('user_id', $user->id)
            ->with('members', 'createdBy')
            ->latest()
            ->paginate($perPage);
    }

    public function getSchemes($cooperativeId): array
    {
        return ContributionScheme::query()
            ->where('corperative_id', $cooperativeId)
            ->latest()
            ->get(['id', 'name'])
            ->toArray();

    }

    public function findById(int $corperative_id)
    {
        return Corperative::query()->findOrFail($corperative_id);
    }
}
