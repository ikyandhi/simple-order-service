<?php

namespace App\Listeners;

use App\Contracts\Repository\OrderRepositoryInterface;
use App\Events\ItemWasRemoved;

class CancelOrder
{

    /**
     *
     * @var OrderRepositoryInterface
     */
    protected $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  ItemWasRemoved  $event
     * @return void
     */
    public function handle(ItemWasRemoved $event)
    {
        $order = $this->repository->findById($event->item->order_id);

        if ($order && ($order->status !== \App\Models\Order::STATUS_COMPLETED)) {

            if ($order->items()->count() <= 0) { //none of items are attached, confirmed canceled
                $order->status = \App\Models\Order::STATUS_CANCELED;
                $order->save();
            }
        }
    }

}
