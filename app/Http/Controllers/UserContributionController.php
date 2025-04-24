<?php

namespace App\Http\Controllers;

use App\Models\UserContribution;
use Illuminate\Http\Request;
use App\Services\UserContributionService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class UserContributionController extends Controller
{
    protected UserContributionService $userContributionService;

    public function __construct(UserContributionService $userContributionService)
    {
        $this->userContributionService = $userContributionService;
    }

    public function index(Request $request): LengthAwarePaginator
    {
        return $this->userContributionService->getAll($request->page);
    }

    /**
     * Display a list of user contributions.
     */
    public function getUserContributions(Request $request)
    {
        $userContributions = $this->userContributionService->getByUser($request->userId);
        return view('user_contributions.index', compact('userContributions'));
    }

    /**
     * Display a list of authenticated user contributions for the logged-in user.
     */
    public function getMyContributions()
    {
        $userContributions = $this->userContributionService->getByUser(Auth::id());
        return view('user_contributions.index', compact('userContributions'));
    }

    /**
     * Show the form to create a new UserContribution.
     */
    public function create()
    {
        return view('user_contributions.create');
    }

    /**
     * Store a newly created UserContribution.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contribution_scheme_id' => 'required|exists:contribution_schemes,id',
        ]);

        $userContribution = $this->userContributionService->create(Auth::id(), $validated);

        return redirect()->route('user-contributions.show', $userContribution->id)
            ->with('success', 'Contribution started successfully.');
    }

    /**
     * Display the specified UserContribution.
     */
    public function show(UserContribution $userContribution)
    {
        $this->authorize('view', $userContribution);

        $contributions = $userContribution->contributions()->latest()->paginate(10);

        return view('user_contributions.show', compact('userContribution', 'contributions'));
    }

    /**
     * Show form to add a contribution to an existing UserContribution.
     */
    public function createContribution(UserContribution $userContribution)
    {
        $this->authorize('update', $userContribution);

        return view('user_contributions.add_contribution', compact('userContribution'));
    }

    /**
     * Store a contribution to the given UserContribution.
     */
    public function storeContribution(Request $request, UserContribution $userContribution)
    {
        $this->authorize('update', $userContribution);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $this->userContributionService->addContribution($userContribution, $validated);

        return redirect()->route('user-contributions.show', $userContribution->id)
            ->with('success', 'Contribution added and pending approval.');
    }
}
