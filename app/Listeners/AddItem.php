<?php

namespace App\Listeners;

use App\Contracts\Repository\ItemRepositoryInterface;
use App\Events\OrderWasCreated;

class AddItem
{

    /**
     *
     * @var ItemRepositoryInterface 
     */
    protected $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  OrderWasCreated  $event
     * @return void
     */
    public function handle(OrderWasCreated $event)
    {
        //Assign Available Items
        
        $nRemainingPendingAssignedOrderItem = $this->getRemainingPendingAssignedOrderItem($event->order->id, $event->items->sum('quantity'));

        if ($nRemainingPendingAssignedOrderItem > 0) {

            foreach ($event->items as $item) {
                
                $nRemainingPendingAssignedByOrderAndProduct = $this->getRemainingPenginAssignedOrderItemByOrderIdAndProductId(
                        $event->order->id, $item['product_id'], $item['quantity']);

                if ($nRemainingPendingAssignedByOrderAndProduct > 0) {
                    $this->createNewItem($event->order->id, $item['product_id'], $nRemainingPendingAssignedByOrderAndProduct);
                }
            }
        }
    }

    /**
     * To check if item(s) has been assigned to order, and get the remaining number
     * 
     * @param \App\Models\Order $order
     * @param integer $nOrderedQty
     * @return boolean
     */
    protected function getRemainingPendingAssignedOrderItem($orderId,
                                                            $nOrderedQty)
    {
        $assignedOrderItems = $this->repository->findAllAssignedItemByOrderId($orderId);

        return ($nOrderedQty - $assignedOrderItems->count());
    }

    /**
     * To get remaining N items that haven't yet assigned to order based on SKU and QTY requested.
     * 
     * @param integer $orderId
     * @param integer $productId
     * @param integer $nOrderedQty
     * @return integer
     */
    protected function getRemainingPenginAssignedOrderItemByOrderIdAndProductId($orderId,
                                                                                $productId,
                                                                                $nOrderedQty)
    {
        $assignedOrderItems = $this->repository->findAllItemAssignedByOrderIdAndProductId($orderId, $productId);

        return ($nOrderedQty - $assignedOrderItems->count());
    }

    /**
     * Create new item
     * 
     * @param integer $orderId
     * @param integer $productId
     * @param integer $quantity
     * @return boolean
     */
    protected function createNewItem($orderId, $productId, $quantity)
    {
        $newItems = [];

        for ($i = 0; $i < $quantity; $i++) {
            array_push($newItems, [
                'order_id'        => $orderId,
                'product_id'      => $productId,
                'status'          => \App\Models\Item::STATUS_ASSIGNED,
                'physical_status' => \App\Models\Item::STATUS_PHYSICAL_TO_ORDER,
                'created_at'      => \Carbon\Carbon::now(),
                'updated_at'      => \Carbon\Carbon::now()
            ]);
        }

        $bool = \App\Models\Item::insert($newItems);

        return $bool;
    }

}
