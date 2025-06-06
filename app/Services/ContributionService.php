<?php

namespace App\Services;

use App\Models\Contribution;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContributionService
{
    public function listContributions($id = false, int $page = 10): LengthAwarePaginator
    {
        return User::query()
            ->find($id ?: Auth::id())
            ->contributions()
            ->latest()
            ->paginate($page);
    }

    public function getAll(int $page = 10, $userId=false): LengthAwarePaginator
    {
        $query = Contribution::query();
        if ($userId) {
            $query->where('user_id', $userId);
        }
        return $query
            ->latest()
            ->paginate($page);
    }

    public function createContribution(Request $request)
    {
        $path = $request->file('receipt')->store('receipts', 'public');

        return Contribution::query()
            ->create(
                [
                    'user_id' => Auth::id(),
                    'contribution_scheme_id' => $request->contribution_scheme_id,
                    'amount' => $request->amount,
                    'contributed_at' => now(),
                    'user_contribution_id' => $request->user_contribution_id,
                    'note' => $request->note,
                    'receipt_path' => $path,
                    'status' => Utils::STATUS_ACTIVE,
                ]
            );
    }

    public function getContributionDetails(Contribution $contribution): Contribution
    {
        return $contribution->load(['user', 'scheme']);
    }

    public function approveContribution(Contribution $contribution): bool
    {
        return $contribution->update([
            'status' => 'approved',
            'admin_note' => 'Approved by admin.',
        ]);
    }

    public function rejectContribution(Request $request, Contribution $contribution)
    {
        return $contribution->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note
        ]);
    }

    public function myContributions()
    {
        return Contribution::with('scheme')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
    }

    public function deleteContribution(Contribution $contribution)
    {
        if ($contribution->status === 'approved') {
            return false;
        }

        if (Storage::disk('public')->exists($contribution->receipt_path)) {
            Storage::disk('public')->delete($contribution->receipt_path);
        }

        return $contribution->delete();
    }

    public function getUserCooperatives(int|null $id)
    {
        $id = $id ?? Auth::id();

        return User::query()->find($id)
            ->corperatives()
            ->where('status', Utils::STATUS_ACTIVE)
            ->get();
    }
}
