@extends('layout.form')
@section('content')
@include('layout._error')
@include('layout._tips')
        <div class="page-header">
            <h1>{{$admin->name}} <small>{{$admin->email}}</small></h1>
        </div>
        <div class="form-group row col-md-12">
            <label for="email">管理员更新时间</label>
            <input type="text" class="form-control" id="email" name="email" value="{{$admin->updated_at}}" disabled>
        </div>
        <button class="btn btn-primary" id="upPwd">点击此处修改密码</button>

        <form action="{{route('admin.destroy',[$admin])}}" method="post" enctype="multipart/form-data" style="display: none;" id="upPwdForm">
            <div class="form-group row col-md-12">
                <label for="password">请输入原始密码</label>
                <input type="password" class="form-control" id="password" name="oldPwd" placeholder="请输入原始密码">
            </div>
            <div class="form-group row col-md-12">
                <label for="password">请输入新密码</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="请输入新密码">
            </div>
            <div class="form-group row col-md-12">
                <label for="password">请输入原始密码</label>
                <input type="password" class="form-control" id="password" name="password2" placeholder="请再次输入密码">
            </div>
            <div class="form-group row col-md-12">
                <label for="captcha">请输入验证码</label>
                <input type="text" class="form-control" id="captcha" name="captcha" placeholder="请输入验证码">
            </div>
            <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
            {{csrf_field()}}
            {{method_field('delete')}}
            <button type="submit" class="btn btn-success col-md-1">确定修改</button>
        </form>
@stop
@include('layout._showImg')