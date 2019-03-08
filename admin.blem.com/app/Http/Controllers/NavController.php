<?php

namespace App\Http\Controllers;

use App\Models\Nav;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class NavController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //菜单列表
        if($keyword = $request->keyword){
            $rows = Nav::where('name','like',"%$keyword%")->paginate(5);
        }else{
            $rows = Nav::paginate(5);
        }

        return view('Nav.index',compact('rows','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取所有权限
        $permissions = Permission::all();
        //获取一级菜单
        $rows = Nav::where('pid',0)->get();
        //添加菜单表单
        return view('Nav.create',compact('rows','permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //添加功能
        $this->validate($request,[//验证数据
            'name' => 'required',
            'url' => 'required',
            'pid' => 'required',
            'permission_id' => 'required'
        ],[
            'name.required' => '菜单名称不能为空',
            'url.required' => '权限地址不能为空',
            'pid.required' => '上级菜单不能为空',
            'permission_id.required' => '对应权限不能为空',
        ]);

        //验证是否已存在该菜单

        //验证通过
        Nav::create([
            'name' => $request->name,
            'url' => $request->url,
            'permission_id' => $request->permission_id,
            'pid' => $request->pid,
            'span' => ''
        ]);

        return redirect()->route('nav.index')->with('success','添加菜单成功');

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
    public function edit(Nav $nav)
    {
        //获取所有权限
        $permissions = Permission::all();
        //获取一级菜单
        $rows = Nav::where('pid',0)->get();
        //更新表单
       return view('Nav.edit',compact('nav','rows','permissions'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nav $nav)
    {
//        dd($request->permission_id);

        //更新功能
        $this->validate($request,[//验证数据
            'name' => 'required',
            'url' => 'required',
            'pid' => 'required',
            'permission_id' => 'required',
        ],[
            'name.required' => '菜单名称不能为空',
            'url.required' => '权限地址不能为空',
            'pid.required' => '上级菜单不能为空',
            'permission_id.required' => '对应权限不能为空',
        ]);

        //验证通过
        $nav->update([
            'name' => $request->name,
            'url' => $request->url,
            'permission_id' => $request->permission_id,
            'pid' => $request->pid,
            'span' => $request->span ?? '',
        ]);

        return redirect()->route('nav.index')->with('success','更新菜单成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nav $nav)
    {
        $nav->delete();
        return back()->with('succescc','删除成功');
    }
}
