<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Repositories\RepositoryInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(RepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = $this->customerRepository->all();

        return $customers;
    }

    /**
     * show customer details
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = $this->customerRepository->findById($id);

        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        return $this->customerRepository->update($id, $request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->customerRepository->delete($id);
    }
}
