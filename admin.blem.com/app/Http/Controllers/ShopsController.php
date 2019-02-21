<?php

namespace App\Http\Controllers;

use App\Models\ShopCategories;
use App\Models\Shops;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = Shops::paginate(2);//获取分页数据

        if($keyword = $request->keyword){
            $rows = Shops::where('shop_name','like',"%{$keyword}%")->paginate(1);//获取查询分页数据
        }

        return view('Shops.index',compact('rows','keyword'));//返回页面及数据
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取商家分类数据
        $rows = ShopCategories::all();
        //返回添加商家信息表单
        return view('Shops.create',compact('rows'));
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
        $path = $request->file('shop_img')->store('public/ShopImages');

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
                'status' => 1,//默认为1，管理员添加商户，默认正常
            ]
        );

        //向商家用户表写入信息
        $result2 = Users::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1,//管理员添加默认为1，启用
            'shop_id' => $result1->id,
        ]);

        if($result1 && $result2){
            DB::commit();//正确，提交数据
        } else{
            DB::rollBack();//出错，取消事务提交（回滚）
        }

        //添加商家功能完成，跳转页面并给出提示信息
        return redirect()->route('shops.index')->with('success','添加商家成功！');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Shops $shop)
    {
        //返回详情页面
        return view('Shops.show',compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Shops $shop)
    {
        //获取商家分类数据
        $rows = ShopCategories::all();
        //编辑商家分类表单
        return view('Shops.edit',compact('shop','rows'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Shops $shop,Request $request)
    {
        //验证表单数据格式
        $this->validate($request,
            [
                //商家信息数据验证
                'shop_name' => 'required',//商家名称
                'shop_img' => 'image|max:2048',//商家图片
                'start_send' => 'required',//起送金额不能为空
                'send_cost' => 'required',//配送费不能为空
                'notice' => 'required',//店铺公告不能为空
                'discount' => 'required',//优惠信息不能为空

            ],
            [
                //商家信息数据验证
                'shop_name.required' => '商家名称不能为空',
                'shop_img.image' => '请上传正确格式的图片',
                'shop_img.max' => '请上传的图片大小不超过2M',
                'start_send.required' => '起送金额不能为空',
                'send_cost.required' => '配送费不能为空',
                'notice.required' => '店铺公告不能为空',
                'discount.required' => '优惠信息不能为空',

            ]);

        //验证通过，上传图片到服务器，并获取上传后的图片路径
        $path = $shop->shop_img;//获取原始图片路径
        if($img = $request->file('shop_img')){
            Storage::delete($shop->shop_img);//删除原始图片
            $path = $img->store('public/ShopImages');
        }

        //向shops表更新商家信息
        $shop->update(
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
                'status' => 1,//默认为1，管理员添加商户，默认正常
            ]
        );

        //编辑商家信息功能完成，跳转页面并给出提示信息
        return redirect()->route('shops.index')->with('success','更新商家成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shops $shop)
    {
        //删除商家分类数据
        Storage::delete($shop->shop_img);//删除图片
        $shop->delete();//删除商家分类数据

        //删除功能完成，跳转页面并给出提示信息
        return redirect()->route('shop.index')->with('success','删除商家分类成功！');
    }
}
