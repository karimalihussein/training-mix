<?php

namespace Modules\Booking\Tests;

use Carbon\Carbon;
use Modules\Booking\Models\Appointment;
use Modules\Booking\Models\Employee;
use Modules\Booking\Models\Schedule;
use Modules\Booking\Models\ScheduleExclusion;
use Modules\Booking\Models\Service;
use Modules\Booking\Support\ScheduleAvailability;
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
    public function testListCorrectEmployeeAvailability(): void
    {
        Carbon::setTestNow(Carbon::parse('1st January 2000'));

        $employee = Employee::factory()
            ->has(Schedule::factory()->state([
                'starts_at' => now()->startOfDay(),
                'ends_at' => now()->addYear()->endOfDay(),
            ]))->create();

        $service = Service::factory()->create(['duration' => 30]);

        $dayName = strtolower(now()->format('l'));
        $actualStartTime = $employee->schedules->first()->{$dayName . '_starts_at'};

        $availability = (new ScheduleAvailability($employee, $service))->forPeriod(
            now()->startOfDay(),
            now()->addMonth()->endOfDay()
        );

        $this->assertInstanceOf(PeriodCollection::class, $availability);

        $availabilityPeriod = $availability->current();

        $expectedStartTime = now()->setTimeFromTimeString($actualStartTime);

        $this->assertTrue($availabilityPeriod->startsAt($expectedStartTime));
    }


    public function test_accounts_for_different_daily_schedule(): void
    {
        Carbon::setTestNow(Carbon::parse('monday January 2000'));

        $employee = Employee::factory()
            ->has(Schedule::factory()->state([
                'starts_at' => now()->startOfDay(),
                'ends_at' => now()->addYear()->endOfDay(),
                'monday_starts_at' => '11:00',
                'monday_ends_at' => '16:00',
                'tuesday_starts_at' => '09:00',
                'tuesday_ends_at' => '17:00',
            ]))->create();

        $service = Service::factory()->create(['duration' => 30]);

        $availability = (new ScheduleAvailability($employee, $service))->forPeriod(
            now()->startOfDay(),
            now()->addDay()->endOfDay()
        );

        $this->assertInstanceOf(PeriodCollection::class, $availability);

        $availabilityPeriod = $availability->current();

        $this->assertTrue($availabilityPeriod->startsAt(now()->setTimeFromTimeString('11:00')));
        $this->assertTrue($availabilityPeriod->endsAt(now()->setTimeFromTimeString('15:30')));

        $availability->next();

        $availabilityPeriod = $availability->current();

        $this->assertTrue($availabilityPeriod->startsAt(now()->addDay()->setTimeFromTimeString('09:00')));
        $this->assertTrue($availabilityPeriod->endsAt(now()->addDay()->setTimeFromTimeString('16:30')));
    }


    public function test_does_not_show_availability_for_schedule_exclusions(): void
    {
        Carbon::setTestNow(Carbon::parse('1st January 2000'));

        $employee = Employee::factory()
            ->has(Schedule::factory()->state([
                'starts_at' => now()->startOfDay(),
                'ends_at' => now()->addYear()->endOfDay(),
            ]))->has(ScheduleExclusion::factory()->state([
                'starts_at' => now()->addDay()->startOfDay(),
                'ends_at' => now()->addDay()->endOfDay(),
            ]))->has(ScheduleExclusion::factory()->state([
                'starts_at' => now()->setTimeFromTimeString('12:00'),
                'ends_at' => now()->setTimeFromTimeString('13:00'),
            ]))->create();



        $service = Service::factory()->create(['duration' => 30]);

        $availability = (new ScheduleAvailability($employee, $service))->forPeriod(
            now()->startOfDay(),
            now()->addDay()->endOfDay()
        );

        $this->assertInstanceOf(PeriodCollection::class, $availability);

        $availabilityPeriod = $availability->current();
        $dayName = strtolower(now()->format('l'));
        $actualStartTime = $employee->schedules->first()->{$dayName . '_starts_at'};
        $this->assertTrue($availabilityPeriod->startsAt(now()->setTimeFromTimeString($actualStartTime)));
        $this->assertTrue($availabilityPeriod->endsAt(now()->setTimeFromTimeString('11:59')));

        $availability->next();

        $availabilityPeriod = $availability->current();

        $this->assertTrue($availabilityPeriod->startsAt(now()->setTimeFromTimeString('13:00')));
    }

    public function test_only_show_availability_from_the_current_time_with_an_hour_in_advanced(): void
    {
        Carbon::setTestNow(Carbon::parse('1st January 2000 09:15'));

        $employee = Employee::factory()
            ->has(Schedule::factory()->state([
                'starts_at' => now()->startOfDay(),
                'ends_at' => now()->addYear()->endOfDay(),
            ]))->create();

        $service = Service::factory()->create(['duration' => 30]);

        $availability = (new ScheduleAvailability($employee, $service))->forPeriod(
            now()->startOfDay(),
            now()->endOfDay()
        );

        $this->assertInstanceOf(PeriodCollection::class, $availability);
        $availabilityPeriod = $availability->current();
        $dayName = strtolower(now()->format('l'));
        $actualStartTime = $employee->schedules->first()->{$dayName . '_starts_at'};
        $this->assertTrue($availabilityPeriod->startsAt(now()->setTimeFromTimeString($actualStartTime)));
    }
}