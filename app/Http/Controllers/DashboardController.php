<?php

namespace App\Http\Controllers;

use App\Services\ContributionService;
use App\Services\CorperativeService;
use App\Services\UserContributionService;
use App\Services\UserService;
use App\Utils\Utils;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected ContributionService $contributionService;
    protected UserService $userService;
    protected UserContributionService $userContributionService;
    protected CorperativeService  $corperativeService;

    public function __construct(ContributionService $contributionService, UserService $userService, UserContributionService $userContributionService, CorperativeService $corperativeService) {
        $this->contributionService = $contributionService;
        $this->userService = $userService;
        $this->userContributionService = $userContributionService;
        $this->corperativeService = $corperativeService;
    }

    public function index(Request $request)
    {
        $user = $this->userService->getUserById($request->user()->id);

        // Load corperatives with necessary relationships
        $corperatives = $user->corperatives()->with([
            'members:id,role',
            'contributionSchemes.userContributions:id,contribution_scheme_id,user_id,total_amount,withdrawal_status',
            'contributionSchemes.userContributions.contributions:id,user_contribution_id,amount,status'
        ])->get();

        // Init counters
        $totalStudents = 0;
        $totalStaff = 0;
        $totalAmount = 0;
        $amountReceived = 0;
        $amountDisbursed = 0;

        $isRegularUser = in_array($user->role, [Utils::ROLE_STUDENT, Utils::ROLE_STAFF]);

        foreach ($corperatives as $corperative) {

            if (!$isRegularUser) {
                // Only admin needs to count members
                $totalStudents += $corperative->members->where('role', Utils::ROLE_STUDENT)->count();
                $totalStaff += $corperative->members->where('role', Utils::ROLE_STAFF)->count();
            }

            foreach ($corperative->contributionSchemes as $scheme) {
                foreach ($scheme->userContributions as $userContribution) {

                    // For student/staff, consider only their own contributions
                    if ($isRegularUser && $userContribution->user_id !== $user->id) {
                        continue;
                    }

                    // Admin only: count disbursed funds
                    if (!$isRegularUser && $userContribution->withdrawal_status === Utils::WITHDRAWAL_STATUS_SUCCESSFUL) {
                        $amountDisbursed += $userContribution->total_amount;
                    }

                    foreach ($userContribution->contributions as $contribution) {
                        $totalAmount += $contribution->amount;

                        if ($contribution->status === Utils::STATUS_ACTIVE) {
                            $amountReceived += $contribution->amount;
                        }
                    }
                }
            }
        }

        // Return only relevant statistics
        $statistics = $isRegularUser
            ? compact('totalAmount', 'amountReceived')
            : compact('totalStudents', 'totalStaff', 'totalAmount', 'amountReceived', 'amountDisbursed');

        $contributions = $this->contributionService->getAll();

        return view('dashboard.index', compact('contributions', 'statistics', 'isRegularUser'));
    }


}
