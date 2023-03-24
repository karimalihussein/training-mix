<?php

namespace Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as BasePermission;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Baro\PipelineQueryCollection\ScopeFilter;
use Illuminate\Contracts\Database\Query\Builder;

class Permission extends BasePermission implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $with = ['translations'];

    public $guard_name = 'tenant';

    protected $hidden = ['pivot'];


}
