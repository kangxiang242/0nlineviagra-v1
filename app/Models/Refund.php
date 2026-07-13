<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{

    const SEX = [
        '不透露','男','女'
    ];

    const TYPE = [
        '換貨/補寄','退貨及退款'
    ];

    protected $casts = [
        'pictures'=>'json',
    ];

    protected $fillable = [
        'name','phone','sex','type','reason','pictures','ip','user_agent'
    ];
}
