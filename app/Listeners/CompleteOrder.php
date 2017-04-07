<?php

namespace App\Listeners;

use App\Contracts\Repository\ItemRepositoryInterface;
use App\Contracts\Repository\OrderRepositoryInterface;
use App\Events\ItemWasUpdated;
use App\Events\OrderWasCompleted;
use App\Models\Item;
use App\Models\Order;

class CompleteOrder
{

    /**
     *
     * @var OrderRepositoryInterface
     */
    protected $repository;

    /**
     *
     * @var ItemRepositoryInterface
     */
    protected $itemRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(OrderRepositoryInterface $repository,
                                ItemRepositoryInterface $itemRepository)
    {
        $this->repository = $repository;

        $this->itemRepository = $itemRepository;
    }

    /**
     * Handle the event.
     *
     * @param  ItemWasUpdated  $event
     * @return void
     */
    public function handle(ItemWasUpdated $event)
    {
        $item = null;

        if ($event->item instanceof Item) {
            $item = $event->item;
        }

        //does this item belongs to any order?
        if (empty($item->order_id)) { //not belongs to any, don't proceed
            return;
        }

        $nItemsUndelivered = $this->repository->countAssignedItemsUndeliveredByOrderId($item->order_id);


        if (!$nItemsUndelivered) { //check if undelivered items is 0
            $order = $this->repository->findById($item->order_id);
            if ($order && $order->items->count() > 0) { //check if yes has 0
                $order->status = Order::STATUS_COMPLETED;
                $order->save();
                
                event(new OrderWasCompleted($order));
            }
            else { //not necessary
//                //it's possible that all item has been removed
//                $order->status = \App\Models\Order::STATUS_CANCELED;
//                event(new \App\Events\OrderWasCanceled());
            }
        }
    }

}
