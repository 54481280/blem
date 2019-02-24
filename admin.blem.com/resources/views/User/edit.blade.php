@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">商家账户管理</a></li>
<li><a href="#">商家账户列表</a></li>
<li><a href="#">重置商家账户密码</a></li>
@stop
@section('content')
@include('layout._error')
    <form action="{{route('user.update',[$user])}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="password">新密码</label>
            <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}" placeholder="请输入密码">
        </div>
        <div class="form-group row col-md-12">
            <label for="password2">再次输入密码</label>
            <input type="password" class="form-control" id="password2" name="password2" value="{{old('password2')}}" placeholder="请再次输入密码">
        </div>

        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定重置</button>
    </form>
@stop
@include('layout._showImg')