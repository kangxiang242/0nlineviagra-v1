<?php

namespace App\Repositories;

use App\Models\Page;
use Illuminate\Support\Str;

class PageRepository extends Repository
{

    protected string $modelClass = Page::class;


    public function all()
    {
        return $this->remember(function (){
            return $this->model()->get();
        });
    }

    public function current(){
        $currentPath = request()->path();

        return $this->all()->first(function ($item) use ($currentPath) {
            $page = ltrim($item['uri'], '/') ?: '/'; // 去掉开头的斜杠
            return Str::is($page, $currentPath);
        });

    }


}