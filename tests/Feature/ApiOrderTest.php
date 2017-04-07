<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiOrderTest extends TestCase
{

    use DatabaseTransactions;

    protected $products;

    public function test_it_succesfully_created()
    {
        $response = $this->json('POST', 'api/orders', ['order' => [
                'customer' => "John Cena",
                'address'  => 'This is test email',
                'total'    => 100,
                'items'    => [
                    ['sku' => 'Test1', 'quantity' => 10],
                    ['sku' => 'Test2', 'quantity' => 2],
                ]
        ]]);

        $response->assertStatus(201);
    }

}
