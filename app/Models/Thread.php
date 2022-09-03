<?php

namespace App\Models;

use App\Notifications\ThreadCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($thread) {
            var_dump('creating');
            $thread->user->notify(new ThreadCreated($thread));
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'body',
    ];

    /**
     * Get the user that owns the thread.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the thread.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the replies for the thread.
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    
}
