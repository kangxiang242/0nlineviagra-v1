<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{

    protected $orderColumn = 'sort';

    protected $titleColumn = 'name';

    public function sub()
    {
        return $this->hasMany(Navigation::class, 'parent_id', 'id')->orderBy('sort','asc');
    }
}
