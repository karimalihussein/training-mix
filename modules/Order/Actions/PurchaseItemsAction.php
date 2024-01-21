<?php


namespace Modules\Order\Actions;

use Illuminate\Database\DatabaseManager;
use Modules\Payment\Services\PayBuddy;
use Modules\Product\DTO\CartItemCollection;
use Modules\Order\Models\Order;
use Modules\Product\Warehouse\ProductStockManager;

final class PurchaseItemsAction
{
    public function __construct(
        protected ProductStockManager $productStockManager,
        protected CreatePaymentForOrderAction $createPaymentForOrderAction,
        protected DatabaseManager $databaseManager
    ) {
    }

    public function handle(CartItemCollection $items, PayBuddy $paymentProvider, string $paymentToken, int $userid): order
    {
        $orderTotalInCents = $items->totalInCents();
        return $this->databaseManager->transaction(function () use ($items, $orderTotalInCents, $userid, $paymentProvider, $paymentToken) {
            $order =  Order::query()->create([
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

            $this->createPaymentForOrderAction->handle(
                $order->id,
                $userid,
                $orderTotalInCents,
                $paymentProvider,
                $paymentToken
            );
            return $order;
        });
    }
}