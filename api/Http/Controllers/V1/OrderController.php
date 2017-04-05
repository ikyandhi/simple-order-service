<?php

namespace Api\Http\Controllers\V1;

use Api\Http\Controllers\Controller;
use Api\Http\Services\OrderService;
use App\Contracts\Repository\OrderRepositoryInterface as Repository;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store new order
     * 
     * @param Request $request
     */
    public function store(OrderService $service, Request $request)
    {
        $validation = Validator::make($request->all(), [
                    'order'                  => 'required|array',
                    'order.customer'         => 'required',
                    'order.address'          => 'required',
                    'order.total'            => 'required|numeric',
                    'order.items'            => 'required|array',
                    'order.items.*.sku'      => 'required',
                    'order.items.*.quantity' => 'required|min:1|numeric',
        ]);

        if ($validation->fails()) {
            return $this->response()->errorBadRequest($validation->messages()->first());
        }

        $order = $service->createOrder($request);

        if ($order) {
            return $this->response()->created();
        }
    }

}
