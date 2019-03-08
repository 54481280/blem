<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
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
        //角色列表
        if($keyword = $request->keyword){
            $rows = Role::where('name','like',"%$keyword%")->paginate(3);
        }else{
            $rows = Role::paginate(3);
        }

        return view('Role.index',compact('rows','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rows = Permission::all();

        //添加角色表单
        return view('Role.create',compact('rows'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //验证数据
        $this->validate($request,[
           'name' => 'required',
            'role' => 'required',
        ],[
            'name.required' => '角色名字不能为空',
            'role.require' => '角色不能为空'
        ]);

        //验证通过
        $role = Role::create([
            'name' => $request->name
        ]);

        //赋予权限
        if($request->role){
            $role->syncPermissions($request->role);
        }

        return redirect()->route('role.index')->with('success','添加角色成功');
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
    public function edit(Role $role)
    {
        //查询所有权限
        $permissionsAll = Permission::all();
        //查询该角色拥有的权限
        $permissions  = $role->getAllPermissions();
        //更新表单
        return view('Role.edit',compact('role','permissions','permissionsAll'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //验证数据
        $this->validate($request,[
            'name' => 'required'
        ],[
            'name.required' => '角色名字不能为空'
        ]);

        //验证通过
        $role->update([
            'name' => $request->name
        ]);

        //赋予权限
        $role->syncPermissions($request->role);

        return redirect()->route('role.index')->with('success','更新角色成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try{//检查该角色上是否存在管理员,没有会报错，捕获错误，删除角色
            Admin::role($role->name)->get()->toArray();

            return back()->with('danger','该角色上有管理员，删除失败');

        }catch (\Exception $exception){

            //删除角色关联权限
            $role->syncPermissions();
            //删除角色
            $role->delete();
            return back()->with('success','删除角色成功');

        }


    }
}
