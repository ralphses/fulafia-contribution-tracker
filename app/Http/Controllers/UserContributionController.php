<?php

namespace App\Http\Controllers;

use App\Models\UserContribution;
use App\Services\ContributionSchemeService;
use Illuminate\Http\Request;
use App\Services\UserContributionService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class UserContributionController extends Controller
{
    protected UserContributionService $userContributionService;
    protected ContributionSchemeService $contributionSchemeService;

    public function __construct(UserContributionService $userContributionService, ContributionSchemeService $contributionSchemeService)
    {
        $this->userContributionService = $userContributionService;
        $this->contributionSchemeService = $contributionSchemeService;
    }

    public function index(Request $request)
    {
        $selectedScheme = $request->get('scheme_id');
        $members = true;
        $contributionSchemes = $this->contributionSchemeService->getAdminCreatedScheme($request->user()->id);
        $userContributions = $this->userContributionService->getAll($request->page, $selectedScheme);
        return view('dashboard.user_contributions.index', compact('userContributions', 'members', 'contributionSchemes', 'selectedScheme'));
    }

    /**
     * Display a list of user contributions.
     */
    public function getUserContributions(Request $request)
    {
        $selectedScheme = $request->get('scheme_id');
        $members = false;
        $contributionSchemes = $this->contributionSchemeService->getAdminCreatedScheme($request->user()->id);
        $userContributions = $this->userContributionService->getByUser($request->user()->id, $selectedScheme);
        return view('dashboard.user_contributions.index', compact('userContributions', 'members', 'contributionSchemes', 'selectedScheme'));
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
//        dd($request->all());
        $validated = $request->validate([
            'scheme' => 'required|exists:contribution_schemes,id',
        ]);

        $userContribution = $this->userContributionService->create($validated);

        return redirect()->route('userContributions.user', $userContribution->id)
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
