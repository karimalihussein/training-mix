<?php

namespace Modules\Payment\Enums;

enum PaymentProvider: string
{
    case PayBuddy = 'pay_buddy';
    case InMemory = 'in_memory';
}