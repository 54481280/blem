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

    //获取图片快捷方式路径
    public function img(){
        return Storage::url($this->shop_img);
    }

    public function cate(){
        return $this->belongsTo(ShopCategories::class,'shop_category_id');
    }
}
