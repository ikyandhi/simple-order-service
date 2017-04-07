<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $contracts = [
        [
            \App\Contracts\Repository\OrderRepositoryInterface::class,
            \App\Repositories\Eloquent\OrderRepository::class
        ],
        [
            \App\Contracts\Repository\ProductRepositoryInterface::class,
            \App\Repositories\Eloquent\ProductRepository::class
        ],
        [
            \App\Contracts\Repository\ItemRepositoryInterface::class,
            \App\Repositories\Eloquent\ItemRepository::class
        ]
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindContracts();
    }

    protected function bindContracts()
    {
        $contracts = $this->contracts;

        if (!empty($contracts)) {
            foreach ($contracts as $contract) {
                $this->app->bind($contract[0], $contract[1]);
            }
        }
    }

}
