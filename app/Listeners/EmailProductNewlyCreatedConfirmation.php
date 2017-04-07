<?php

namespace App\Listeners;

use App\Events\ProductWasCreatedFromOrder;
use App\Jobs\sendEmailProductNewlyCreatedConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailProductNewlyCreatedConfirmation
{

    use \Illuminate\Foundation\Bus\DispatchesJobs,
        ShouldQueue;

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
     * @param  ProductWasCreatedFromOrder  $event
     * @return void
     */
    public function handle(ProductWasCreatedFromOrder $event)
    {
        $this->dispatch(new sendEmailProductNewlyCreatedConfirmation($event->newlyCreatedSKUs));
    }

}
