<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Message extends Model
{

    protected $fillable = [
        'name','phone','email','content','ip','user_agent','type','sex'
    ];

    public function getRelatedOrdersAttribute()
    {
        if (empty($this->phone) && empty($this->email)) {
            return collect();
        }
        return Order::where(function ($q) {
                if (!empty($this->phone)) {
                    $q->where('phone', $this->phone);
                }
                if (!empty($this->email)) {
                    $q->orWhere('email', $this->email);
                }
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }


}
