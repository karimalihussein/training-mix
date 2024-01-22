<?php

namespace Modules\Order\Events;

use Modules\Product\DTO\CartItemCollection;

readonly final class OrderCreated
{
    public function __construct(
        public int $orderId,
        public int $totalInCents,
        public string $localizedTotal,
        public CartItemCollection $cartItems,
        public int $userId,
        public string $userEmail,
    ) {
    }
}
