<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\MessageController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\AreaController;
use App\Http\Controllers\Web\ApiController;
use App\Http\Controllers\Web\ObserverController;

Route::get('/area/city', [AreaController::class, 'getCity']);
Route::get('/area/county', [AreaController::class, 'getCounty']);
Route::get('/area/road', [AreaController::class, 'getRoad']);
Route::get('/area/shop', [AreaController::class, 'getShop']);
Route::post('/observer/store', [ObserverController::class, 'store']);
Route::get('/robots.txt', [ApiController::class, 'robots']);
Route::get('/sitemap.xml', [ApiController::class, 'sitemap']);

Route::get('/', [IndexController::class, 'index']);
Route::any('/check', [OrderController::class, 'check']);
Route::get('/check/{no}', [OrderController::class, 'checking']);
Route::get('/order/{no}', [OrderController::class, 'checking']);
Route::get('/order/success/{no}', [OrderController::class, 'succeed']);
Route::get('/checkout/{id}', [OrderController::class, 'checkout']);
Route::get('/shopping/{id}', [OrderController::class, 'checkout']);
Route::post('/order', [OrderController::class, 'store']);
Route::get('/contact', [MessageController::class, 'index']);
Route::post('/contact', [MessageController::class, 'store']);
Route::get('/faq', [PageController::class, 'faq']);
Route::get('/area', [AreaController::class, 'get']);
Route::get('{any}', [PageController::class, 'index'])->where('any', '.*');
