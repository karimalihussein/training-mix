<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\QueryFilters\Active;
use App\QueryFilters\MaxCount;
use App\QueryFilters\Sort;
use App\Repositories\RepositoryInterface;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Http\Request;

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
}
