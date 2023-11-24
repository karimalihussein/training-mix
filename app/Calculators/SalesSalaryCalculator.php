<?php

declare(strict_types=1);

namespace App\Calculators;

use App\Interfaces\SalaryCalculatorInterface;

class SalesSalaryCalculator implements SalaryCalculatorInterface
{
    public function calculate(string $start_date): float
    {
        return 30000 + now()->diffInYears($start_date) * 3000;
    }
}
