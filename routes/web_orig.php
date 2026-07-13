<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['namespace'=>'Web'],function (){
    Route::get('/area/city', "AreaController@getCity");
    Route::get('/area/county', "AreaController@getCounty");
    Route::get('/area/road', "AreaController@getRoad");
    Route::get('/area/shop', "AreaController@getShop");
    Route::get('/robots.txt', "ApiController@robots");
    Route::get('/sitemap.xml', "ApiController@sitemap");

});


Route::group(['namespace'=>'Web','middleware'=>'googlebot.page'],function (){
    Route::get('/', "IndexController@index");
    Route::any('/check', "OrderController@check");
    Route::get('/check/{no}', "OrderController@checking");
    Route::get('/order/{no}', "OrderController@checking");
    Route::get('/order/success/{no}', "OrderController@succeed");

    Route::get('/refund', "RefundController@index");
    Route::post('/refund', "RefundController@store");

    /*Route::get('/blog', "NewsController@index");
    Route::get('/blog/{id}', "NewsController@show");*/

    Route::get('/faq', "PageController@faq");

    /*Route::get('/product', "ProductController@index");
    Route::get('/product/{id}', "ProductController@show");*/


    Route::get('/checkout/{id}', "OrderController@checkout");
    Route::get('/shopping/{id}', "OrderController@checkout");

    Route::post('/order', "OrderController@store");

    Route::get('/contact', "MessageController@index");
    Route::post('/contact', "MessageController@store");

    Route::get('/area', "AreaController@get");



    /*Route::get('{uri}',"PageController@index");
    Route::get('{uri}/{id}',"PageController@show");*/

    Route::get('{any}', 'PageController@index')->where('any', '.*');

});
