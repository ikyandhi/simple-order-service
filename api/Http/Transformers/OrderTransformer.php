<?php

namespace Api\Http\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 6, 2017 10:34:46 AM
 * File         : OrderTransformer.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class OrderTransformer extends TransformerAbstract
{

    public function transform(Order $model)
    {


        $items = $model->items ? $model->items->map(function ($item, $key) {
                    return [
                        'id'              => $item->id,
                        'sku'             => $item->product->sku,
                        'status'          => $item->status,
                        'physical_status' => $item->physical_status
                    ];
                }) : [];


        return [
            'id'               => $model->id,
            'customer_name'    => $model->customer_name,
            'customer_email'   => $model->customer_email,
            'address'          => $model->address,
            'status'           => $model->status,
            'total'            => $model->total,
            'order_created_at' => $model->order_created_at,
            'items'            => $items
        ];
    }

}

/* End of file OrderTransformer.php */