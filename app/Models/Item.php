<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Item extends Model
{

    /**
     * Item can be attach to any order
     */
    const STATUS_AVAILABLE = 'available';

    /**
     * Item cannot be attached to other order
     */
    const STATUS_ASSIGNED = 'assigned';

    /**
     * Item has physical status
     */
    const STATUS_PHYSICAL_TO_ORDER = 'to_order';

    /**
     * 
     */
    const STATUS_PHYSICAL_IN_WAREHOUSE = 'in_warehouse';

    /**
     * 
     */
    const STATUS_PHYSICAL_DELIVERED = 'delivered';

    /**
     *
     * @var string 
     */
    protected $table = 'items';

    /**
     *
     * @var array 
     */
    protected $guarded = ['id'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @param Builder $query
     * 
     * @return Builder
     */
    public function scopeIsAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    /**
     * @param Builder $query
     * 
     * @return Builder
     */
    public function scopeIsAssigned($query)
    {
        return $query->where('status', self::STATUS_ASSIGNED);
    }

    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

}
