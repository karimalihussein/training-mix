<?php

namespace App\Ordering;

use Illuminate\Database\Eloquent\Model;

class Orderer
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function firstOrder()
    {
        return $this->model->query()->orderBy('order', 'asc')->first() + 1;
    }

    public function lastOrder()
    {
        return $this->model->query()->orderBy('order', 'desc')->first() + 1;
    }

    public function afterOrder()
    {
        $adjecent = $this->model->query()->where('order', '>', $this->model->order)
            ->orderBy('order', 'asc')
            ->first();

        if (! $adjecent) {
            return $this->model->query()->max('order') + 1;
        }

        return ($this->model->order + $adjecent->order) / 2;
    }

    public function before()
    {
        $adjecent = $this->model->query()->where('order', '<', $this->model->order)
            ->orderBy('order', 'desc')
            ->first();

        if (! $adjecent) {
            return $this->model->query()->min('order') - 1;
        }

        return ($this->model->order + $adjecent->order) / 2;
    }
}
