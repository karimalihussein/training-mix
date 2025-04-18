<?php

declare(strict_types=1);

namespace App\Solid\ISP\V1;

use App\Solid\ISP\V1\Interfaces\AppointmentInterface;
use App\Solid\ISP\V1\Interfaces\PrescribableInterface;

class Doctor implements AppointmentInterface, PrescribableInterface
{
    public function createAppointment($date, $time)
    {
        // Create appointment
    }

    public function updateAppointment($id, $date, $time)
    {
        // Update appointment
    }

    public function cancelAppointment($id)
    {
        // Cancel appointment
    }

    public function prescribeMedication($appointmentId, $medication)
    {
        // Prescribe medication
    }
}
