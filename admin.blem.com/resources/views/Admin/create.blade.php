@extends('layout.form')
@section('content')
@include('layout._error')
    <form action="{{route('admin.store')}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="username">管理员账号</label>
            <input type="text" class="form-control" id="username" name="name" value="{{old('name')}}" placeholder="请输入管理员账号">
        </div>
        <div class="form-group row col-md-12">
            <label for="email">管理员邮箱</label>
            <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" placeholder="请输入管理员邮箱">
        </div>
        <div class="form-group row col-md-12">
            <label for="password">密码</label>
            <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}" placeholder="请输入密码">
        </div>
        <div class="form-group row col-md-12">
            <label for="password2">重复密码</label>
            <input type="password" class="form-control" id="password2" name="password2" value="{{old('password2')}}" placeholder="请再次输入密码">
        </div>
        {{csrf_field()}}
        <button type="submit" class="btn btn-success col-md-1">确定添加</button>
    </form>
@stop
@include('layout._showImg')