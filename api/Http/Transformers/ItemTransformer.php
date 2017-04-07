<?php

namespace Api\Http\Transformers;

use App\Models\Item;
use League\Fractal\TransformerAbstract;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 6, 2017 11:14:01 AM
 * File         : ItemTransformer.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class ItemTransformer extends TransformerAbstract
{

    public function transform(Item $model)
    {
        return [
            'id'              => $model->id,
            'sku'             => $model->product->sku,
            'status'          => $model->status,
            'physical_status' => $model->physical_status
        ];
    }

}

/* End of file ItemTransformer.php */