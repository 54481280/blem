<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    //设置安全字段
    protected $fillable = [
        'title',
        'content',
        'signup_start',
        'signup_end',
        'prize_date',
        'signup_num',
        'is_prize',
    ];

    public function getPrize(){
        return $this->hasMany(EventPrizes::class,'events_id');
    }

    //获取报名用户
    public function singUpUser(){
        return $this->hasMany(EventMember::class,'events_id');
    }

    //获取用户的名称
    public static function singUpName($id){
        return User::select('name')->find($id);
    }

    //查询是否报名
    public static function checkSing($prize_id){
        return EventMember::where('events_id',$prize_id)->where('member_id',Auth::user()->id)->first();
    }
}
