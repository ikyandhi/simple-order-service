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
        $this->post('api/orders')->assertStatus(201);
    }

}
