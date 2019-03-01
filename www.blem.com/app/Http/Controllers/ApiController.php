<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Carts;
use App\Models\Member;
use App\Models\Menu;
use App\Models\MenuCategories;
use App\Models\Shops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Qcloud\Sms\SmsSingleSender;

class ApiController extends Controller
{
    //响应头，OCAO跨域
    public function __construct()
    {
        header('Access-Control-Allow-Origin:*');

    }

    //商家列表接口(支持商家搜索)
    public function businessList(Request $request){

        //如果有参数keyword就模糊查询
        if($keyword = $request->keyword){
            $rows = Shops::select(
                'id',
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
                'notice'
            )
                ->where('shop_name','like',"%$keyword%")
                ->where('status',1)
                ->get();
        }else{
            $rows = Shops::where('status',1)->get();//只能获取状态正常的商家
        }

        //返回数据
        return $rows;
    }

    //获得指定商家接口
    public function business(Request $request){
        //商家信息数据
        $shop = Shops::select(
            'id',
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
            'notice'
        )
            ->find($request->id);

        //评论数据
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
        ];

        //获取商家菜品分类数据
        $shop['commodity'] = MenuCategories::select(
            'description',
            'is_selected',
            'name',
            'type_accumulation',
            'id'
        )
            ->where('shop_id',$request->id)
            ->get();

        //获取对应菜品分类下的菜品
        foreach($shop['commodity'] as $row){
            $row['goods_list'] = Menu::select('id','goods_name','rating','goods_price','description','month_sales','rating_count',
                'tips','satisfy_count','satisfy_rate','goods_img')
                ->where('category_id',$row->id)
                ->where('status',1)
                ->get();//只能获取状态正常的菜品

            //将商品的id键值替换为goods_id
            foreach ($row['goods_list'] as $good){
                unset($good['id']);
                $good['goods_id'] = $good->id;
            }
        }


