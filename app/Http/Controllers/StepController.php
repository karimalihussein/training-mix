<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function index()
    {

        $steps = Step::orderBy('order', 'asc')->get();
        foreach ($steps as $step) {
            $step->visits()->create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'data' => [
                    'referer' => request()->headers->get('referer'),
                    'user_id' => auth()->id(),
                    'user_name' => auth()->user()->name,
                ],
            ]);
        }

        return $steps;
    }

    public function store(Request $request)
    {
        $order = Step::find(42)->ordering()->before();
        $step = Step::create([
            'title' => 'ahmed',
            'order' => $order,
        ]);

        return $step;
    }

    public function refresh()
    {
        $steps = Step::orderBy('order', 'asc')->get()->each(function ($step, $index) {
            $step->update([
                'order' => $index + 1,
            ]);
        });
    }
}
