<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserContribution;
use App\Models\Contribution;
use App\Utils\Utils;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserContributionService
{
    protected ContributionSchemeService $contributionSchemeService;
    protected CorperativeService $corperativeService;

    public function __construct(ContributionSchemeService $contributionSchemeService, CorperativeService $corperativeService) {
        $this->contributionSchemeService = $contributionSchemeService;
        $this->corperativeService = $corperativeService;
    }
    public function getAll($perPage = 10, $selectedScheme = false): LengthAwarePaginator
    {
        $query = UserContribution::query();
        if ($selectedScheme) {
            $query->where('contribution_scheme_id', $selectedScheme);
        }
        return $query->with(['user', 'contributionScheme'])->paginate($perPage ?? 10);
    }

    public function getByUser(int $userId, $selectedScheme = false, int $perPage = 10)
    {
        $query = UserContribution::query()->where('user_id', $userId);
        if ($selectedScheme) {
            $query->where('contribution_scheme_id', $selectedScheme);
        }
        return $query->with(['user', 'contributionScheme'])->paginate($perPage ?? 10);

    }

    public function getById(int $id): ?UserContribution
    {
        return UserContribution::with(['user', 'contributions', 'contributionScheme'])->find($id);
    }

    public function create(array $data): UserContribution
    {
        $userId = Auth::id();
        $scheme = $this->contributionSchemeService->findById($data['scheme']);
        $corperative = $this->corperativeService->findById($scheme->corperative_id);

        // Attach user to the corperative if not already attached
        if (!$corperative->members->contains($userId)) {
            $corperative->members()->attach($userId);
        }

        // Attach user to the contribution scheme if not already attached
        if (!$scheme->members->contains($userId)) {
            $scheme->members()->attach($userId);
        }

        // Create the UserContribution
        return UserContribution::create([
            'user_id' => $userId,
            'name' => $scheme->name,
            'contribution_scheme_id' => $data['scheme'],
            'total_amount' => $scheme->individual_amount
        ]);
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
