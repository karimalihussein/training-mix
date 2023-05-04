<?php

namespace App\Calculators;

use App\Interfaces\SalaryCalculatorInterface;

class ManagerSalaryCalculator implements SalaryCalculatorInterface
{
    public function calculate(string $start_date, float $bouns = 0): float
    {
        return 100000 + now()->diffInYears($start_date) * 10000;
    }

    private function format(float $salary): string
    {
        return number_format($salary, 2, '.', ',');
    }
}
