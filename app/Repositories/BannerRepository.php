<?php

namespace App\Repositories;

use App\Models\Banner;

use Illuminate\Support\Str;

class BannerRepository extends Repository
{

    protected string $modelClass = Banner::class;


    public function all()
    {
        return $this->remember(function (){
            return $this->model()->get();
        });
    }

    public function current(){
        $currentPath = request()->path();

        return $this->all()->first(function ($item) use ($currentPath) {
            $page = ltrim($item['page'], '/') ?: '/'; // 去掉开头的斜杠
            return Str::is($page, $currentPath);
        });
    }


}