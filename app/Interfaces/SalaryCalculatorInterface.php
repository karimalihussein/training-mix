<?php

declare(strict_types=1);

namespace App\Interfaces;

interface SalaryCalculatorInterface
{
    public function calculate(string $start_date): float;
}
