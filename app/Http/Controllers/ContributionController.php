<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\ContributionScheme;
use App\Models\Corperative;
use App\Models\User;
use App\Services\ContributionService;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    protected ContributionService $service;

    public function __construct(ContributionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $contributions = $this->service->listContributions();
        return view('dashboard.contributions.index', compact('contributions'));
    }

    public function create()
    {
       $cooperatives = $this->service->getUserCooperatives(Auth::id());
        return view('dashboard.contributions.create', compact('cooperatives'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contribution_scheme_id' => 'required|exists:contribution_schemes,id',
            'amount' => 'required|numeric|min:0',
            'contributed_at' => 'required|date',
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'note' => 'nullable|string'
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
