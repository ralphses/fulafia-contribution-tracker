<?php

namespace App\Http\Controllers;

use App\Models\ContributionScheme;
use App\Models\UserContribution;
use App\Services\ContributionSchemeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContributionSchemeController extends Controller
{
    protected $service;

    public function __construct(ContributionSchemeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $cooperativeId = $request->get('cooperativeId');
        $contributionSchemes = $this->service->listContributionSchemes($cooperativeId);
        return view('dashboard.contribution_schemes.index', compact('contributionSchemes'));
    }

    public function create()
    {
        return view('contribution_schemes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $this->service->createContributionScheme($request->all());

        return redirect()->route('contribution_schemes.index')->with('success', 'Contribution scheme created successfully!');
    }

    public function show(ContributionScheme $scheme)
    {
        $scheme = $this->service->getContributionSchemeDetails($scheme);
        return view('contribution_schemes.show', compact('scheme'));
    }

    public function edit(ContributionScheme $scheme)
    {
        return view('contribution_schemes.edit', compact('scheme'));
    }

    public function update(Request $request, ContributionScheme $scheme)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $this->service->updateContributionScheme($scheme, $request->all());

        return redirect()->route('contribution_schemes.index')->with('success', 'Contribution scheme updated successfully!');
    }

    public function destroy(ContributionScheme $scheme)
    {
        $this->service->deleteContributionScheme($scheme);

        return redirect()->route('contribution_schemes.index')->with('success', 'Contribution scheme deleted successfully!');
    }

    public function getUserContributions($schemeId): JsonResponse
    {
        // Get User contributions
        $userContributions = $this->service->getUserContributions($schemeId);

        // Convert to JSON
        return response()->json($userContributions);
    }
}
