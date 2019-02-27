<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //设置安全字段
    protected $fillable = [
        'name',
        'email',
        'password',
        'name',
        'status',
        'shop_id',
    ];

    public function shops(){
        return $this->belongsTo(Shops::class,'shop_id');
    }
}
