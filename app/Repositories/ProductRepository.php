<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends Repository
{

    protected string $modelClass = Product::class;


    public function all()
    {
        return $this->remember(function (){
            return $this->model()->where('status',1)->orderBy('sort','asc')->get();
        });
    }



}