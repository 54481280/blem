<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\ShopCategories;
use App\Models\Shops;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //声明数组保存查询数据
        $data = [];

        //查询累计订单数量
        $orderNum = Order::where('shop_id',Auth::user()->shop_id)->count();

        //查询成功的订单数量
        $successOrderNum = Order::where('shop_id',Auth::user()->shop_id)->where('status',3)->count();

        //查询累计销售商品数量
        $goodsNum = DB::select('select sum(a.amount) as num from orders as o join (select order_id,sum(amount) as amount from order_details GROUP BY order_id) as a on o.id = a.order_id where o.shop_id = ?',[Auth::user()->shop_id]);
        $goodsNum = $goodsNum[0]->num;

        //查询累计收益金额
        $money = Order::where('shop_id',Auth::user()->shop_id)->where('status',3)->sum('total');

        $data['orderNum'] = $orderNum;
        $data['successOrderNum'] = $successOrderNum;
        $data['goodsNum'] = $goodsNum;
        $data['money'] = $money;

        $data['week'] = $this->week();//获取最近一周的订单量
        $data['month']  = $this->month();//获取最近三月的订单量
        //最近一周菜品销量
        $data['menuWeek'] = $this->menuWeek();
        $data['menuMonth'] = $this->menuMonth();
//        dd($data['menuWeek']);
        //商家个人中心
        return view('User.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取所有商家分类数据
        $rows = ShopCategories::all();
        //商家注册表单
        return view('User.create',compact('rows'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //验证表单数据格式
        $this->validate($request,
            [
                //商家信息数据验证
                'shop_name' => 'required',//商家名称
                'shop_img' => 'required|image|max:2048',//商家图片
                'shop_rating'=> 'required|numeric',
                'start_send' => 'required',//起送金额不能为空
                'send_cost' => 'required',//配送费不能为空
                'notice' => 'required',//店铺公告不能为空
                'discount' => 'required',//优惠信息不能为空

                //商家账号数据验证
                'name' => 'required',//商家名称不能为空
                'email' => 'required|email',//邮箱
                'password' => 'required',//密码不能为空
                'password2' => 'required|same:password',//重复密码不能为空且要相同

            ],
            [
                //商家信息数据验证
                'shop_name.required' => '商家名称不能为空',
                'shop_img.required' => '请上传商家分类图片',
                'shop_img.image' => '请上传正确格式的图片',
                'shop_img.max' => '请上传的图片大小不超过2M',
                'shop_rating.required' => '评分不能为空',
                'shop_rating.numeric' => '评分只能为数字',
                'start_send.required' => '起送金额不能为空',
                'send_cost.required' => '配送费不能为空',
                'notice.required' => '店铺公告不能为空',
                'discount.required' => '优惠信息不能为空',

                //商家账号信息验证
                'name.required' => '商家账号不能为空',
                'email.required' => '商家邮箱不能为空',
                'email.email' => '商家邮箱格式不正确',
                'password.required' => '商家密码不能为空',
                'password2.required' => '商家重复密码不能为空',
                'password2.same' => '两次密码不一致，请重新输入',
            ]);

        //验证通过，上传图片到服务器，并获取上传后的图片路径
        $path = Storage::url($request->file('shop_img')->store('public/ShopImages'));

        //验证通过，上传商家信息数据至数据库
        DB::beginTransaction();//开启事务

        //先向shops表添加商家信息
        $result1 = Shops::create(
            [
                'shop_category_id' => $request->shop_category_id,
                'shop_name' => $request->shop_name,
                'shop_rating' => $request->shop_rating,
                'brand' => $request->brand,
                'on_time' => $request->on_time,
                'fengniao' => $request->fengniao,
                'bao' => $request->bao,
                'piao' => $request->piao,
                'zhun' => $request->zhun,
                'start_send' => $request->start_send,
                'send_cost' => $request->send_cost,
                'notice' => $request->notice,
                'discount' => $request->discount,
                'shop_img' => $path,
                'status' => 0,//默认为0，商家注册，需管理员审核
            ]
        );

        //向商家用户表写入信息
        $result2 = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1,//默认为1，启用
            'shop_id' => $result1->id,
        ]);

        if($result1 && $result2){
            DB::commit();//正确，提交数据
        } else{
            DB::rollBack();//出错，取消事务提交（回滚）
        }

        //添加商家功能完成，跳转页面并给出提示信息
        return redirect()->route('login')->with('success','注册商家成功！待管理员审核。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        //商家个人中心
        return view('User.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        //验证表单数据
        $this->validate($request,
            [
                'oldPwd' => 'required',
                'password' => 'required',
                'password2' => 'required|same:password',
                'captcha' => 'required|captcha',
            ],[
                'oldPwd.required' => '原始密码不能为空',
                'password.required' => '新密码不能为空',
                'password2.required' => '原始密码不能为空',
                'password2.same' => '两次密码输入不一致，请重新输入',
                'captcha.required' => '验证码不能为空',
                'captcha.captcha' => '验证码输入错误',
            ]);

        //验证原始密码是否正确
        if(Hash::check($request->oldPwd,$user->password)){
            //密码相同
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }else{
            return back()->with('danger','原始密码输入错误');
        }

        //修改密码成功
        return redirect()->route('user.index')->with('success','修改个人密码成功！');
    }

    //查询最近一周的订单量
    public function week(){
        //声明数组保存一周的数据
        $week = [];
        for($i=0;$i<=6;$i++){
            $date = date('Y-m-d',strtotime("-$i day"));
            $week[$date] = Order::where('created_at','like',"$date%")->where('shop_id',Auth::user()->shop_id)->count();
        }
        return $week;
    }

    //最近三月订单量统计
    public function month(){
        //声明数组保存一周的数据
        $month = [];
        for($i=0;$i<=2;$i++){
            $date = date('Y-m',strtotime("-$i month"));
            $month[$date] = Order::where('created_at','like',"$date%")->where('shop_id',Auth::user()->shop_id)->count();
        }
        return $month;
    }

    //最近一周菜品销量统计
    public function menuWeek(){
        $menuWeek = [];//保存查询到的数据
        $data = [];//用于保存返回的最终数据
        for($i=0;$i<=6;$i++){
            $date = date('Y-m-d',strtotime("-$i day"));
            $menuWeek[$date] = DB::select('select goods_id,sum(amount) as num from order_details join menus on order_details.goods_id = menus.id where menus.shop_id = ? and order_details.created_at like ? GROUP BY goods_id ',[Auth::user()->shop_id,"$date%"]);
            foreach ($menuWeek[$date] as $row){//
                $row->goods_name = Menu::select('goods_name')->find($row->goods_id)->toArray()['goods_name'];
                unset($row->goods_id);
            }
        }
        $str = [];
        foreach($menuWeek as $menu){
            foreach($menu as $m){
                $str[] = $m->goods_name;
            }
        }
        foreach ($str as $row){
            $data[$row] = array_keys($menuWeek);
            $data[$row] = array_flip($data[$row]);
        }
        foreach($data as $rowK => &$rowV){
            foreach($rowV as $k => &$v){
                foreach($menuWeek[$k] as $m){
                    if($m->goods_name == $rowK){
                        $v = $m->num;
                    }
                }
            }
        }
        foreach($data as &$row){
            foreach($row as &$r){
                if(gettype($r) == 'integer'){
                    $r = '0';
                }
            }
        }
        return $data;
    }
    //最近三月菜品销量统计
    public function menuMonth(){
        $menuWeek = [];
        $data = [];
        for($i=0;$i<=2;$i++){
            $date = date('Y-m',strtotime("-$i month"));
            $menuWeek[$date] = DB::select('select goods_id,sum(amount) as num from order_details join menus on order_details.goods_id = menus.id where menus.shop_id = ? and order_details.created_at like ? GROUP BY goods_id ',[Auth::user()->shop_id,"$date%"]);
            foreach ($menuWeek[$date] as $row){
                $row->goods_name = Menu::select('goods_name')->find($row->goods_id)->toArray()['goods_name'];
                unset($row->goods_id);
            }
        }
        $str = [];
        foreach($menuWeek as $menu){
            foreach($menu as $m){
                $str[] = $m->goods_name;
            }
        }
        foreach ($str as $row){
            $data[$row] = array_keys($menuWeek);
            $data[$row] = array_flip($data[$row]);
        }
        foreach($data as $rowK => &$rowV){
            foreach($rowV as $k => &$v){
                foreach($menuWeek[$k] as $m){
                    if($m->goods_name == $rowK){
                        $v = $m->num;
                    }
                }
            }
        }
        foreach($data as &$row){
            foreach($row as &$r){
                if(gettype($r) == 'integer'){
                    $r = '0';
                }
            }
        }
        return $data;
    }

}
