<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Concert;

class ConcertsController extends Controller
{
    public function show($id)
    {
        $concert = Concert::whereNotNull('published_at')->findOrFail($id);

        return view('concerts.show', compact('concert'));

    }
}
