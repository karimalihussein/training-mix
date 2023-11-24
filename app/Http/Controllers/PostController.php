<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Validators\PostValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::select('id', 'title', 'user_id', 'content', 'active', 'created_at')
            ->with('user:id,name')
            ->when(request()->has('user_id'), function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })
            ->paginate(500);

        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $attributes = (new PostValidator())->validate($post = new Post(), $request->all());
        $post = DB::transaction(function () use ($post, $attributes) {
            $post->fill(
                Arr::except($attributes, ['tags'])
            )->save();
            if (isset($attributes['tags'])) {
                $post->tags()->attach($attributes['tags']);
            }

            return $post;
        });

        return PostResource::make(
            $post->load(['tags'])
        );
    }
}
