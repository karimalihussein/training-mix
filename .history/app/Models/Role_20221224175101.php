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

    protected $with = ['translations'];

    public $guard_name = 'tenant';

    protected $hidden = ['pivot'];

    /**
     * The attributes that should be translated.
     * @var array<int, string>
     */
    public $translatedAttributes = [
        'display_name'
    ];

    /**
     * scope for getting all projects with search
     * @param  Builder $query
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $keyword)
    {
        return $query->whereHas(
            'translations',
            fn (Builder $query) => $query->where('display_name', 'like', "%$keyword%")
        );
    
    }

    public function getFilters(): array
    {
        return [
            new ScopeFilter('search'),
        ];
    }

    protected static function newFactory()
    {
        return \Modules\Permission\Database\factories\RoleFactory::new();
    }
}
