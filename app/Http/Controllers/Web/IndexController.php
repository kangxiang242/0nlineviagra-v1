<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\NewsRepository;
use App\Repositories\ProductRepository;

class IndexController extends Controller
{
    public function index(ProductRepository $productRepository,NewsRepository $newsRepository){

        $products = $productRepository->all()->take(7);

        $news = $newsRepository->all();




        return view('web::index',compact('products','news'));
    }


}
