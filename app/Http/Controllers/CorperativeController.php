<?php

namespace App\Http\Controllers;

use App\Models\ContributionScheme;
use App\Models\Corperative;
use App\Models\User;
use App\Services\CorperativeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CorperativeController extends Controller
{
    protected CorperativeService $corperativeService;

    public function __construct(CorperativeService $corperativeService)
    {
        $this->corperativeService = $corperativeService;
    }

    public function index(Request $request)
    {
        $cooperatives = $this->corperativeService->getCorperativesCreatedByUser($request->user(), $request->get('per_page', 10));
        return view('dashboard.cooperatives.index', compact('cooperatives'));
    }

    public function create()
    {
        return view('dashboard.cooperatives.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255'
        ]);

        $this->corperativeService->createCorperative($request->only(['name']));

        return redirect()->route('cooperatives')->with('success', 'Corperative created successfully.');
    }

    public function show(Corperative $corperative)
    {
        $details = $this->corperativeService->getCorperativeDetails($corperative);
        return view('corperatives.show', compact('details', 'corperative'));
    }

    public function edit(Corperative $corperative)
    {
        return view('corperatives.edit', compact('corperative'));
    }

    public function update(Request $request, Corperative $corperative)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive'
        ]);

        $this->corperativeService->updateCorperative($corperative, $request->only(['name', 'status']));

        return redirect()->route('corperatives.index')->with('success', 'Corperative updated successfully.');
    }

    public function destroy(Corperative $corperative)
    {
        $this->corperativeService->deleteCorperative($corperative);

        return redirect()->route('corperatives.index')->with('success', 'Corperative deleted successfully.');
    }

    public function addMember(Request $request, Corperative $corperative)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $this->corperativeService->addMember($corperative, $user);

        return back()->with('success', 'Member added successfully.');
    }

    public function removeMember(Request $request, Corperative $corperative)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $this->corperativeService->removeMember($corperative, $user);

        return back()->with('success', 'Member removed successfully.');
    }



    //////--------API ROUTES------------------///////////
    // CooperativeController.php
    public function getSchemes($cooperativeId): JsonResponse
    {
        // Get schemes
        $schemes = $this->corperativeService->getSchemes($cooperativeId);

        // Convert to JSON
        return response()->json($schemes);
    }
}
