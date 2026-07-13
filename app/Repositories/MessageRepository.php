<?php

namespace App\Repositories;


use App\Models\Message;

use Carbon\Carbon;
use Illuminate\Support\Arr;


class MessageRepository extends Repository
{

    protected string $modelClass = Message::class;

    public function groupByDayIpCount($ip = null){
        $ip = $ip ?? ip();
        return $this->model()->whereBetWeen('created_at',[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])->where('ip',$ip)->count();
    }

    public function store(array $data){
        $data = Arr::only($data,['name','email','phone','content','type','sex']);
        $insert = array_merge($data,['ip'=>ip(),'user_agent'=>user_agent()]);
        return $this->model()->create($insert);
    }

}