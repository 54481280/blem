<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //数据统计页面
    public function index(){
        //声明空组数保存数据
        $data = [];
        //平台一周的订单总量
        $data['weekAll'] = $this->weekAll();
        //平台三月订单总量
        $data['monthAll'] = $this->monthAll();
        //平台一周的订单总量（按商家）
        $data['weekShopsAll'] = $this->weekShopsAll();
        //平台三月的订单总量（按商家）
        $data['monthShopsAll'] = $this->monthShopsAll();
        //平台三月订单总量（按商家）
        return view('Index.index',compact('data'));
    }

    //平台一周的订单总量
    public function weekAll(){
        //声明数组，保存最终数据
        $data = [];
        //时间区间
        $endTime = date('Y-m-d');
        $startTime= date('Y-m-d',strtotime('-6 day'));
        //查询数据
        $sql = "select date(created_at) as date ,count(*) as num from orders where date(created_at)  BETWEEN '{$startTime}' and '{$endTime}' group by date(created_at)";
        $rows = DB::select($sql);
        //构建对应数据格式
        for($i=0;$i<7;$i++){
            $data[date('Y-m-d',strtotime("-$i day"))] = 0;
        }

        foreach ($rows as $row){
            $data[$row->date] = $row->num;
        }

        return $data;
    }
    //平台近三月的订单总量
    public function monthAll(){
        //声明数组，保存最终数据
        $data = [];
        //时间区间
        $endTime = date('Y-m-d');
        $startTime= date('Y-m-d',strtotime('-3 month'));
        //查询数据
        $sql = "select DATE_FORMAT(created_at,'%Y-%m') as date ,count(*) as num from orders where date(created_at)  BETWEEN '{$startTime}' and '{$endTime}' group by DATE_FORMAT(created_at,'%Y-%m')";
        $rows = DB::select($sql);
        //构建对应数据格式
        for($i=0;$i<3;$i++){
            $data[date('Y-m',strtotime("-$i month"))] = 0;
        }

        foreach ($rows as $row){
            $data[$row->date] = $row->num;
        }

        return $data;
    }

    //平台一周的订单总量（按商家）
    public function weekShopsAll(){

        //时间区间
        $endTime = date('Y-m-d');
        $startTime= date('Y-m-d',strtotime('-6 day'));
        //查询数据
        $sql = "select date(orders.created_at) as date ,count(orders.id) as num,GROUP_CONCAT(shops.shop_name) as name from orders join shops on orders.shop_id = shops.id where date(orders.created_at)  BETWEEN '{$startTime}' and'{$endTime }' group by date(orders.created_at),orders.shop_id";
        $rows = DB::select($sql);

        $name = [];
        foreach($rows as $row){
            $name = explode(',',$row->name);
            $row->name = $name[0];
        }

        $date = [];
        for($i=0;$i<7;$i++){
            $date[date('Y-m-d',strtotime("-$i day"))] = 0;
        }
        foreach($rows as $row){
            $data[$row->name] = $date;
        }
        foreach($rows as $row){
            $data[$row->name][$row->date] = $row->num;
        }

        return $data;
    }

    //平台近三月的订单总量（按商家）
    public function monthShopsAll(){

        //时间区间
        //时间区间
        $endTime = date('Y-m-d');
        $startTime= date('Y-m-d',strtotime('-3 month'));
        //查询数据
        $sql = "select DATE_FORMAT(orders.created_at,'%Y-%m') as date ,count(orders.id) as num,GROUP_CONCAT(shops.shop_name) as name from orders join shops on orders.shop_id = shops.id where date(orders.created_at)  BETWEEN '{$startTime}' and'{$endTime }' group by DATE_FORMAT(orders.created_at,'%Y-%m'),orders.shop_id";
        $rows = DB::select($sql);

        $name = [];
        foreach($rows as $row){
            $name = explode(',',$row->name);
            $row->name = $name[0];
        }

        $date = [];
        for($i=0;$i<3;$i++){
            $date[date('Y-m',strtotime("-$i month"))] = 0;
        }
        foreach($rows as $row){
            $data[$row->name] = $date;
        }
        foreach($rows as $row){
            $data[$row->name][$row->date] = $row->num;
        }

        return $data;
    }

}
