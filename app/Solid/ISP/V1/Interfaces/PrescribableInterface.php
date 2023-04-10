<?php

namespace App\Solid\ISP\V1\Interfaces;

interface PrescribableInterface {
    public function prescribeMedication($appointmentId, $medication);
}
