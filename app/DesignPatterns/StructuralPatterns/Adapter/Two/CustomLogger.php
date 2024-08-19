<?php

namespace App\DesignPatterns\StructuralPatterns\Adapter\Two;
class CustomLogger
{
    public function writeLog($severity, $text)
    {
        // Custom logic to write logs
        echo "Custom Logger: [$severity] $text";
    }
}
