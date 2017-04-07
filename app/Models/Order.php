<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    /**
     * Order canceled
     */
    const STATUS_CANCELED = 'canceled';

    /**
     * Order in progress
     */
    const STATUS_IN_PROGRESS = 'in_progress';

    /**
     * Order is completed
     */
    const STATUS_COMPLETED = 'completed';

    protected $table   = 'orders';
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * 
     * @return \Illuminate\Support\Collection
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'order_id');
    }

    public function scopeIsCanceled($query)
    {
        return $query->where('status', self::STATUS_CANCELED);
    }

    public function scopeIsCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeIsInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

}
