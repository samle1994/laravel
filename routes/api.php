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
    Route::delete('/removegallery/{id}', 'Api\RemovegalleryController@destroy');

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

    Route::get('news/paging', 'Api\NewsController@index');
    Route::post('news', 'Api\NewsController@store');
    Route::get('news/{id}', 'Api\NewsController@show');
    Route::post('news/{id}', 'Api\NewsController@update');
    Route::delete('news/{id}', 'Api\NewsController@destroy');

    Route::get('setting/{id}', 'Api\SettingController@show');
    Route::put('setting/{id}', 'Api\SettingController@update');

    Route::get('photo/{id}', 'Api\PhotoStaticController@show');
    Route::post('photo/{id}', 'Api\PhotoStaticController@update');

    Route::get('photos/paging', 'Api\PhotoController@index');
    Route::post('photos', 'Api\PhotoController@store');
    Route::get('photos/{id}', 'Api\PhotoController@show');
    Route::post('photos/{id}', 'Api\PhotoController@update');
    Route::delete('photos/{id}', 'Api\PhotoController@destroy');

});

Route::group(['prefix'=>'/Frontend'],function(){
    Route::get('photo/{id}', 'Api\ShowPhotoController@show');
    Route::get('photos/{id}', 'Api\ShowPhotosController@show');
    Route::get('search/paging', 'Api\SearchProductController@index');
    Route::get('productnews/paging', 'Api\ProductNewsController@index');
    Route::get('productsale/paging', 'Api\ProductSaleController@index');
    Route::get('producthot/paging', 'Api\ProductHotController@index');
    Route::get('product/paging', 'Api\ShowProductController@index');
    Route::get('productdetail/{id}', 'Api\ShowProductDetailController@show');
    Route::get('showinfo', 'Api\ShowInfoController@index');
    Route::get('news/paging', 'Api\ShowNewsController@index');
    Route::get('newsdetail/{id}', 'Api\ShowNewsDetailController@show');
    Route::get('newshot/paging', 'Api\NewsHotController@index');
});