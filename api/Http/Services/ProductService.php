<?php

namespace Api\Http\Services;

use App\Contracts\Repository\ProductRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 6, 2017 9:24:20 PM
 * File         : ProductService.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class ProductService
{

    /**
     *
     * @var ProductRepositoryInterface
     */
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createProduct(Request $request)
    {
        \DB::beginTransaction();

        try
        {
            $productData = $request->get('product');
            $product     = $this->repository->create([
                'sku'    => $productData['sku'],
                'colour' => $product['colour']
            ]);

            \DB::commit();
            return $product;
        }
        catch (Exception $ex)
        {
            \Log::error($ex->getMessage());
            \DB::rollback();
        }

        return false;
    }

    public function updateProduct($productId, Request $request)
    {
        
    }

    public function destroyProduct($productId)
    {
        
    }

}

/* End of file ProductService.php */