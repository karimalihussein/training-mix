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
        foreach ($event->order->lines as $line) {
            $this->productStockManager->decremnt($line->productId, $line->quantity);
        }
    }
}
