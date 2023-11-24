<?php

declare(strict_types=1);

namespace App\Models;

use App\Visitable\Visitable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    use Visitable;

    protected $fillable = [
        'title',
        'slug',
    ];
}
