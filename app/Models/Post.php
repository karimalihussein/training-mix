<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    const ACTIVE_STATUS = 1;

    const INACTIVE_STATUS = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'active',
        'user_id',
    ];

    // /**
    //  * Image relationship
    //  * 
    //  * @return \Illuminate\Database\Eloquent\Relations\MorphOne
    //  */
    // public function image()
    // {
    //     return $this->morphOne(Image::class, 'imageable');
    // }

    // /**
    //  * Comment relationship
    //  * 
    //  * @return \Illuminate\Database\Eloquent\Relations\MorphMany
    //  */
    // public function comments()
    // {
    //     return $this->morphMany(Comment::class, 'commentable');
    // }

    // /**
    //  * Tag relationship
    //  * 
    //  * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
    //  */
    // public function tags()
    // {
    //     return $this->morphToMany(Tag::class, 'taggable');
    // }

    /**
     * User relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

  
  


  
}
