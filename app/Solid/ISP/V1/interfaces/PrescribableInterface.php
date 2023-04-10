<?php

namespace App\Solid\ISP\interfaces;

interface PrescribableInterface {
    public function prescribeMedication($appointmentId, $medication);
}
