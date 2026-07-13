<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $sortable = [
        // 设置排序字段名称
        'order_column_name' => 'sort',
        // 是否在创建时自动排序，此参数建议设置为true
        'sort_when_creating' => true,
    ];


    protected $fillable = [
        'category_id','name','img','m_img','subtitle','price','market_price','status','is_stock','sort','tags','quantity','label','describe'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
