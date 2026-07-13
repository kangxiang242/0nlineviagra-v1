<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRecord extends Model
{

    protected $fillable = [
        'ip','user_agent','content','reply'
    ];
}
