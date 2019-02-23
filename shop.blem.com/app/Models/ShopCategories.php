<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ShopCategories extends Model
{
    //设置安全字段
    protected $fillable = ['name','img','status'];

    //获取图片在入口目录中的路径
    public function img(){
        return Storage::url($this->img);
    }
}
