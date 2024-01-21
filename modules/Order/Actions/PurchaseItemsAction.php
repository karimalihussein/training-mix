<?php


namespace Modules\Order\Actions;

use Modules\Order\Exceptions\PaymentFailedException;
use Modules\Payment\Services\PayBuddy;
use Modules\Product\DTO\CartItemCollection;
use RuntimeException;
use Modules\Order\Models\Order;
use Modules\Product\Warehouse\ProductStockManager;

final class PurchaseItemsAction
{
    public function __construct(protected ProductStockManager $productStockManager)
    {
    }

    public function handle(CartItemCollection $items, PayBuddy $paymentProvider, string $paymentToken, int $userid): order
    {
        $orderTotalInCents = $items->totalInCents();

        try {
            $charge = $paymentProvider->charge($paymentToken, $orderTotalInCents, 'Laravel Shop');
        } catch (RuntimeException) {
            throw PaymentFailedException::dueToInvalidToken();
        }
        $order = Order::query()->create([
            'payment_id'      => $charge['id'],
            'status'          => 'completed',
            'total_in_cents'  => $orderTotalInCents,
            'payment_gateway' => 'paybuddy',
            'user_id'         => $userid,
        ]);

        foreach ($items->items() as $cartItem) {
            $this->productStockManager->decremnt($cartItem->product->id, $cartItem->quantity);

            $order->lines()->create([
                'product_id'     => $cartItem->product->id,
                'quantity'       => $cartItem->quantity,
                'price_in_cents' => $cartItem->product->priceInCents,
            ]);
        }

        $order->payments()->create([
            'total_in_cents' => $orderTotalInCents,
            'status'         => 'paid',
            'payment_id'     => $charge['id'],
            'payment_gateway' => 'paybuddy',
            'user_id'         => $userid,
        ]);

        return $order;
    }
}