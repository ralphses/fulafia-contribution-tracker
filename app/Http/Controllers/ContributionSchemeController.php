<?php

namespace App\Http\Controllers;

use App\Models\ContributionScheme;
use App\Models\UserContribution;
use App\Services\ContributionSchemeService;
use App\Services\CorperativeService;
use App\Utils\Utils;
use Hamcrest\Util;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContributionSchemeController extends Controller
{
    protected ContributionSchemeService $service;
    protected CorperativeService $corperativeService;

    public function __construct(ContributionSchemeService $service, CorperativeService $corperativeService)
    {
        $this->service = $service;
        $this->corperativeService = $corperativeService;
    }

    public function index(Request $request)
    {
        $cooperativeId = $request->get('cooperativeId') ?? 0;
        $contributionSchemes = $this->service->listContributionSchemes($cooperativeId);
        return view('dashboard.contribution_schemes.index', compact('contributionSchemes'));
    }

    public function create()
    {
        $types = Utils::TYPES;
        $corperatives = $this->corperativeService->listCorperatives();
        return view('dashboard.contribution_schemes.create', compact(
            'corperatives',
            'types'
        ));
    }

    public function store(Request $request)
    {
        // Define valid options for each type
        $validWeekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $validMonths = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $validQuarterlyMonths = [
            'January', 'February', 'March',     // Q1
            'April', 'May', 'June',             // Q2
            'July', 'August', 'September',     // Q3
            'October', 'November', 'December'  // Q4
        ];

        // Basic validation for required fields and type
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(Utils::TYPES)],
            'payment_time' => ['required'],
            'penalty_fee' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'total_times' => 'required|integer|min:1',
            'corperative_id' => 'required|exists:corperatives,id',
        ]);

        // Additional validation for payment_time based on type
        $type = $request->input('type');
        $paymentTime = $request->input('payment_time');

        $data = $request->all();
        $validator = Validator::make($data, []);

        switch ($type) {
            case 'daily':
                // Validate time format HH:MM (24-hour)
                $validator = Validator::make($data, [
                    'payment_time' => ['required', 'date_format:H:i'],
                ]);
                break;

            case 'weekly':
                // Validate payment_time is a weekday
                $validator = Validator::make($data, [
                    'payment_time' => ['required', Rule::in($validWeekdays)],
                ]);
                break;

            case 'monthly':
                // Validate payment_time is a day number 1-31
                $validator = Validator::make($data, [
                    'payment_time' => ['required', 'integer', 'between:1,31'],
                ]);
                break;

            case 'quarterly':
                // Validate payment_time is a valid month (for quarter)
                $validator = Validator::make($data, [
                    'payment_time' => ['required', Rule::in($validQuarterlyMonths)],
                ]);
                break;

            case 'yearly':
                // Validate payment_time is a valid month
                $validator = Validator::make($data, [
                    'payment_time' => ['required', Rule::in($validMonths)],
                ]);
                break;

            default:
                return back()->withErrors(['type' => 'Invalid type selected.']);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        // Now create the scheme using service
        $this->service->createContributionScheme($data);

        return redirect()->route('contributions.schemes')
            ->with('success', 'Contribution scheme created successfully!');
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
