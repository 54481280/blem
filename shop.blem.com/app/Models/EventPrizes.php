<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPrizes extends Model
{
    //设置安全字符安
    protected $fillable = [
        'events_id',
        'name',
        'description',
        'member_id',
    ];
}
