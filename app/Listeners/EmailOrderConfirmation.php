<?php

namespace App\Listeners;

use App\Events\OrderWasCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailOrderConfirmation
{

    use \Illuminate\Foundation\Bus\DispatchesJobs;

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
     * @param  OrderWasCompleted  $event
     * @return void
     */
    public function handle(OrderWasCompleted $event)
    {
        $this->dispatch(new \App\Jobs\SendEmailOrderConfirmation($event->order));
    }

}
