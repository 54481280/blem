<?php

namespace App\Http\Controllers;

use App\Models\ShopCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = ShopCategories::paginate(2);//获取分页数据

        if($keyword = $request->keyword){
            $rows = ShopCategories::where('name','like',"%{$keyword}%")->paginate(1);//获取查询分页数据
        }

        return view('Cate.index',compact('rows','keyword'));//返回页面及数据
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //返回添加商家分类表单
        return view('Cate.create');
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
                'name' => 'required',
                'img' => 'required|image|max:2048',
            ],
            [
                'name.required' => '商家分类名称不能为空',
                'img.required' => '请上传商家分类图片',
                'img.image' => '请上传正确格式的图片',
                'img.max' => '请上传的图片大小不超过2M',
            ]);

        //验证通过，上传图片到服务器，并获取上传后的图片路径
        $path = $request->file('img')->store('public/CateImages');

        //验证通过，上传数据至数据库
        ShopCategories::create(
            [
                'name' => $request->name,
                'img' => $path,
                'status' => 0,//默认为0，隐藏商家分类
            ]
        );

        //添加商家分类功能完成，跳转页面并给出提示信息
        return redirect()->route('shop.index')->with('success','添加商家分类成功！');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopCategories $shop)
    {
        //编辑商家分类表单
        return view('Cate.edit',compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopCategories $shop,Request $request)
    {
        //验证表单数据格式
        $this->validate($request,
            [
                'name' => 'required',
                'img' => 'image|max:2048',
            ],
            [
                'name.required' => '商家分类名称不能为空!',
                'img.image' => '请上传正确格式的图片!',
                'img.max' => '请上传的图片大小不超过2M!',
            ]);

        //验证通过，上传图片到服务器，并获取上传后的图片路径
        $path = $shop->img;//获取原始图片路径
        if($img = $request->file('img')){
            Storage::delete($shop->img);//删除原始图片
            $path = $img->store('public/CateImages');
        }

        //验证通过，上传数据至数据库
        $shop->update(
            [
                'name' => $request->name,
                'img' => $path,
            ]
        );

        //编辑商家分类功能完成，跳转页面并给出提示信息
        return redirect()->route('shop.index')->with('success','编辑商家分类成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopCategories $shop)
    {
        //删除商家分类数据
        Storage::delete($shop->img);//删除图片
        $shop->delete();//删除商家分类数据

        //删除功能完成，跳转页面并给出提示信息
        return redirect()->route('shop.index')->with('success','删除商家分类成功！');
    }
}
