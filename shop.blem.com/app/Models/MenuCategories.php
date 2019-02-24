<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MenuCategories extends Model
{
    //设置安全字段
    protected $fillable = [
        'name',
        'type_accumulation',
        'shop_id',
        'description',
        'is_selected',
    ];

    //返回所有菜品分类
    public static function cate(){
        return MenuCategories::all()->where('shop_id',Auth::user()->id);
    }
}
