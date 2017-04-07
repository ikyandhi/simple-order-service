<?php

namespace Api\Http\Services;

use App\Contracts\Repository\ItemRepositoryInterface;
use App\Events\ItemWasRemoved;
use App\Events\ItemWasUpdated;
use App\Models\Item;
use Illuminate\Http\Request;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 6, 2017 11:15:40 AM
 * File         : ItemService.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class ItemService
{

    /**
     *
     * @var ItemRepositoryInterface
     */
    protected $repository;

    public function __construct(ItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createItem(Request $request)
    {
        $itemData = $request->get('item');

        $item = new Item([
            'product_id'      => $itemData['product_id'],
            'status'          => $itemData['status'],
            'physical_status' => $itemData['physical_status']
        ]);

        if (!empty($itemData['order_id'])) {
            $item->order_id = $itemData['order_id'];
            $item->status   = Item::STATUS_ASSIGNED;
        }

        $item->save();

        return $item;
    }

    public function updateItem($itemId, Request $request)
    {
        $itemData = $request->get('item');
        $item     = $this->repository->findById($itemId);

        if ($item) {
            $item->fill([
                'status'          => isset($itemData['status']) ? $itemData['status'] : $item->status,
                'physical_status' => $itemData['physical_status']
            ]);

            $item->save();

            event(new ItemWasUpdated($item));
            return $item;
        }

        return false;
    }

    public function destroyItem($itemId)
    {
        $item = $this->repository->findById($itemId);

        if ($item && !in_array($item->physical_status, [Item::STATUS_PHYSICAL_IN_WAREHOUSE, Item::STATUS_PHYSICAL_DELIVERED])) {
            $removedItem = $item;
            $item->delete();

            if (!empty($removedItem)) {
                event(new ItemWasRemoved($removedItem));
            }
            return true;
        }

        return false;
    }

}

/* End of file ItemService.php */