<?php

namespace Modules\Product\DTO;

readonly final class CartItem
{
    public function __construct(
        public ProductDto $product,
        public int $quantity
    ) {
    }
}
