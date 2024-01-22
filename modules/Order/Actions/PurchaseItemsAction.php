<?php


namespace Modules\Order\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Modules\Order\Events\OrderCreated;
use Modules\Payment\Services\PayBuddy;
use Modules\Product\DTO\CartItemCollection;
use Modules\Order\Models\Order;
use Modules\Product\Warehouse\ProductStockManager;

final class PurchaseItemsAction
{
    public function __construct(
        protected ProductStockManager $productStockManager,
        protected CreatePaymentForOrderAction $createPaymentForOrderAction,
        protected DatabaseManager $databaseManager,
        protected Dispatcher $dispatcher
    ) {
    }

    public function handle(CartItemCollection $items, PayBuddy $paymentProvider, string $paymentToken, int $userId, string $userEmail): order
    {
        return $this->databaseManager->transaction(function () use ($items, $userId, $paymentProvider, $paymentToken, $userEmail) {
            $order = Order::startForUser($userId);
            $order->addLinesToOrder($items);
            $order->fullfill();


            $this->createPaymentForOrderAction->handle(
                $order->id,
                $userId,
                $items->totalInCents(),
                $paymentProvider,
                $paymentToken
            );


            $this->dispatcher->dispatch(new OrderCreated(
                userId: $userId,
                orderId: $order->id,
                userEmail: $userEmail,
                localizedTotal: $order->localizedTotal(),
                cartItems: $items,
                totalInCents: $order->total_in_cents
            ));

            return $order;
        });
    }
}