        return $shop;
    }

    //会员注册接口
    public function regist(Request $request){

        //验证数据格式
        $validator = Validator::make($request->all(),
            [
               'username' => 'required',//用户名不能为空
                'password' => 'required',//密码不能为空
                'tel' => 'required|numeric|digits_between:11,11',//电话号码格式
                'sms' => 'required|numeric|digits_between:4,4',//验证码格式
            ],[
                'username.required' => '用户名不能为空',
                'password.required' => '密码不能为空',
                'tel.required' => '电话号码不能为空',
                'tel.numeric' => '电话号码只能为数字',
                'tel.digits_between' => '电话号码格式不对',
                'sms.required' => '验证码不能为空',
                'sms.numeric' => '验证码只能为数字',
                'sms.digits_between' => '验证码格式不对',
            ]);

        if($validator->fails()){
            return [
                'status' => 'false',
                'message' => implode(' ',$validator->errors()->all()),
            ];
        }

//        exit;

        //验证用户名存不存在
        if(empty(Member::where('username',$request->username)->get())){
            return ['status' => 'false','message' => '该用户名已存在，请重新填写.'];
        }

        //验证手机号码
        if(empty(Member::where('tel',$request->tel)->get())){
            return ['status' => 'false','message' => '该手机号已被注册，请重新填写.'];
        }

        //判断手机验证码是否正确
        if($request->sms != Redis::get($request->tel)){
            return ['status' => 'false','message' => '验证码错误，请从新获取'];
        }

        //添加会员
        Member::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'tel' => $request->tel,
        ]);

        //注册成功，删除redis中的验证
        Redis::del($request->tel);

        //注册成功
        return ['status' => 'true','message' => '注册成功'];
    }

    //短信验证码接口
    public function sms(Request $request){
        //判断是否应当发送验证码短信
        if(Redis::get($request->tel) && Redis::ttl($request->tel) > 240){
            //获取验证码失败
            return ['status'=>'false','message' => '请'.(Redis::ttl($request->tel) - 240).'秒后再次获取验证码。'];
        }

        // 短信应用SDK AppID
        $appid = 1400189795; // 1400开头

        // 短信应用SDK AppKey
        $appkey = "f0f379ddda7c39e41088a3881b20cb35";

        // 需要发送短信的手机号码
        $phoneNumber = $request->tel;

        // 短信模板ID，需要在短信应用中申请
        $templateId = 285192;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请

        $smsSign = "firstyun"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`

        try {
            $ssender = new SmsSingleSender($appid, $appkey);
            $params = [mt_rand(1000,9999),5];//验证码,分钟

            //发送短信
            $result = $ssender->sendWithParam(
                "86",
                $phoneNumber,
                $templateId,
                $params,
                $smsSign,
                "",
                ""
            );  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp = json_decode($result);

            //判断短信是否发送成功
            if($rsp->errmsg == 'OK'){
                //将验证码写入redis [手机号  = 》  验证码],并设置过期时间5分钟
                Redis::setex($phoneNumber,300,$params[0]);
            }
        } catch(\Exception $e) {
            echo var_dump($e);

            //获取验证码失败
            return ['status'=>'false','message' => '获取验证码失败'];
        }
        //获取验证码成功
        return ['status'=>'true','message' => '获取验证码成功'];
    }

    //用户登录接口
    public function login(Request $request){

        //验证表单数据
       $validator =  Validator::make($request->all(),[
            'name' => 'required',
            'password' => 'required',
        ],[
            'name.required' => '用户名不能为空',
            'password' => '密码不能为空'
       ]);

       //返回表单数据错误
       if($validator->fails()){
           return [
               'status' => 'false',
               'message' => implode(' ',$validator->errors()->all())
           ];
       }

       //检查登录
        if(Auth::attempt([
            //验证，账号和用户名
            'username' => $request->name,
            'password' => $request->password,
        ])){
            //登录成功
            return ['status' => 'true','message' => '登录成功','user_id' => Auth::user()->id,'username' => Auth::user()->username];
        }

        //登录失败
        return ['status' => 'false','message' => '账号或用户名错误，登录失败！'];

    }

    //保存新增地址接口
    public function addAddress(Request $request){

        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'tel' => 'required|numeric|digits_between:11,11',//电话号码格式
                'provence' => 'required',
                'city' => 'required',
                'area' => 'required',
                'detail_address' => 'required'
            ],[
                'name.required' => '用户名不能为空',
                'tel.required' => '电话号码不能为空',
                'tel.numeric' => '电话号码只能为数字',
                'tel.digits_between' => '电话号码格式不对',
                'provence.required' => '省份不能为空',
                'city.required' => '市级不能为空',
                'area.required' => '县级不能为空',
                'detail_address.required' => '详细地址不能为空',
            ]);

        if($validator->fails()){
            return ['status' => 'false','message' => implode(' ',$validator->errors()->all()),];
        }

        //验证通过，写入数据表
        Address::create([
            'user_id' => Auth::user()->id,
            'province' => $request->provence,
            'city' => $request->city,
            'area' => $request->area,
            'detail_address' => $request->detail_address,
            'tel' => $request->tel,
            'name' => $request->name,
            'is_default' => 0,
        ]);

        return ['status' => 'true','message' => '新增地址成功'];

    }

    //指定地址接口列表
    public function address(Request $request){
        $address = Address::select('id','province','city','area','detail_address','name','tel')->where('id',$request->id)->first();
        $address['provence'] = $address->province;
        return $address;
    }

    //地址接口列表
    public function addressList(){
        $address = Address::select('id','province','city','area','detail_address','name','tel')->where('user_id',Auth::user()->id)->get();
        foreach ($address as $row){
            $row['provence'] = $row->province;
        }

        return $address;
    }

    //修改指定地址接口
    public function editAddress(Request $request){

        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'tel' => 'required|numeric|digits_between:11,11',//电话号码格式
                'provence' => 'required',
                'city' => 'required',
                'area' => 'required',
                'detail_address' => 'required'
            ],[
                'name.required' => '用户名不能为空',
                'tel.required' => '电话号码不能为空',
                'tel.numeric' => '电话号码只能为数字',
                'tel.digits_between' => '电话号码格式不对',
                'provence.required' => '省份不能为空',
                'city.required' => '市级不能为空',
                'area.required' => '县级不能为空',
                'detail_address.required' => '详细地址不能为空',
            ]);

        if($validator->fails()){
            return ['status' => 'false','message' => implode(' ',$validator->errors()->all()),];
        }

        //验证通过,修改信息
        Address::where('id',$request->id)->update([
            'province' => $request->provence,
            'city' => $request->city,
            'area' => $request->area,
            'detail_address' => $request->detail_address,
            'tel' => $request->tel,
            'name' => $request->name,
            'is_default' => 0,
        ]);

        return ['status' => 'true','message' => '修改地址成功'];

    }

    //保存购物车接口
    public function addCart(Request $request){

        //变量选择的商品ID和数量（商品ID与商品数量一一对应）
       for($i=0;$i<count($request->goodsList);$i++){

           //判断购物车里有没有一样的商品，如果有就修改数量，如果没有就添加
           if(!empty(
               $row = Carts::where('goods_id',$request->goodsList[$i])
                    ->where('user_id',Auth::user()
                    ->id)->first())
           ){
               //修改商品数量
                Carts::where('goods_id',$request->goodsList[$i])
                    ->update([
                        'amount' => $row->amount + $request->goodsCount[$i]
                    ]);

           }else{
               //添加商品到购物车
               Carts::create([
                   'user_id' => Auth::user()->id,
                   'goods_id' => $request->goodsList[$i],
                   'amount' => $request->goodsCount[$i],
               ]);

           }
        }

        //添加成功
        return ['status' => 'true','message' => '添加成功'];
    }

    //获取购物车列表接口
    public function cart(){

        //声明数组，用于保存返回数据
        $data = [];
        //购物车数据（当前登录用户）
        $carts = Carts::select('id','user_id','goods_id','amount')->where('user_id',Auth::user()->id)->get();
        //声明数组元素 totalCost 为总价格 0
        $data['totalCost'] = 0;
        //遍历购物车数据用商品ID来读取商品表中的商品数据
        foreach($carts as $cart){
            //购物车对应商品数据
            $goodsList = Menu::select('id','goods_name','goods_img','goods_price')->where('id',$cart->goods_id)->first();
            //获取对应返回值goods_id
            $goodsList['goods_id'] = $goodsList->id;
            //获取对应的商品数量
            $goodsList['amount'] = $cart->amount;
            //计算对应商品记录的价格
            $goodsList['goods_price'] = $cart->amount * $goodsList->goods_price;
            //删除多余元素id
            unset($goodsList['id']);
            //计算商品总价格
            $data['totalCost'] += $goodsList->goods_price;
            //将商品最终信息列入goods_list 下
            $data['goods_list'][] = $goodsList;
        }

        //返回最终购物车数据
        return $data;

    }

    //生成订单接口
    public function addorder(Request $request){
        return $request;
    }




}
