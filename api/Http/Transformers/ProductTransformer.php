<?php

namespace Api\Http\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 7, 2017 12:52:58 PM
 * File         : ProductTransformer.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class ProductTransformer extends TransformerAbstract
{

    public function transform(Product $model)
    {
        return [
            'id'  => $model->id,
            'sku' => $model->sku
        ];
    }

}

/* End of file ProductTransformer.php */