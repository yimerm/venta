<?php

use Illuminate\Support\Facades\Route;

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
    return view('layouts/app');
});
Route::resource('user','usuariosControler');
Route::resource('clientes','clienteControler');
Route::resource('productos','productosControler');
Route::resource('categoria','categoriaControler');
Route::resource('proveedor','proveedorControler');
Route::resource('entradafactura','factEntradaControler');
Route::resource('inventarioproducto','inventarioproduController');
Route::resource('venta','ventaController');
Route::resource('factura','FacturasventasController');
Route::resource('tablero','TableroController');
//mostar productos de espera
Route::post('mostarespera','ventaController@mostarespra');
//
Route::post('login','LoginControler@login');
//crae n espera y guarda articulo con n esper asignado
Route::post('craerspera','ventaController@craerspera');
// buscar producto por nombre
Route::post('listaproducto','ventaController@listaproducto');
Route::post('listacategoria','proveedorControler@listacategoria');
Route::post('buscarnfactura','ventaController@buscarnfactura');
//procesar factura de venta
Route::post('procesarfacturaventa','ventaController@procesarfacturaventa');
Route::post('borrararticuloventa','ventaController@borrararticuloventa');
Route::post('mostartotalinventio','factEntradaControler@mostartotalinventio');
Route::post('capturartablaproducto','inventarioproduController@capturartablaproducto');
Route::post('actualisarregistrotabla','inventarioproduController@actualisarregistrotabla');
Route::post('actualisarprocesoven','inventarioproduController@actualisarprocesoven');
Route::post('buscarnfacturainventario','inventarioproduController@buscarnfacturainventario');
Route::post('buscarProinventario','inventarioproduController@buscarProinventario');
Route::post('verificarfactura','inventarioproduController@verificarfactura');

Route::post('cargarproductoventa','ventaController@cargarproductoventa');
//facturas de ventas
//Route::get('venta/1/facturaventa','ventaController@facturaventa');
Route::get('venta/1/pdffacturaventa','factEntradaControler@pdffacturaventa');
//
Route::get('venta/1/facturaprocesada','ventaController@facturaprocesada');
Route::get('venta/1/imprimirfacturan','ventaController@imprimirfacturan');
Route::post('venta/1/devolucionprod','ventaController@devolucionprod');
Route::post('devolucionespro','ventaController@devolucionespro');
//Route::get('entradafactura/{tercero}/imprimir','factEntradaControler@imprimir');