<?php

namespace App\Repositories;

use App\Models\Category;


class CategoryRepository extends Repository
{

    protected string $modelClass = Category::class;


    public function all()
    {
        return $this->remember(function (){
            return $this->model()->with('products')->orderBy('sort')->where('status',1)->get();
        });
    }



}