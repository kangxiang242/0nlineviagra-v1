<?php

namespace App\Repositories;

use App\Models\Faq;


class FaqRepository extends Repository
{

    protected string $modelClass = Faq::class;


    public function all()
    {
        return $this->remember(function (){
            return $this->model()->get();
        });
    }



}