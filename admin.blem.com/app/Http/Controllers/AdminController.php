<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //管理员列表
        $rows = Admin::all();//获取所有管理员数据

        return view('Admin.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //添加管理员表单
        return view('Admin.create');
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
            ],[
                'name.required' => '管理员账号不能为空',
                'email.required' => '管理员邮箱不能为空',
                'email.email' => '管理员邮箱格式不正确',
                'password.required' => '管理员密码不能为空',
                'password2.required' => '管理员重复密码不能为空',
                'password2.same' => '两次密码不一致，请重新输入',
            ]);

        //验证通过，将数据写入数据库
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

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
        //管理员编辑表单
        return view('Admin.edit',compact('admin'));
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
                'email' => 'required|email',//邮箱
            ],[
                'email.required' => '管理员邮箱不能为空',
                'email.email' => '管理员邮箱格式不正确',
            ]);

        //验证通过，将数据写入数据库
        $admin->update([
            'email' => $request->email,
        ]);

        //更新功能完成，跳转页面及给出提示信息
        return redirect()->route('admin.index')->with('success','更新管理员成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
