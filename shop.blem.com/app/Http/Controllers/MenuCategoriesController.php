<?php

namespace App\Http\Controllers;

use App\Models\MenuCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = MenuCategories::paginate(1);//获取分页数据

        if($keyword = $request->keyword){
            $rows = MenuCategories::where('name','like',"%{$keyword}%")->paginate(1);//获取查询分页数据
        }
        //菜品分类列表
        return view('Menus.index',compact('rows','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //添加表单页面
        return view('menus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //新增功能
        //验证表单数据格式
        $this->validate($request,
            [
                'name' => 'required',//名称
                'type_accumulation' => 'required|alpha',//菜品编号（a-z前端使用）
                'description' => 'required',//描述
            ],
            [
                'name.required' => '分类名称不能为空',
                'type_accumulation.required' => '菜品编号不能为空',
                'type_accumulation.alpha' => '菜品编号只能是字母',
                'description.required' => '描述不能为空',
            ]);

        //验证通过
        MenuCategories::create([
           'name' => $request->name,
           'type_accumulation' => $request->type_accumulation,
            'description' => $request->description,
            'shop_id' => Auth::user()->id,
            'is_selected' => $request->is_selected,
        ]);

        //添加成功
        return redirect()->route('menus.index')->with('success','新增菜品分类成功！');
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
    public function edit(MenuCategories $menu)
    {
        //更新表单页面
        return view('Menus.edit',compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuCategories $menu)
    {
        //验证表单数据格式
        $this->validate($request,
            [
                'name' => 'required',//名称
                'type_accumulation' => 'required|alpha',//菜品编号（a-z前端使用）
                'description' => 'required',//描述
            ],
            [
                'name.required' => '分类名称不能为空',
                'type_accumulation.required' => '菜品编号不能为空',
                'type_accumulation.alpha' => '菜品编号只能是字母',
                'description.required' => '描述不能为空',
            ]);

        //验证通过
        $menu->update([
            'name' => $request->name,
            'type_accumulation' => $request->type_accumulation,
            'description' => $request->description,
            'is_selected' => $request->is_selected,
        ]);

        //更新成功
        return redirect()->route('menus.index')->with('success','更新菜品分类成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuCategories $menu)
    {
        //删除
        $menu->delete();

        return redirect()->route('menus.index')->with('success','删除菜品分类成功！');
    }
}
