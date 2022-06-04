<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Validators\PostValidator;
use App\QueryFilters\Active;
use App\QueryFilters\MaxCount;
use App\QueryFilters\Sort;
use App\Repositories\RepositoryInterface;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
   
    public function __construct(RepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->all();
        return $posts;
        // $posts = Post::query();
        // $posts = app(Pipeline::class)->send(Post::query())
        // ->through([
        //     Active::class,
        //     Sort::class,
        //     MaxCount::class
        // ])
        // ->thenReturn();

  
        // $posts = $posts->get();
        
        // return view('posts.index', compact('posts'));
    }


    public function store()
    {
        $attributes = (new PostValidator())->validate($post = new Post(),request()->all());
        $post = DB::transaction(function()use($post,$attributes){
            $post->fill(
                    Arr::except($attributes, ['tags'])
            )->save();
            if(isset($attributes['tags']))
            {
                $post->tags()->attach($attributes['tags']); 
            }
            return $post;
         });

         return PostResource::make(
            $post->load(['tags'])
        );
    }
}
