<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\OrderRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\Order;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 5, 2017 1:18:58 AM
 * File         : OrderRepository.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    protected $model = Order::class;

    public function search(array $parameters, $pagination = false)
    {
        
    }

}

/* End of file OrderRepository.php */