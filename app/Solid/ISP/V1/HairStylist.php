<?php

namespace App\Solid\ISP\V1;

use App\Solid\ISP\V1\Interfaces\AppointmentInterface;
use App\Solid\ISP\V1\Interfaces\StylableInterface;

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
