<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RegisterController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\RegisterController@register');
Route::post('login', 'Api\loginController@login');

Route::group(['middleware' => 'Token'], function() {
    Route::get('product/paging', 'Api\ProductController@index');
    Route::post('product', 'Api\ProductController@store');
    Route::get('/product/{id}', 'Api\ProductController@show');
    Route::post('/product/{id}', 'Api\ProductController@update');
    Route::delete('/product/{id}', 'Api\ProductController@destroy');
    Route::get('/getproductcat/{id}', 'Api\GetProductCatController@show');

    Route::get('productlist/paging', 'Api\ProductListController@index');
    Route::post('productlist', 'Api\ProductListController@store');
    Route::get('/productlist/{id}', 'Api\ProductListController@show');
    Route::put('/productlist/{id}', 'Api\ProductListController@update');
    Route::delete('/productlist/{id}', 'Api\ProductListController@destroy');

    Route::get('productcat/paging', 'Api\ProductCatController@index');
    Route::post('productcat', 'Api\ProductCatController@store');
    Route::get('/productcat/{id}', 'Api\ProductCatController@show');
    Route::put('/productcat/{id}', 'Api\ProductCatController@update');
    Route::delete('/productcat/{id}', 'Api\ProductCatController@destroy');
});