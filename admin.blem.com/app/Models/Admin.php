<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    //设置安全字段
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
