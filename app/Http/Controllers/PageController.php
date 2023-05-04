<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function index()
    {
        // $articles = Cache::remember('articles', 60, function () {
        //     return \App\Article::latest()->get();
        // });
        $articles = Article::latest()->take(100)->get();

        return view('pages.index', compact('articles'));
    }
}
