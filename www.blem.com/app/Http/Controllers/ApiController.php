<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuCategories;
use App\Models\Shops;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin:*');

    }

    //商家列表接口(支持商家搜索)
    public function businessList(Request $request){
        $rows = Shops::all();

        //如果有参数keyword就模糊查询
        if($keyword = $request->keyword){
            $rows = Shops::where('shop_name','like',"%$keyword%")->get();
        }

        //返回数据
        return $rows;
    }

    //获得指定商家接口
    public function business(Request $request){


        $shop = Shops::find($request->id);//商家信息数据
        $shop['evaluate']=[
            [
                "user_id"=>12344,
                "username"=>"w******k",
                "user_img"=>"/images/slider-pic4.jpeg",
                "time"=>"2017-2-22",
                "evaluate_code"=>1,
                "send_time"=>30,
                "evaluate_details"=>"不怎么好吃"
            ],
            [
                "user_id"=>12344,
                "username"=>"w******k",
                "user_img"=>"/images/slider-pic4.jpeg",
                "time"=>"2017-2-22",
                "evaluate_code"=>4.5,
                "send_time"=>30,
                "evaluate_details"=>"很好吃"
            ],
            [
                "user_id"=>12344,
                "username"=>"w******k",
                "user_img"=>"/images/slider-pic4.jpeg",
                "time"=>"2017-2-22",
                "evaluate_code"=>5,
                "send_time"=>30,
                "evaluate_details"=>"很好吃"
            ],
            [
                "user_id"=>12344,
                "username"=>"w******k",
                "user_img"=>"/images/slider-pic4.jpeg",
                "time"=>"2017-2-22",
                "evaluate_code"=>4.7,
                "send_time"=>30,
                "evaluate_details"=>"很好吃"
            ],
            [
                "user_id"=>12344,
                "username"=>"w******k",
                "user_img"=>"/images/slider-pic4.jpeg",
                "time"=>"2017-2-22",
                "evaluate_code"=>5,
                "send_time"=>30,
                "evaluate_details"=>"很好吃"
            ]
        ];//评论数据
        $shop['commodity'] = MenuCategories::where('shop_id',$request->id)->get();//获取商家菜品分类数据
        foreach($shop['commodity'] as $row){
            $row['goods_list'] = Menu::where('category_id',$row->id)->get();
        }

        return $shop;
    }
}
