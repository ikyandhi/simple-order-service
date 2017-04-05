<?php

namespace Api\Http\Services;

use App\Contracts\Repository\OrderRepositoryInterface;
use App\Contracts\Repository\ProductRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 5, 2017 7:56:28 AM
 * File         : OrderService.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class OrderService
{

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
        $order = $request->get('order');

        foreach ($orderItems = $order['items'] as $item) {

            if ($this->productRepository->isExistsBySku($item['sku'])) {
                $product = $this->productRepository->findByField('sku', $item['sku']);
            }
            else {
                $product = $this->createProduct($item['sku']);
            }
            
            
        }
    }

    protected function createProduct($sku, $properties = [])
    {
        return \App\Models\Product::firstOrCreate(array_merge(['sku' => $sku], $properties));
    }

}

/* End of file OrderService.php */