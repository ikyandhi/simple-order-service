<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return view('layout');
});

Route::get('orders', function () {
    return view('order.index');
});

Route::get('products', function () {
    return view('product.index');
});

Route::get('items', function () {
    return view('item.index');
});

Route::get('items/{id}/edit', function ($id) {
    return view('item.edit', compact('id'));
});

Route::get('items/create', function () {
    return view('item.create');
});
