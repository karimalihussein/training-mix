<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Booking\Database\Seeders\BookingSeeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $this->call([
            RolesAndPermissionsSeeder::class,
            BookingSeeder::class
        ]);
        User::factory()->times(5)->create();
    }
}
