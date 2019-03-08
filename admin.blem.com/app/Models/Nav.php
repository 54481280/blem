<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Nav extends Model
{
    //设置安全字段
    protected $fillable = ['name','url','pid','permission_id','span'];

    //获取所有一级的菜单名称和地址
    public static function navData(){
        return self::select('name','url','pid','span','permission_id')->where('pid',0)->orderBy('id','asc')->get();
    }

    public function permission(){
        return $this->belongsTo(Permission::class,'permission_id');
    }

}
