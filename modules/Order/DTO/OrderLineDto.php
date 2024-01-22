<?php

namespace Modules\Order\DTO;

use Modules\Order\Models\OrderLine;

readonly final class OrderLineDto
{
    /**
     * @param int $productId
     * @param int $productPriceInCents
     * @param int $quantity
     */
    public function __construct(
        public int $productId,
        public int $productPriceInCents,
        public int $quantity,
    ) {
    }

    public static function fromEloquentModel(OrderLine $orderLine): self
    {
        return new self(
            productId: $orderLine->product_id,
            productPriceInCents: $orderLine->price_in_cents,
            quantity: $orderLine->quantity,
        );
    }

    public static function fromEloquentCollection(iterable $orderLines): array
    {
        return array_map(
            fn (OrderLine $orderLine) => self::fromEloquentModel($orderLine),
            iterator_to_array($orderLines)
        );
    }
}
