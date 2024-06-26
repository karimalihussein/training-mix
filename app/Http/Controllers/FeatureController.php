<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Feature;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = Feature::toBase()
            ->selectRaw("count(case when status = '".Feature::STATUS_APPROVED."' then 1 end) as approved")
            ->selectRaw("count(case when status = '".Feature::STATUS_REJECTED."' then 1 end) as rejected")
            ->selectRaw("count(case when status = '".Feature::STATUS_REQUESTED."' then 1 end) as requested")
            ->selectRaw("count(case when status = '".Feature::STATUS_DELETED."' then 1 end) as deleted")
            ->first();

        return $features;
    }
}
