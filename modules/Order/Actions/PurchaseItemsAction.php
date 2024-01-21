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

    public function handle(CartItemCollection $items, PayBuddy $paymentProvider, string $paymentToken, int $userId): order
    {
        return $this->databaseManager->transaction(function () use ($items, $userId, $paymentProvider, $paymentToken) {
            $order = Order::startForUser($userId);
            $order->addLinesToOrder($items);
            $order->fullfill();
            foreach ($items->items() as $cartItem) {
                $this->productStockManager->decremnt($cartItem->product->id, $cartItem->quantity);
            }

            $this->createPaymentForOrderAction->handle(
                $order->id,
                $userId,
                $items->totalInCents(),
                $paymentProvider,
                $paymentToken
            );
            return $order;
        });
    }
}