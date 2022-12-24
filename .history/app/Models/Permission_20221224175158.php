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
            fn($query) => $query->where('name', 'like', "%$keyword%")
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
        return \Modules\Permission\Database\factories\PermissionFactory::new();
    }
}
