<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //设置安全字段
    protected $fillable = ['status'];
}
