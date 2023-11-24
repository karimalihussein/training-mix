<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Post;

class PostRepository implements RepositoryInterface
{
    public function all()
    {
        return Post::all();
    }

    public function findById($id)
    {
        return Post::find($id);

    }

    public function update($id, $data)
    {
        $post = Post::find($id);
        $post->update($data);

        return $post;
    }

    public function delete($id)
    {
        Post::find($id)->delete();
    }
}
