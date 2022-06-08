<?php

namespace App\Repositories;

use Torann\LaravelRepository\Repositories\AbstractRepository;
use App\Models\User;

class UserRepository extends AbstractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    protected $model = User::class;
    

    protected $searchable = [
        'query' => [
            'name',
            'email',
        ],
    ];
}
