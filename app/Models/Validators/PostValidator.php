<?php


namespace App\Models\Validators;

use App\Models\Post;
use Illuminate\Validation\Rule;

class PostValidator
{
    public function validate(Post $post,array $attributes) : array
    {
       return validator($attributes,
        [
            'title'                =>     [Rule::when($post->exists, 'sometimes'),'required', 'string'],
            'content'              =>     [Rule::when($post->exists, 'sometimes'),'required', 'string'],
            'tags'                 =>     ['array'],
            'tags.*'               =>     ['integer', Rule::exists('tags', 'id')],
        ])->validate();
    }
}