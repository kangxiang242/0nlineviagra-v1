<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Cate extends Model
{
    protected $fillable = ['pid','name','status','sort'];
    protected $titleColumn = 'name';
    protected $orderColumn = 'sort';
}
