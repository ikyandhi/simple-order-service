<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\OrderWasCreated' => [
            'App\Listeners\AddItem',
        ],
        'App\Events\ItemWasUpdated' => [
            'App\Listeners\CompleteOrder'
        ],
        'App\Events\ItemWasRemoved' => [
            'App\Listeners\CancelOrder'
        ],
        'App\Events\ProductWasCreatedFromOrder' => [
            'App\Listeners\EmailProductNewlyCreatedConfirmation'
        ],
        'App\Events\OrderWasCompleted' => [
            'App\Listeners\EmailOrderConfirmation'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

}
