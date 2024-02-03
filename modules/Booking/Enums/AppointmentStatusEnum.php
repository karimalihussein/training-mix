<?php


namespace Modules\Booking\Enums;

enum AppointmentStatusEnum: int
{
    case PENDING = 0;
    case CONFIRMED = 1;
    case CANCELLED = 2;
    case COMPLETED = 3;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::CANCELLED => 'Cancelled',
            self::COMPLETED => 'Completed',
        };
    }
}