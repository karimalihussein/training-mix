<?php

namespace Modules\Product\DTO;

use Illuminate\Support\Collection;
use Modules\Product\Models\Product;

readonly final class CartItemCollection
{
    /**
     * @param Collection<CartItem> $items
     */
    public function __construct(protected Collection $items)
    {
    }

    /**
     * @param array<array{id: int, quantity: int}> $items
     */
    public static function fromArray(array $items): self
    {
        return new self(collect($items)->map(function ($item) {
            return new CartItem(
                product: ProductDto::fromElquentModel(Product::query()->findOrFail($item['id'])),
                quantity: $item['quantity'],
            );
        }));
    }

    public function totalInCents(): int
    {
        return $this->items->sum(function (CartItem $cartItem) {
            return $cartItem->quantity * $cartItem->product->priceInCents;
        });
    }
    /**
     * @return Collection<CartItem>
     */
    public function items(): Collection
    {
        return $this->items;
    }
}