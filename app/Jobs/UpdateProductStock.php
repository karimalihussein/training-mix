<?php

namespace App\Jobs;

use Modules\Product\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Validation\ValidationException;

final class UpdateProductStock implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public readonly int $productId,
        public readonly int $quantity,
        public readonly string $operation = 'decrease' // 'decrease' or 'increase'
    ) {}

    public function handle(): void
    {
        DB::transaction(function () {
            // Step 1: Lock the row for update
            $product = Product::where('id', $this->productId)->lockForUpdate()->firstOrFail();

            $stockBefore = $product->stock;

            // Step 2: Simulate delay to test concurrency
            usleep(200_000); // 0.2 second

            // Step 3: Validate operation
            if ($this->operation === 'decrease') {
                if ($stockBefore < $this->quantity) {
                    logger()->warning("Insufficient stock for product {$product->id}: Requested {$this->quantity}, Available {$stockBefore}");
                    throw ValidationException::withMessages([
                        'stock' => "Insufficient stock. Available: {$stockBefore}, Requested: {$this->quantity}"
                    ]);
                }
                $newStock = $stockBefore - $this->quantity;
            } else {
                $newStock = $stockBefore + $this->quantity;
            }

            // Step 4: Update stock safely
            $product->stock = $newStock;
            $product->save();

            logger()->info("Stock {$this->operation}d by {$this->quantity} => Final stock: {$newStock}");
        });
    }
}
