<?php

namespace App\Solid\ISP;

use App\Solid\ISP\interfaces\AppointmentInterface;
use App\Solid\ISP\interfaces\PrescribableInterface;

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