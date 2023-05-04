<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository implements RepositoryInterface
{
    public function all()
    {
        return Customer::orderBy('name')
            ->where('active', 1)
            ->with('user')
            ->get()
            ->map->format();
    }

    public function findById($id)
    {
        return Customer::where('id', $id)
            ->where('active', 1)
            ->with('user')
            ->firstOrFail()
            ->format();

    }

    public function update($id, $data)
    {
        $customer = Customer::find($id);
        $customer->update($data);

        return $customer->format();
    }

    public function delete($id)
    {
        $customer = Customer::find($id)->delete();
    }
}
