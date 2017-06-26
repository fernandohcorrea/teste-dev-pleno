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

Route::group(array('prefix' => 'api'), function()
{

  Route::get('/', function () {
      return response()->json(['message' => 'Vendas API', 'status' => 'Connected']);;
  });
  
  Route::get('/vendedores/{id_vendedor}/vendas/{id_venda?}', 'VendasController@getVendasVendedor');

  Route::resource('vendedores', 'VendedoresController');
  Route::resource('vendas', 'VendasController');
  
});

Route::get('/', function () {
    return view('welcome');
});
