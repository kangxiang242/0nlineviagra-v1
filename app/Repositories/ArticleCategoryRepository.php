<?php

namespace App\Repositories;

use App\Models\ArticleCate;



class ArticleCategoryRepository extends Repository
{

    protected string $modelClass = ArticleCate::class;


    public function all()
    {
        return $this->remember(function (){
            return $this->model()->orderBy('sort')->where('status',1)->get();
        });
    }



}