<?php

namespace App\Http\Controllers;

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
        //商家个人中心
        return view('User.index');
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
