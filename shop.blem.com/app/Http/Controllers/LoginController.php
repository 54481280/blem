<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //登录页面
    public function index(){
        return view('Login.index');
    }

    //登录功能
    public function login(Request $request){
        //验证表单数据格式
        $this->validate($request,[
            'name' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ],[
            'name.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码输入错误，请重新输入',
        ]);

        //验证通过，开始登录
        if(Auth::attempt([
            'name' => $request->name,
            'password' => $request->password,
        ],$request->has('rember'))){

            //判断用户是否被禁用
            if(!Auth::user()->status){
                Auth::logout();//清除session数据
                return back()->with('danger','用户未激活，登录失败！');
            }

            //登录成功,跳转页面，并给出提示信息
            return redirect()->route('user.index')->with('success','登录成功！');
        }



        //登录失败
        return back()->with('danger','用户名或密码错误，登录失败！');
    }

    //退出登录功能
    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success','退出登录成功！');
    }
}
