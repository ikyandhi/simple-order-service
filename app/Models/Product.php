<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    /**
     *
     * @var string 
     */
    protected $table = 'products';

    /**
     *
     * @var array
     */
    protected $guarded = ['id'];

}
