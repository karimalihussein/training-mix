<?php

namespace Modules\Booking\Tests;

use Carbon\Carbon;
use Modules\Booking\Models\Appointment;
use Modules\Booking\Models\Employee;
use Modules\Booking\Models\Schedule;
use Modules\Booking\Models\ScheduleExclusion;
use Modules\Booking\Models\Service;
use Modules\Booking\Support\ScheduleAvailability;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Tests\TestCase;

final class EmployeeTest extends TestCase
{

    public function test_an_employee_can_have_many_appointments(): void
    {
        $employee = Employee::factory()->create();
        Appointment::factory(3)->create([
            'employee_id' => $employee->id,
        ]);

        $this->assertEquals(3, $employee->appointments->count());
    }

    public function test_an_employee_can_have_many_services(): void
    {
        $employee = Employee::factory()->create();
        $services = Service::factory(3)->create();
        $employee->services()->attach($services->pluck('id'));

        $this->assertEquals(3, $employee->services->count());
    }
    public function test_list_correct_employee_availability(): void
    {
        Carbon::setTestNow(Carbon::parse('1st January 2000'));

        $employee = Employee::factory()
            ->has(Schedule::factory()->state([
                'starts_at' => now()->startOfDay(),
                'ends_at' => now()->addYear()->endOfDay(),
            ]))->create();
        $service = Service::factory()->create([
            'duration' => 30,
        ]);

        $availability = (new ScheduleAvailability($employee, $service))->forPeriod(
            now()->startOfDay(),
            now()->addMonth()->endOfDay()
        );

        $this->assertInstanceOf(PeriodCollection::class, $availability);
    }
}
