<?php

declare(strict_types=1);

namespace Modules\Booking\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Booking\Models\Customer;
use Modules\Booking\Models\Employee;
use Modules\Booking\Models\Service;

final class BookingSeeder extends Seeder
{
    public function run()
    {
        $employee = Employee::factory()->create([
            'name' => 'John Doe',
            'profile_picture_url' => 'https://via.placeholder.com/150',
        ]);

        Customer::factory()->create([
            'name' => 'Mary Jane',
        ]);

        $services = [
            [
                'name' => 'Haircut',
                'duration' => 30,
            ],
            [
                'name' => 'Beard Trim',
                'duration' => 15,
            ],
            [
                'name' => 'Shave',
                'duration' => 20,
            ],
            [
                'name' => 'Haircut & Beard Trim',
                'duration' => 45,
            ],
            [
                'name' => 'Haircut & Shave',
                'duration' => 50,
            ],
        ];

        Service::factory()->createMany($services);

        $employee->services()->attach(Service::all()->pluck('id'));
    }
}
