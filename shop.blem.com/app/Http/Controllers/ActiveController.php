<?php

namespace App\Http\Controllers;

use App\Models\Active;
use Illuminate\Http\Request;

class ActiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //活动页面
    public function index(){
        $date = date('Y-m-d');//获取当前时间
        //获取所有进行中的活动
        $runActives = Active::where('start_time','<=',$date)->where('end_time','>=',$date)->get();
        return view('Active.index',compact('runActives'));
    }

    //活动页面
    public function wait(){
        $date = date('Y-m-d');//获取当前时间
        //获取所有未进行的活动
        $waitActives = Active::where('start_time','>',$date)->get();
        return view('Active.wait',compact('waitActives'));
    }
}
