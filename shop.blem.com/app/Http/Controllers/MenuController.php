<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
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

        $data = ['id'=>$request->id];//生成查询条件参数
        //原始查询
        $rows = Menu::where('shop_id',Auth::user()->shop_id)
            ->where('category_id',$request->id);

        //如果有名称查询
        if($keyword = $request->keyword){

            //分词搜索
            $cl = new \App\SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);

            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
            $cl->SetMatchMode ( SPH_MATCH_EXTENDED2);
            $cl->SetLimits(0, 1000);
            $info = $keyword;
            $res = $cl->Query($info, 'menus');//shopstore_search
            if(isset($res['matches'])){
                $ids = [];
                foreach($res['matches'] as $row){
                    $ids[] = $row['id'];//获取所有id
                }

                $rows->whereIn('id',$ids);
            }else{
                $rows->where('goods_name','like',"%$keyword%");
            }


            $data['keyword'] = $request->keyword;//生成查询条件参数
        }
        //如果有最小
        if($min = $request->min){
            $this->validate($request,['min' => 'numeric',],['min.numeric' => '最低价格搜索请输入数字',]);//验证数据格式

            $rows->where('goods_price','>=',$min);

            $data['min'] = $request->min;//生成查询条件参数
        }
        //如果有最大
        if($max = $request->max){
            $this->validate($request,['max' => 'numeric',],['max.numeric' => '最高价格搜索请输入数字',]);//验证数据格式

            $rows->where('goods_price','<=',$max);

            $data['max'] = $request->max;//生成查询条件参数
        }
        //最后查询
        $rows = $rows->paginate(6);
        //菜品分类列表
        return view('Menu.index',compact('rows','data','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取所有菜品分类
        $rows = MenuCategories::all()->where('shop_id',Auth::user()->shop_id);
        //添加表单页面
        return view('menu.create',compact('rows'));
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
                'goods_name' => 'required',//名称
                'rating' => 'required|numeric',//评分
                'goods_price' => 'required|numeric',//价格
                'tips' => 'required',//提示信息
                'goods_img' => 'required',//图片
                'description' => 'required',//描述
            ],
            [
                'goods_name.required' => '菜品名称不能为空',
                'goods_img.required' => '图片不能为空',
                'rating.required' => '评分不能为空',
                'rating.numeric' => '评分只能为数字',
                'goods_price.required' => '菜品价格不能为空',
                'goods_price.numeric' => '菜品价格只能为数字',
                'tips.required' => '提示信息不能为空',
                'description.required' => '描述不能为空',
            ]);

        //验证通过
        Menu::create([
            'goods_name' => $request->goods_name,
            'rating' => $request->rating,
            'shop_id' => Auth::user()->shop_id,
            'category_id' => $request->category_id,
            'goods_price' => $request->goods_price,
            'description' => $request->description,
            'month_sales' => 0,
            'rating_count' => 0,
            'tips' => $request->tips,
            'satisfy_count' => 0,
            'satisfy_rate' => 0,
            'goods_img' => $request->goods_img,
            'status' => $request->status,
        ]);

        //添加成功
        return redirect()->route('menu.index',['id'=>$request->category_id])->with('success','新增菜品成功！');
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
    public function edit(Menu $menu)
    {
        //获取所有菜品分类
        $rows = MenuCategories::all();
        //更新表单页面
        return view('Menu.edit',compact('menu','rows'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //验证表单数据格式
        $this->validate($request,
            [
                'goods_name' => 'required',//名称
                'rating' => 'required|numeric',//评分
                'goods_price' => 'required|numeric',//价格
                'tips' => 'required',//提示信息
                'description' => 'required',//描述
            ],
            [
                'goods_name.required' => '菜品名称不能为空',
                'rating.required' => '评分不能为空',
                'rating.numeric' => '评分只能为数字',
                'goods_price.required' => '菜品价格不能为空',
                'goods_price.numeric' => '菜品价格只能为数字',
                'tips.required' => '提示信息不能为空',
                'description.required' => '描述不能为空',
            ]);

        $path = $menu->goods_img;
        if($request->goods_img){
            $path = $request->goods_img;
        }

        //验证通过
        $menu->update([
            'goods_name' => $request->goods_name,
            'rating' => $request->rating,
            'category_id' => $request->category_id,
            'goods_price' => $request->goods_price,
            'description' => $request->description,
            'tips' => $request->tips,
            'goods_img' => $path,
            'status' => $request->status,
        ]);

        //添加成功
        return redirect()->route('menu.index',['id'=>$request->category_id])->with('success','更新菜品成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {

        //删除
        $menu->delete();

        return redirect()->back('menu.index')->with('success','删除菜品成功！');
    }

    public function status(Menu $menu){
        //默认为启用
        $status = 1;
        $str = '启用成功';

        if($menu->status){//禁用
            $status = 0;
            $str = '禁用成功';
        }

        //修改状态数据
        $menu->update([
            'status' => $status,
        ]);

        return redirect()->route('menu.index',['id'=>$menu->category_id])->with('success',$str);

    }

    //接收上传文件
    public function autoFile(Request $request){
        return ["path"=>Storage::url($request->file('file')->store('public/ShopImages'))];
    }

    //批量删除
    public function moreDel(Request $request){

        $ids = explode(',',$request->ids);
        Menu::whereIn('id',$ids)->delete();
        return back()->with('success','批量删除成功！');
    }
}
