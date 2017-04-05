<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table   = 'orders';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

}
