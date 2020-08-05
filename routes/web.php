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
    return redirect('login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    // Route::group(['middleware' => ['admin']], function(){
    Route::group(['middleware' => ['shipping']], function(){
        Route::prefix('shipping')->group(function () {
            Route::get('/', 'ShippingController@index');
            Route::get('/create', 'ShippingController@create');
            Route::get('/{id}/edit', 'ShippingController@edit');
            Route::post('/{id}', 'ShippingController@store');
            Route::post('{id}/update', 'ShippingController@update');
            Route::post('select_product', 'ShippingController@select_product');
        });
    });
    Route::group(['middleware' => ['finance']], function(){
        Route::prefix('finance')->group(function () {
            Route::get('/', 'FinanceController@index');
            Route::get('/create', 'FinanceController@create');
            Route::get('/{id}/edit', 'FinanceController@edit');
            Route::post('/{id}', 'FinanceController@store');
            Route::post('{id}/update', 'FinanceController@update');
            Route::post('select_product', 'FinanceController@select_product');
        });
    });
});
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/pdf', 'PDFController@index');
