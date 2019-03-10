<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMember extends Model
{
    //设置安全字段
    protected $fillable = [
        'events_id',
        'member_id',
    ];
}
