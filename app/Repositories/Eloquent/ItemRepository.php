<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\ItemRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\Item;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 6, 2017 1:14:14 AM
 * File         : ItemRepository.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class ItemRepository extends BaseRepository implements ItemRepositoryInterface
{

    protected $model = Item::class;

    /**
     * Find all items assigned to order
     * 
     * @param integer $orderId
     */
    public function findAllAssignedItemByOrderId($orderId)
    {
        return $this->instance->where('order_id', $orderId)->ofStatus(Item::STATUS_ASSIGNED)->get();
    }

    public function findAllItemAssignedByOrderIdAndProductId($orderId,
                                                             $productId)
    {
        return $this->instance->where('order_id', $orderId)->where('product_id', $productId)->ofStatus(Item::STATUS_ASSIGNED)->get();
    }

}

/* End of file ItemRepository.php */