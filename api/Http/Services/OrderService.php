<?php

namespace Api\Http\Services;

use App\Contracts\Repository\OrderRepositoryInterface;
use App\Contracts\Repository\ProductRepositoryInterface;
use App\Events\OrderWasCreated;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 5, 2017 7:56:28 AM
 * File         : OrderService.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class OrderService
{

    use DispatchesJobs;

    /**
     *
     * @var OrderRepositoryInterface
     */
    protected $repository;

    /**
     *
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(OrderRepositoryInterface $repository,
                                ProductRepositoryInterface $productRepository)
    {
        $this->repository        = $repository;
        $this->productRepository = $productRepository;
    }

    /**
     * Create Order
     * 
     * @param Request $request
     */
    public function createOrder(Request $request)
    {
        \DB::beginTransaction();

        $orderData = $request->get('order');

        $items = collect();

        $newlyCreatedProducts = [];

        foreach ($orderItems = $orderData['items'] as $item) {

            if ($this->productRepository->isExistsBySku($item['sku'])) {
                $product = $this->productRepository->findByField('sku', $item['sku'])->first();
            }
            else {
                $product = $this->createProduct($item['sku']);
                array_push($newlyCreatedProducts, $item['sku']);
            }

            $items->push(['sku' => $product->sku, 'product_id' => $product->id, 'quantity' => $item['quantity']]);
        }

        $order = $this->repository->create([
            'customer_name'    => $orderData['customer'],
            'address'          => $orderData['address'],
            'status'           => Order::STATUS_IN_PROGRESS,
            'total'            => $orderData['total'],
            'order_created_at' => Carbon::now()
        ]);

        event(new OrderWasCreated($order, $items));

        if (!empty($newlyCreatedProducts)) {
            event(new \App\Events\ProductWasCreatedFromOrder($newlyCreatedProducts));
        }

        \DB::commit();
        return $order;
    }

    public function updateOrder($orderId, Request $request)
    {
        $orderData = $request->get('order');
        $order     = $this->repository->findById($orderId);

        if ($order) {
            $order->fill([
                'customer_name' => $orderData['customer'],
                'address'       => $orderData['address'],
                'total'         => $orderData['total']
            ])->update();

            return $order;
        }
        else {
            return false;
        }
    }

    protected function createProduct($sku, $properties = [])
    {
        return Product::firstOrCreate(array_merge(['sku' => $sku], $properties));
    }

}

/* End of file OrderService.php */