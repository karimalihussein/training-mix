<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Folder extends Model implements HasMedia
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'root_id',
        'name',
        'color',
        'icon',
        'type',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Folder::class);
    }

    public function root()
    {
        return $this->belongsTo(Folder::class);
    }

    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($folder) {
            $folder->uuid = (string) \Str::uuid();
        });
    }

}
