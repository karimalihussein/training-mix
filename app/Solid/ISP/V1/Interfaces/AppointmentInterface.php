<?php

namespace App\Solid\ISP\V1\Interfaces;

interface AppointmentInterface {
    public function createAppointment($date, $time);
    public function updateAppointment($id, $date, $time);
    public function cancelAppointment($id);
}