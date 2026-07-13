<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $dates = ['delete_at','release_at'];

    protected $sortable = [
        // 设置排序字段名称
        'order_column_name' => 'sort',
        // 是否在创建时自动排序，此参数建议设置为true
        'sort_when_creating' => true,
    ];

    public function cate()
    {
        return $this->belongsTo(ArticleCate::class,'article_cate_id');
    }
}
