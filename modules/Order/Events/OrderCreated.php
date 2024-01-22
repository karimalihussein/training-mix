<?php

namespace Modules\Order\Events;

use Modules\Order\DTO\OrderDto;
use Modules\User\DTO\UserDto;

readonly final class OrderCreated
{
    public function __construct(
        public OrderDto $order,
        public UserDto $user,
    ) {
    }
}
