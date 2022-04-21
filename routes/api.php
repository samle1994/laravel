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
    Route::get('products', 'Api\ProductController@index');
    Route::post('products', 'Api\ProductController@store');
    Route::get('/products/{id}', 'Api\ProductController@show');
    Route::put('/products/{id}', 'Api\ProductController@update');
    Route::delete('/products/{id}', 'Api\ProductController@destroy');

    Route::get('productlist/paging', 'Api\ProductListController@index');
    Route::post('productlist', 'Api\ProductListController@store');
    Route::get('/productlist/{id}', 'Api\ProductListController@show');
    Route::put('/productlist/{id}', 'Api\ProductListController@update');
    Route::delete('/productlist/{id}', 'Api\ProductListController@destroy');
});