<?php

namespace App\Solid\ISP;

use App\Solid\ISP\interfaces\AppointmentInterface;
use App\Solid\ISP\interfaces\StylableInterface;

class HairStylist implements AppointmentInterface, StylableInterface
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

    public function styleHair($appointmentId, $style)
    {
        // Style hair
    }

}
