<?php

namespace Modules\Permission\Entities;

use Spatie\Permission\Models\Role as RoleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;
use Baro\PipelineQueryCollection\ScopeFilter;
use Illuminate\Contracts\Database\Query\Builder;

class Role extends RoleModel implements TranslatableContract, CanFilterContract
{
    use HasFactory, Translatable, Filterable;


    public $guard_name = 'web';

    protected $hidden = ['pivot'];


}
