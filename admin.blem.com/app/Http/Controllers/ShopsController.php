<?php

namespace App\Http\Controllers;

use App\Models\ShopCategories;
use App\Models\Shops;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ShopsController extends Controller
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
    public function index(Request $request)
    {
        $rows = Shops::paginate(5);//获取分页数据

        if($keyword = $request->keyword){
            $rows = Shops::where('shop_name','like',"%{$keyword}%")->paginate(5);//获取查询分页数据
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
                'shop_img' => 'required',//商家图片
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

        //验证通过，上传商家信息数据至数据库
        DB::beginTransaction();//开启事务
        //先向shops表添加商家信息
        try{
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
                    'shop_img' => $request->shop_img,
                    'status' => 1,//默认为1，管理员添加商户，默认正常
                ]
            );
            //向商家用户表写入信息
            Users::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 1,//管理员添加默认为1，启用
                'shop_id' => $result1->id,
            ]);
            DB::commit();//正确，提交数据
        }catch (\Exception $e){
            DB::rollBack();//出错，取消事务提交（回滚）
            return redirect()->back()->with('danger','添加商家出错！');
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
                'start_send' => 'required',//起送金额不能为空
                'send_cost' => 'required',//配送费不能为空
                'notice' => 'required',//店铺公告不能为空
                'discount' => 'required',//优惠信息不能为空

            ],
            [
                //商家信息数据验证
                'shop_name.required' => '商家名称不能为空',
                'start_send.required' => '起送金额不能为空',
                'send_cost.required' => '配送费不能为空',
                'notice.required' => '店铺公告不能为空',
                'discount.required' => '优惠信息不能为空',

            ]);

        //验证通过，上传图片到服务器，并获取上传后的图片路径
        $path = $shop->shop_img;//获取原始图片路径
        if($request->shop_img){
            $path = $request->shop_img;
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
        $result = DB::transaction(function ( ) use($shop) {
            Users::destroy('shop_id',$shop->id);

            $shop->delete();//删除商家分类数据
        });

        //删除功能完成，跳转页面并给出提示信息
        return back()->with('success','删除商家分类成功！');
    }

    //商家状态功能
    public function status(Shops $shop){
//        return $shop;
        if($shop->status == 0){
            $status = 1;//如果该商家还未通过审核，就更新为启用

            //发送邮件
            $title = '恭喜！您的店铺已经审核成功！';
            $content = '您的店铺在'.date("Y-m-d H:i:s").'已经通过审核，可以进行正常的使用！';
            try{
                \Illuminate\Support\Facades\Mail::send('Email.index',compact('title','content'),
                    function($message) use($shop) {
                        $to = $shop->users->email;
                        $message->from(env('MAIL_USERNAME'))->to($to)->subject('您的店铺已经审核成功！');
                    });
            }catch (Exception $e){
                return '邮件发送失败';
            }


            $info = 'success';
            $str = '商家审核成功！';

            //发送邮件
        }

        if($shop->status == 1){
            $status = -1;//如果该商家已启用，更新为禁用
            $info = 'warning';
            $str = '商家已禁用！';
        }
        if($shop->status == -1){
            $status = 1;//如果该商家为禁用的话，更新为启用
            $info = 'success';
            $str = '商家启用成功！';
        }

        //更新
        $shop->status = $status;
        $shop->save();

        //更新成功，跳转页面，给出提示
        return redirect()->route('shops.index')->with($info,$str);
    }
}
