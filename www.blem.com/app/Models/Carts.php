<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    //设置安全字段
    protected $fillable = ['user_id','goods_id','amount'];
}
