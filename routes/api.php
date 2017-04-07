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

    /**
     * Orders
     */
    $api->get('orders', ['as' => 'orders.index', 'uses' => 'OrderController@index']);

    $api->post('orders', ['as' => 'orders.store', 'uses' => 'OrderController@store']);

    $api->put('orders/{id}', ['as' => 'orders.update', 'uses' => 'OrderController@update']);

    /**
     * Items
     */
    $api->get('items', ['as' => 'items.index', 'uses' => 'ItemController@index']);
    
    $api->post('items', ['as' => 'items.store', 'uses' => 'ItemController@store']);

    $api->put('items/{id}', ['as' => 'items.update', 'uses' => 'ItemController@update']);

    /**
     * Products
     */
    $api->get('products', ['as' => 'products.index', 'uses' => 'ProductController@index']);

    $api->get('products/{id}', ['as' => 'products.show', 'uses' => 'ProductController@show']);

    $api->post('products', ['as' => 'products.store', 'uses' => 'ProductController@store']);

    $api->put('products/{id}', ['as' => 'products.update', 'uses' => 'ProductController@update']);
});
