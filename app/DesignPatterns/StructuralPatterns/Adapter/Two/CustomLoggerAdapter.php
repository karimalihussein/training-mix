<?php

namespace App\DesignPatterns\StructuralPatterns\Adapter\Two;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class CustomLoggerAdapter implements LoggerInterface
{
    protected $customLogger;

    public function __construct(CustomLogger $customLogger)
    {
        $this->customLogger = $customLogger;
    }

    public function emergency(string $message, array $context = []): void
    {
        $this->customLogger->writeLog('emergency', $message);
    }


    protected function mapLogLevel($level)
    {
        $map = [
            LogLevel::EMERGENCY => 'emergency',
            LogLevel::ALERT => 'alert',
            LogLevel::CRITICAL => 'critical',
            LogLevel::ERROR => 'error',
            LogLevel::WARNING => 'warning',
            LogLevel::NOTICE => 'notice',
            LogLevel::INFO => 'info',
            LogLevel::DEBUG => 'debug',
        ];

        return $map[$level] ?? 'info';
    }
}
