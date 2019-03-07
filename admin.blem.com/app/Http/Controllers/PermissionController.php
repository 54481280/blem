<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //权限列表
        if($keyword = $request->keyword){
            $rows = Permission::where('name','like',"%$keyword%")->paginate(3);
        }else{
            $rows =  Permission::paginate(3);
        }
        return view('Permission.index',compact('rows','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //添加权限表单
        return view('Permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //完成添加功能
        $this->validate($request,[
            'name' => 'required',
        ],[
            'name.required' => '权限名称不能为空',
        ]);

        //验证通过
        Permission::create([
            'name' => $request->name,
        ]);

        return redirect()->route('permission.index')->with('success','添加权限成功');
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
    public function edit(Permission $permission)
    {
        //更新权限
        return view('Permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //更新功能
        $this->validate($request,[
            'name' => 'required',
        ],[
            'name.required' => '权限名称不能为空',
        ]);


        //验证通过
        $permission->update([
            'name' => $request->name,
            ]);

        return redirect()->route('permission.index')->with('success','更新权限成功');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //查询该权限下的角色
        $row = DB::select('select * from role_has_permissions where permission_id = ?',[$permission->id]);
        if(!empty($row)){
            return back()->with('danger','该权限下有角色，不能删除');
        }

        $permission->delete();

        return back()->with('success','删除权限成功');
    }
}
