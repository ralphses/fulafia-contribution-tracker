<?php

namespace App\Services;

use App\Models\ContributionScheme;
use App\Models\UserContribution;
use Illuminate\Support\Facades\Auth;

class ContributionSchemeService
{
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
        return ContributionScheme::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'created_by' => Auth::id(),
            'status' => $data['status'],
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
}
