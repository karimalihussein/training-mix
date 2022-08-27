<?php

namespace App\Visitable;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;

class PendingVisit
{
    protected $attributes = [];
    protected $inteval;
    public function __construct(protected Model $model)
    {
        $this->inteval = now()->subDay(1);
    }

    public function withIp($ip = null)
    {
        $this->attributes['ip'] = $ip ?? request()->ip();
        return $this;
    }

    public function withUserAgent($userAgent = null)
    {
        $this->attributes['user_agent'] = $userAgent ?? request()->header('User-Agent');
        return $this;
    }

    public function withData(array $data)
    {
        $this->attributes['data'] = $data;
        return $this;
    }

    public function withUser(?User $user = NULL)
    {
        $this->attributes['data'] = $user?->id ?? auth()->id();
        return $this;
    }

    public function buildJsonColumns()
    {
        return collect($this->attributes)->mapWithKeys(function ($value, $index) {
            return ['data->' . $index => $value];
        })->toArray();
    }

    protected function shuldBeLoggedAgain(Visit $visit)
    {
        return !$visit->wasRecentlyCreated && $visit->created_at->lessThan($this->inteval);
    }

    public function __destruct()
    {
       $visit =  $this->model->visits()->latest()->firstOrCreate(
            $this->buildJsonColumns()
        ,[
            'data'       => $this->attributes,
        ]);
        
        $visit->when($this->shuldBeLoggedAgain($visit), function () use ($visit) {
            $visit->replicate()->save();
        });

        
    }
}
