<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Shops extends Model
{
    //设置安全字段
   protected $fillable = [
       'shop_category_id',
       'shop_name',
       'shop_img',
       'shop_rating',
       'brand',
       'on_time',
       'fengniao',
       'bao',
       'piao',
       'zhun',
       'start_send',
       'send_cost',
       'notice',
       'discount',
       'status',
       ];

    public function cate(){
        return $this->belongsTo(ShopCategories::class,'shop_category_id');
    }

    public function users(){
        return $this->hasOne(Users::class,'shop_id','id');
    }

}
