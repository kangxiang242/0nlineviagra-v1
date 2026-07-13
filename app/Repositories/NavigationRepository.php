<?php

namespace App\Repositories;


use App\Models\Navigation;

class NavigationRepository extends Repository
{
    protected string $modelClass = Navigation::class;


    public function all()
    {
        return $this->remember(function (){
            return $this->model()->with('sub')->where('parent_id',0)->where('status',1)->orderBy('sort','asc')->get();
        });
    }
}