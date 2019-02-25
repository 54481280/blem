<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
        $rows = Users::paginate(2);//获取分页数据

        if($keyword = $request->keyword){
            $rows = Users::where('name','like',"%{$keyword}%")->paginate(2);//获取查询分页数据
        }

        return view('User.index',compact('rows','keyword'));//返回页面及数据
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $user)
    {
        //修改密码表单
        return view('User.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Users $user,Request $request)
    {
        $this->validate($request,
            [
                'password' => 'required',//密码不能为空
                'password2' => 'required|same:password',//重复密码不能为空，两次密码输入不一致
            ],
            [
                'password.required' => '新密码不能为空',
                'password2.required' => '重复密码不能为空',
                'password2.same' => '两次密码输入不一致',
            ]);

        //验证通过，修改密码
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        //修改密码成功，给出提示信息，跳转页面
        return redirect()->route('user.index')->with('success','重置密码成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $user)
    {

    }

    //商家状态功能
    public function status(Users $user){
        if($user->status){
            $status = 0;//如果该用户已启用，则更新为禁用
            $info = 'warning';
            $str = '禁用商家账户成功！';
        }else{
            $status = 1;//如果该用户为禁用，则更新为启用
            $info = 'success';
            $str = '启用商家账户成功！';
        }

        //更新
        $user->status = $status;
        $user->save();

        //更新成功，跳转页面，给出提示
        return redirect()->back()->with($info,$str);
    }
}
