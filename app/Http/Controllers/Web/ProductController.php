<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\NewsRepository;

class ProductController extends Controller
{
    public function index(CategoryRepository $categoryRepository,NewsRepository $newsRepository){

        $category = $categoryRepository->all();


        return view('web::product.index',compact('category','news'));
    }


    public function show($id){

        $product = Product::where('id',$id)->where('status',1)->first();

        if(!$product){
            abort(404);
        }




        return view('web::product.show',compact('product'));
    }
}
