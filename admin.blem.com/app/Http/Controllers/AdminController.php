<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
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
        //管理员列表
        if($keyword = $request->keyword){
            $rows = Admin::where('name','like',"%$keyword%")->paginate(3);//获取所有管理员数据
        }else{
            $rows = Admin::paginate(3);//获取所有管理员数据
        }

        return view('Admin.index',compact('rows','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取所有角色数据
        $rows = Role::all();
        //添加管理员表单
        return view('Admin.create',compact('rows'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //添加管理员功能
        $this->validate($request,
            [
                'name' => 'required',//用户名不能为空
                'email' => 'required|email',//邮箱
                'password' => 'required',//密码不能为空
                'password2' => 'required|same:password',//重复密码不能为空且要相同
                'role' => 'required',
            ],[
                'name.required' => '管理员账号不能为空',
                'email.required' => '管理员邮箱不能为空',
                'email.email' => '管理员邮箱格式不正确',
                'password.required' => '管理员密码不能为空',
                'password2.required' => '管理员重复密码不能为空',
                'password2.same' => '两次密码不一致，请重新输入',
                'role.required' => '角色不能为空'
            ]);

        //验证通过，将数据写入数据库
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($request->role){
            $admin->syncRoles($request->role);
        }

        //添加功能完成，跳转页面及给出提示信息
        return redirect()->route('admin.index')->with('success','添加管理员成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::find($id);
        //个人详情页面
        return view('admin.show',compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //获取所有角色数据
        $rows = Role::all();
        $roles = $admin->getRoleNames();
        //管理员编辑表单
        return view('Admin.edit',compact('admin','rows','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //管理员编辑功能
        $this->validate($request,
            [
                'role' => 'required',//角色
            ],[
                'role.required' => '角色不能为空',

            ]);

        $admin->syncRoles($request->role);//重置角色

        //更新功能完成，跳转页面及给出提示信息
        return redirect()->route('admin.index')->with('success','更新管理员成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy(Admin $admin,Request $request)
    {
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
        if(Hash::check($request->oldPwd,$admin->password)){
            //密码相同
            $admin->update([
                'password' => Hash::make($request->password),
            ]);
        }else{
            return back()->with('danger','原始密码输入错误');
        }

        //修改密码成功
        return redirect()->route('admin.index')->with('success','修改个人密码成功！');

    }

    public function del(Admin $admin){

        //删除该管理员的角色关联
        $admin->syncRoles();
        //删除管理员
        $admin->delete();
        return back()->with('success','删除成功');
    }
}
