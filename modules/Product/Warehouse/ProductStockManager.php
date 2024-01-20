<?php

namespace Modules\Product\Warehouse;

use Modules\Product\Models\Product;
use Illuminate\Validation\ValidationException;

readonly final class ProductStockManager
{
    public function decremnt(int $productId, int $quantity): void
    {
        $product = Product::query()->findOrFail($productId);

        if ($product->stock < $quantity) {
            throw ValidationException::withMessages([
                'products' => 'We do not have enough stock to fulfill your order.',
            ]);
        }

        $product->decrement('stock', $quantity);
    }
}
