<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //设置安全字段
    protected $fillable = [
        'user_id',
        'province',
        'city',
        'area',
        'detail_address',
        'tel',
        'name',
        'is_default',
        ];
}
