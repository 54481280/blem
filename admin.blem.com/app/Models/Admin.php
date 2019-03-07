<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;

    protected $guard_name = 'web'; // or whatever guard you want to use

    //设置安全字段
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
