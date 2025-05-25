<?php

namespace App\Services;

use App\Models\ContributionScheme;
use App\Models\UserContribution;
use App\Utils\Utils;
use Illuminate\Support\Facades\Auth;

class ContributionSchemeService
{
    protected CorperativeService $corperativeService;
    protected UserService $userService;

    public function __construct(CorperativeService $corperativeService, UserService $userService) {
        $this->corperativeService = $corperativeService;
        $this->userService = $userService;
    }
    public function listContributionSchemes(int $cooperativeId = 0, int $perPage = 10)
    {
        $query = ContributionScheme::query();

        if ($cooperativeId && $cooperativeId > 0) {
            $query->where('corperative_id', $cooperativeId);
        }

        return $query->latest()->paginate($perPage);
    }

    public function createContributionScheme($data)
    {
        $user = $this->userService->findById(Auth::id());
        return ContributionScheme::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'payment_time' => $data['payment_time'],
            'penalty_fee' => $data['penalty_fee'],
            'total_times' => $data['total_times'],
            'individual_amount' => $data['total_amount'],
            'created_by' => $user->id,
            'corperative_id' => $data['corperative_id'],
            'status' => Utils::STATUS_ACTIVE,
        ]);
    }

    public function getContributionSchemeDetails(ContributionScheme $scheme)
    {
        return $scheme;
    }

    public function updateContributionScheme(ContributionScheme $scheme, $data)
    {
        return $scheme->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'status' => $data['status'],
        ]);
    }

    public function deleteContributionScheme(ContributionScheme $scheme)
    {
        return $scheme->delete();
    }

    public function getUserContributions($schemeId): array
    {
        return UserContribution::query()
            ->where('contribution_scheme_id', $schemeId)
            ->latest()
            ->get(['id', 'name'])
            ->toArray();
    }

    public function getAdminCreatedScheme($adminId, $ispaginated = false, $page = 1, $perPage = 10)
    {
        $query = ContributionScheme::query()
            ->with(['corperative', 'userContributions'])
            ->where('created_by', $adminId)
            ->latest();
        if ($ispaginated) {
            return $query->paginate($perPage, ['*'], 'page', $page);
        }
        return $query->get();
    }

    public function findById(int $scheme)
    {
        return ContributionScheme::query()->find($scheme);
    }

    public function getUserSchemes(int $id)
    {
        return $this->userService->getUserById($id)->contributionSchemes()->latest()->get();
    }
}
