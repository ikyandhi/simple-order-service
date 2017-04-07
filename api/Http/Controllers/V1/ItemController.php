<?php

namespace Api\Http\Controllers\V1;

use Api\Http\Controllers\Controller;
use Api\Http\Services\ItemService;
use Api\Http\Transformers\ItemTransformer;
use App\Contracts\Repository\ItemRepositoryInterface;
use App\Models\Item;
use Illuminate\Http\Request;
use Validator;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 6, 2017 11:12:27 AM
 * File         : ItemController.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class ItemController extends Controller
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

    /**
     * 
     * @return type
     */
    public function index()
    {
        $paginator = $this->repository->findAllWithPagination(20);

        return $this->response()->paginator($paginator, ItemTransformer::class);
    }

    /**
     * 
     * @param ItemService $service
     * @param Request $request
     * @return void
     */
    public function store(ItemService $service, Request $request)
    {
        $validation = Validator::make($request->all(), [
                    'item'                 => 'required|array',
                    'item.status'          => "in:" . implode(",", [Item::STATUS_AVAILABLE, Item::STATUS_ASSIGNED]),
                    'item.physical_status' => "in:" . implode(",", [Item::STATUS_PHYSICAL_TO_ORDER, Item::STATUS_PHYSICAL_IN_WAREHOUSE, Item::STATUS_PHYSICAL_DELIVERED]),
                    'item.product_id'      => "required|exists:products,id",
                    'item.order_id'        => 'exists:orders,id|required_if:item.status,' . Item::STATUS_ASSIGNED
        ]);


        if ($validation->fails()) {
            return $this->response()->errorBadRequest($validation->messages()->first());
        }

        $item = $service->createItem($request);
        if ($item) {
            return $this->response()->created();
        }

        return $this->response()->errorBadRequest("Unable to proceed the request. Please try again or contact administrator.");
    }

    /**
     * 
     * @param integer $itemId
     * @param ItemService $service
     * @param Request $request
     * @return void
     */
    public function update($itemId, ItemService $service, Request $request)
    {
        $validation = Validator::make(array_merge(['item_id' => $itemId], $request->all()), [
                    'item_id'              => 'required|exists:items,id',
                    'item'                 => 'required|array',
                    'item.status'          => "in:" . implode(",", [Item::STATUS_AVAILABLE, Item::STATUS_ASSIGNED]),
                    'item.physical_status' => "in:" . implode(",", [Item::STATUS_PHYSICAL_TO_ORDER, Item::STATUS_PHYSICAL_IN_WAREHOUSE, Item::STATUS_PHYSICAL_DELIVERED]),
                    'item.product_id'      => "exists:products,id",
                    'item.order_id'        => 'exists:orders,id|required_if:item.status,' . Item::STATUS_ASSIGNED
        ]);

        if ($validation->fails()) {
            return $this->response()->errorBadRequest($validation->messages()->first());
        }


        $item = $service->updateItem($itemId, $request);

        if ($item) {
            return $this->response()->accepted();
        }

        return $this->response()->errorBadRequest("Unable to proceed the update, or item doesn't exists.");
    }

    /**
     * 
     * @param integer $itemId
     * @param ItemService $service
     * @return type
     */
    public function destroy($itemId, ItemService $service)
    {
        $validation = Validator::make(['item_id' => $itemId], [
                    'item_id' => 'required|exists:items,id'
        ]);

        if ($validation->fails()) {
            return $this->response()->errorBadRequest($validation->messages()->first());
        }

        $isRemoved = $service->destroyItem($itemId);

        if ($isRemoved) {
            return $this->response()->noContent();
        }

        return $this->response()->errorBadRequest("Unable to proceed the update, or item doesn't exists.");
    }

}

/* End of file ItemController.php */