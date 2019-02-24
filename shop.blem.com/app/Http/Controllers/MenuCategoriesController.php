<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuCategoriesController extends Controller
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
        $rows = MenuCategories::where('shop_id',Auth::user()->id)->paginate(6);//获取分页数据

        if($keyword = $request->keyword){
            $rows = MenuCategories::where('name','like',"%{$keyword}%")->paginate(6);//获取查询分页数据
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
                'description' => 'required',//描述
            ],
            [
                'name.required' => '分类名称不能为空',
                'description.required' => '描述不能为空',
            ]);

        //查询当前所有分类的默认情况
        if($request->is_selected){
            $this->cate();//将所有分类改为0
        }
        //验证通过
        MenuCategories::create([
           'name' => $request->name,
           'type_accumulation' => $this->strShuffle(),
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
                'description' => 'required',//描述
            ],
            [
                'name.required' => '分类名称不能为空',
                'description.required' => '描述不能为空',
            ]);

        //查询当前所有分类的默认情况
        if($request->is_selected){
            $this->cate();//将所有分类改为0
        }

        //验证通过
        $menu->update([
            'name' => $request->name,
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
        if( Menu::where('category_id',$menu->id)->first() ){
            return back()->with('danger','该分类下还拥有菜品，不能进行删除！');
        }
        //删除
        $menu->delete();

        return redirect()->back()->with('success','删除菜品分类成功！');
    }



    //只能有一个默认分类(将所有分类的默认修改为否)
    protected function cate(){
       DB::update('update menu_categories set is_selected = 0 where shop_id = ?',[Auth::user()->id]);
    }

    //更好随机5位字符
    protected function strShuffle(){
        $str = 'qwertyuiopasdfghjklzxcvbnm';//字符集合
        $str = str_shuffle($str);//随机打乱
        return str_random(5,$str);//返回前5位
    }
}
