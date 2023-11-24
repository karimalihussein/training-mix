<?php

declare(strict_types=1);

namespace App\Calculators;

use App\Interfaces\SalaryCalculatorInterface;

class DeveloperSalaryCalculator implements SalaryCalculatorInterface
{
    public function calculate(string $start_date): float
    {
        return 40000 + now()->diffInYears($start_date) * 4000;
    }
}
