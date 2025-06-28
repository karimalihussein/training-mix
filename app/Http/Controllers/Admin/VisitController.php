<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with('user', 'office')->orderBy('created_at', 'desc')->paginate(15);

        return Inertia::render('Admin/Visits/Index', [
            'visits' => $visits,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Visits/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'office_id' => 'required|exists:offices,id',
            'visit_date' => 'required|date',
            'purpose' => 'required|string',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        Visit::create($validated);

        return redirect()->route('admin.visits.index')
            ->with('success', 'Visit created successfully.');
    }

    public function show(Visit $visit)
    {
        return Inertia::render('Admin/Visits/Show', [
            'visit' => $visit->load('user', 'office'),
        ]);
    }

    public function edit(Visit $visit)
    {
        return Inertia::render('Admin/Visits/Edit', [
            'visit' => $visit->load('user', 'office'),
        ]);
    }

    public function update(Request $request, Visit $visit)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'office_id' => 'required|exists:offices,id',
            'visit_date' => 'required|date',
            'purpose' => 'required|string',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        $visit->update($validated);

        return redirect()->route('admin.visits.index')
            ->with('success', 'Visit updated successfully.');
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();

        return redirect()->route('admin.visits.index')
            ->with('success', 'Visit deleted successfully.');
    }
}
