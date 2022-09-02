<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $years = Article::query()
            ->select('id', 'title', 'slug', 'published_at', 'user_id')
            ->with('user:id,name')
            ->latest('published_at')
            ->get()
            ->groupBy(fn ($article) => $article->published_at->year);

            return view('articles.index', compact('years'));
    }
}
