<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use App\Enums\PostActiveEnum;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class ActivePostScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('active', PostActiveEnum::ACTIVE->value);
    }
}