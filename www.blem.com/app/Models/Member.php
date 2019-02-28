<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    //设置安全字段
    protected $fillable = ['username','password','tel'];
}
