<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $collection = collect([
            'Invoice',
            'Client',
            'Contact',
            'Payment',
            'Team',
            'User',
            'Role',
            'Permission',
            'Driver',
            // ... your own models/permission you want to crate
        ]);

        $collection->each(function ($item, $key) {
            // create permissions for each collection item
            Permission::create(['group' => $item, 'name' => 'viewAny'.$item]);
            Permission::create(['group' => $item, 'name' => 'view'.$item]);
            Permission::create(['group' => $item, 'name' => 'update'.$item]);
            Permission::create(['group' => $item, 'name' => 'create'.$item]);
            Permission::create(['group' => $item, 'name' => 'delete'.$item]);
            Permission::create(['group' => $item, 'name' => 'destroy'.$item]);
        });

        // Create a Super-Admin Role and assign all permissions to it
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // Give User Super-Admin Role
        $user = User::whereEmail('admin@gmail.com')->first(); // enter your email here
        $user->assignRole('super-admin');
    }
}
