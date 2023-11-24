<?php

declare(strict_types=1);

namespace App\Repositories;

interface RepositoryInterface
{
    public function all();

    public function findById($id);

    public function update($id, $data);

    public function delete($id);
}
