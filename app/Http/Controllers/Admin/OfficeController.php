<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::orderBy('created_at', 'desc')->paginate(15);

        return Inertia::render('Admin/Offices/Index', [
            'offices' => $offices,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Offices/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        Office::create($validated);

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office created successfully.');
    }

    public function show(Office $office)
    {
        return Inertia::render('Admin/Offices/Show', [
            'office' => $office,
        ]);
    }

    public function edit(Office $office)
    {
        return Inertia::render('Admin/Offices/Edit', [
            'office' => $office,
        ]);
    }

    public function update(Request $request, Office $office)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $office->update($validated);

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office updated successfully.');
    }

    public function destroy(Office $office)
    {
        $office->delete();

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office deleted successfully.');
    }
}
