<?php

namespace Modules\Order\DTO;

use Modules\Order\Models\Order;

readonly final class OrderDto
{
    /**
     * @param int $id
     * @param int $totalInCents
     * @param string $localizedTotal
     * @param OrderLineDto[] $lines
     * @param string $url
     */
    public function __construct(
        public int $id,
        public int $totalInCents,
        public string $localizedTotal,
        public array $lines,
        public string $url = '',
    ) {
    }

    public static function fromEloquentModel(Order $order): self
    {
        return new self(
            id: $order->id,
            totalInCents: $order->total_in_cents,
            localizedTotal: $order->localizedTotal(),
            lines: OrderLineDto::fromEloquentCollection($order->lines),
            url: $order->url(),
        );
    }
}
