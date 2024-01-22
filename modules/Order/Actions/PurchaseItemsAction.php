<?php


namespace Modules\Order\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Modules\Order\DTO\OrderDto;
use Modules\Order\DTO\PendingPayment;
use Modules\Order\Events\OrderCreated;
use Modules\Product\DTO\CartItemCollection;
use Modules\Order\Models\Order;
use Modules\Product\Warehouse\ProductStockManager;
use Modules\User\DTO\UserDto;

final class PurchaseItemsAction
{
    public function __construct(
        protected ProductStockManager $productStockManager,
        protected CreatePaymentForOrderAction $createPaymentForOrderAction,
        protected DatabaseManager $databaseManager,
        protected Dispatcher $dispatcher
    ) {
    }

    public function handle(CartItemCollection $items, PendingPayment $pendingPayment, UserDto $user): OrderDto
    {
        /** @var OrderDto $order */
        $order =  $this->databaseManager->transaction(function () use ($items, $pendingPayment, $user) {
            $order = Order::startForUser($user->id);
            $order->addLinesToOrder($items);
            $order->fullfill();


            $this->createPaymentForOrderAction->handle(
                $order->id,
                $user->id,
                $items->totalInCents(),
                $pendingPayment->provider,
                $pendingPayment->paymentToken
            );

            return OrderDto::fromEloquentModel($order);
        });

        $this->dispatcher->dispatch(new OrderCreated(
            order: $order,
            user: $user
        ));

        return $order;
    }
}
