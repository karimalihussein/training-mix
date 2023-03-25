<?php

namespace Database\Seeders;

use App\Models\Office;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
   
        // create user
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // create roles
        $roles = [
            'admin',
            'manager',
            'employee',
        ];

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create(['name' => $role]);
        }

        // create permissions
        $permissions = 
        [
            'create office',
            'read office',
            'update office',
            'delete office',
            'create employee',
            'read employee',
            'update employee',
            'delete employee',
            'create article',
            'read article',
            'update article',
            'delete article',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        // assign roles to user
        $user->assignRole('admin');

        User::factory()->times(5)->hasPosts(2000)->create();

    }
}
