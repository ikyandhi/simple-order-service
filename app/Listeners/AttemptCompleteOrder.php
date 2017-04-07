<?php

namespace App\Listeners;

use App\Events\OrderItemWasDelivered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttemptCompleteOrder
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderItemWasDelivered  $event
     * @return void
     */
    public function handle(OrderItemWasDelivered $event)
    {
        //
    }
}
