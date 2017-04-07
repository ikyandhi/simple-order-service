<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class OrderWasCreated
{

    use Dispatchable,
        InteractsWithSockets,
        SerializesModels;

    /**
     *
     * @var Order 
     */
    public $order;

    /**
     *
     * @var Collection 
     */
    public $items;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order, Collection $items)
    {
        $this->order = $order;
        
        $this->items = $items;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        //
    }

}
