<?php

use Dingo\Api\Routing\Router;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

//Do Grouping
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'Api\Http\Controllers\V1'], function(Router $api) {
    $api->post('orders', ['as' => 'orders.store', 'uses' => 'OrderController@store']);
});
