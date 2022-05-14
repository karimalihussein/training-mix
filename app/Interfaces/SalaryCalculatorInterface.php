<?php

namespace App\Interfaces;

interface SalaryCalculatorInterface {

    public function calculate(string $start_date): float;

}