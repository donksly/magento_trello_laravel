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

Route::get('/', 'OrdersController@index');
Route::post('/open_supplier_modal', 'OrdersController@loadSupplierModal');
Route::post('/modal_save_update_supplier', 'OrdersController@');
Route::post('/open_return_modal', 'OrdersController@loadReturnModal');
Route::post('/modal_request_return', 'OrdersController@');
Route::post('/open_single_order_modal', 'OrdersController@loadSingleOrder');
Route::post('/modal_fix_errors_form', 'OrdersController@');

Route::get('/suppliers', 'SuppliersController@index');
Route::post('/create_new_supplier', 'SuppliersController@createSuppliers');

Route::get('/import', 'OrdersController@indexImport');
Route::post('/upload_supplier_database', 'OrdersController@');

Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
