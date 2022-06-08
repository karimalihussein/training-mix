<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
class UsersController extends Controller
{
      /**
      * @var UserRepository
      */
      protected $repository;

      public function __construct(UserRepository $repository)
      {
        $this->repository = $repository;
      }


      public function index()
      {
   
        // $users = $this->repository->all(['id', 'name', 'start_date', 'employee_type']);
        $users = $this->repository
        ->search('merritt.howe@example.com')
        ->all();
        return $users;
      }

      public function show(int $id)
      {
        $user = $this->repository->findOrFail($id);
        return $user;
      }

      public function store(Request $request)
      {
        $user = $this->repository->create($request->all());
        return $user;
      }

      public function update(Request $request, int $id)
      {
        $user = $this->repository->findOrFail($id);
        $user = $this->repository->update($user, $request->all());
        return $user;
      }

      public function destroy(int $id)
      {
        $user = $this->repository->findOrFail($id);
        $user = $this->repository->delete($user);
        return $user;
      }

      public function getUserByEmail(string $email)
      {
        $user = $this->repository->findByField('email', $email);
        return $user;
      }

      

   
}
