<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserContribution;
use App\Models\Contribution;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserContributionService
{
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return UserContribution::with(['user', 'contributionScheme'])->paginate($perPage);
    }

    public function getByUser(int $userId, int $perPage = 10)
    {
        return UserContribution::where('user_id', $user->id)
            ->with(['contributions', 'contributionScheme'])
            ->paginate($perPage);
    }

    public function getById(int $id): ?UserContribution
    {
        return UserContribution::with(['user', 'contributions', 'contributionScheme'])->find($id);
    }

    public function create(array $data): UserContribution
    {
        return UserContribution::create($data);
    }

    public function update(UserContribution $userContribution, array $data): UserContribution
    {
        $userContribution->update($data);
        return $userContribution;
    }

    public function delete(UserContribution $userContribution): void
    {
        $userContribution->delete();
    }

    public function addContribution(UserContribution $userContribution, array $data): Contribution
    {
        return DB::transaction(function () use ($userContribution, $data) {
            // Create the contribution first
            $contribution = $userContribution->contributions()->create([
                'amount' => $data['amount'],
                'status' => 'pending',
            ]);

            // Upload the receipt if provided
            if (isset($data['receipt']) && $data['receipt'] instanceof UploadedFile) {
                $contribution->uploadReceipt($data['receipt']);
            }

            return $contribution;
        });
    }
}
