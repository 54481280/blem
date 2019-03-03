<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //设置安全字段
    protected $fillable = [
        'user_id',
        'shop_id',
        'sn',
        'province',
        'city',
        'county',
        'address',
        'tel',
        'name',
        'total',
        'status',
        'out_trade_no',

    ];
}
