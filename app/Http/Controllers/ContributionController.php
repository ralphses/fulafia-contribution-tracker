<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\ContributionScheme;
use App\Models\UserContribution;
use App\Services\ContributionSchemeService;
use App\Services\ContributionService;
use App\Services\UserContributionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    protected ContributionService $service;
    protected UserContributionService $userContributionService;
    protected ContributionSchemeService  $schemeService;

    public function __construct(ContributionService $service, UserContributionService $userContributionService, ContributionSchemeService $schemeService)
    {
        $this->service = $service;
        $this->userContributionService = $userContributionService;
        $this->schemeService = $schemeService;
    }

    public function index()
    {
        $contributions = $this->service->listContributions();
        return view('dashboard.contributions.index', compact('contributions'));
    }

    public function create()
    {
       $cooperatives = $this->service->getUserCooperatives(Auth::id());
       $schemes = $this->schemeService->getUserSchemes(Auth::id());
       $userContributions = $this->userContributionService->getByUser(Auth::id());
        return view('dashboard.contributions.create', compact('cooperatives', 'schemes', 'userContributions'));
    }

    /**
     * Return all contribution schemes for a cooperative
     */
    public function getSchemesByCooperative($id)
    {
        $schemes = ContributionScheme::where('corperative_id', $id)->get(['id', 'name']);
        return response()->json($schemes);
    }

    /**
     * Return all user contributions for the authenticated user and given scheme
     */
    public function getUserContributionsByScheme($id): JsonResponse
    {
        $userId = auth()->id();

        $contributions = UserContribution::where('contribution_scheme_id', $id)
            ->where('user_id', $userId)
            ->get(['id', 'name as description']); // or use 'name' or 'custom label'

        return response()->json($contributions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cooperative_id' => 'required|exists:corperatives,id',
            'contribution_scheme_id' => 'required|exists:contribution_schemes,id',
            'user_contribution_id' => 'required|exists:user_contributions,id',
            'amount' => 'required|numeric|min:1',
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:1000',
        ]);

        $this->service->createContribution($request);

        return redirect()->route('contributions.index')->with('success', 'Contribution submitted successfully!');
    }

    public function show(Contribution $contribution)
    {
        $contribution = $this->service->getContributionDetails($contribution);
        return view('contributions.show', compact('contribution'));
    }

    public function approve(Contribution $contribution)
    {
        $this->service->approveContribution($contribution);
        return back()->with('success', 'Contribution approved.');
    }

    public function reject(Request $request, Contribution $contribution)
    {
        $request->validate([
            'admin_note' => 'required|string'
        ]);

        $this->service->rejectContribution($request, $contribution);
        return back()->with('error', 'Contribution rejected.');
    }

    public function myContributions()
    {
        $contributions = $this->service->myContributions();
        return view('contributions.my', compact('contributions'));
    }

    public function destroy(Contribution $contribution)
    {
        $result = $this->service->deleteContribution($contribution);

        if (!$result) {
            return back()->with('error', 'Cannot delete an approved contribution.');
        }

        return redirect()->route('contributions.index')->with('success', 'Contribution deleted.');
    }

    public function requestWithDrawal(Request $request, Contribution $contribution)
    {

    }
}
