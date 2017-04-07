<?php

namespace Api\Http\Controllers\V1;

use Api\Http\Controllers\Controller;
use Api\Http\Services\OrderService;
use Api\Http\Transformers\OrderTransformer;
use App\Contracts\Repository\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{

    /**
     *
     * @var OrderRepositoryInterface 
     */
    protected $repository;

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function index(Request $request)
    {
        $paginator = $this->repository->findAllWithPagination(20);

        return $this->response()->paginator($paginator, OrderTransformer::class);
    }

    /**
     * 
     * @param integer $orderId
     * @return type
     */
    public function show($orderId)
    {
        $order = $this->repository->findById($orderId);

        if ($order) {
            return $this->response()->item($order, OrderTransformer::class);
        }

        return $this->response()->errorNotFound();
    }

    /**
     * Update order
     * 
     * @param integer $orderId
     * @param OrderService $service
     * @param Request $request
     * @return HTTP_RESPONSE
     */
    public function update($orderId, OrderService $service, Request $request)
    {
        $validation = \Validator::make(array_merge(['order_id' => $orderId], $request->all()), [
                    'order_id'               => "required|exists:orders,id",
                    'order'                  => 'required|array',
                    'order.customer'         => 'required',
                    'order.address'          => 'required',
                    'order.total'            => 'numeric',
                    'order.items'            => 'array',
                    'order.items.*.sku'      => '',
                    'order.items.*.quantity' => 'min:1|numeric',
        ]);

        if ($validation->fails()) {
            return $this->response()->errorBadRequest($validation->messages()->first());
        }

        $order = $service->updateOrder($orderId, $request);

        if ($order) {
            return $this->response()->accepted();
        }
        else {
            return $this->response()->errorBadRequest("Unable to proceed the update, or order doesn't exists.");
        }
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

        return $this->response()->errorBadRequest();
    }

}
