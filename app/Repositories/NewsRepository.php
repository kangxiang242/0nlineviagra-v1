<?php

namespace App\Repositories;

use App\Models\Article;

class NewsRepository extends Repository
{

    protected string $modelClass = Article::class;


    public function all()
    {
        return $this->remember(function (){
            return $this->model()->with('cate')->where('status',1)->orderBy('sort','asc')->get();
        });
    }

    public function find($id){
        return $this->all()->where('id',$id)->first();
    }

    public function getNext($id){
        $articles = $this->all()->values(); // 重新索引
        $index = $articles->search(fn($item) => $item->id == $id);

        if ($index !== false && isset($articles[$index + 1])) {
            return $articles[$index + 1];
        }

        return null;
    }

    public function getPrev($id){
        $articles = $this->all()->values(); // 重新索引
        $index = $articles->search(fn($item) => $item->id == $id);

        if ($index !== false && isset($articles[$index - 1])) {
            return $articles[$index - 1];
        }

        return null;
    }



}