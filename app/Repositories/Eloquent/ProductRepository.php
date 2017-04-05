<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\ProductRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\Product;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 5, 2017 8:36:51 AM
 * File         : ProductRepository.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    protected $model = Product::class;

    public function isExistsBySku($sku)
    {
        return $this->instance->where('sku', $sku)->count();
    }

}

/* End of file ProductRepository.php */