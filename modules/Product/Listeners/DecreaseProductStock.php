<?php

namespace Modules\Product\Listeners;

use Modules\Order\Events\OrderCreated;
use Modules\Product\Warehouse\ProductStockManager;

final class DecreaseProductStock
{
    public function __construct(
        protected ProductStockManager $productStockManager
    ) {
    }
    public function handle(OrderCreated $event): void
    {
        foreach ($event->cartItems->items() as $cartItem) {
            $this->productStockManager->decremnt($cartItem->product->id, $cartItem->quantity);
        }
    }
}
