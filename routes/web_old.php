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

Route::group(['namespace'=>'Web','middleware'=>['redirect.device','defend']],function (){

    Route::get('/', "IndexController@index")->middleware('googlebot.checked');
    Route::get('/check', "OrderController@check");
    Route::post('/check', "OrderController@check");
    Route::get('/check/{no}', "OrderController@checking");
    Route::get('/news', "NewsController@index");
    Route::get('/news/{id}', "NewsController@show");
    Route::get('/product', "ProductController@index");
    Route::get('/product/{id}', "ProductController@show");
    Route::get('/shopping/{id}', "OrderController@shopping");
    //Route::get('/get/carts', "CartController@apex");
    Route::post('/order', "OrderController@store");
    Route::get('/message', "MessageController@index");
    Route::post('/message', "MessageController@store");
    Route::get('/guide', "GuideController@index");

    Route::get('/area', "AreaController@get");
    Route::get('/area/city', "AreaController@getCity");
    Route::get('/area/county', "AreaController@getCounty");
    Route::get('/area/road', "AreaController@getRoad");
    Route::get('/area/shop', "AreaController@getShop");

    Route::get('/get711', "AreaController@get711");

    Route::get('/robots.txt', "BaseController@robots");
    Route::get('/sitemap.xml', "BaseController@sitemap");
});

