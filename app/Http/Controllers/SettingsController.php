<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $values = Valuestore::make(public_path('settings.json'));

        return view('settings.index', compact('values'));
    }

    public function update(Request $request)
    {
        $values = Valuestore::make(public_path('settings.json'));
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            $values->put($key, $value);
        }

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
