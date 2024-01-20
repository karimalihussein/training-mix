<?php

namespace Modules\Product\DTO;

use Modules\Product\Models\Product;

readonly final class ProductDto
{
    public function __construct(
        public int $id,
        public int $priceInCents,
        public int $stock,
    ) {
    }

    public static function fromElquentModel(Product $product): self
    {
        return new self(
            id: $product->id,
            priceInCents: $product->price_in_cents,
            stock: $product->stock,
        );
    }
}
