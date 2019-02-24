@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">管理员管理</a></li>
<li><a href="#">管理员列表</a></li>
<li><a href="#">更新管理员邮箱</a></li>
@stop
@section('content')
@include('layout._error')
    <form action="{{route('admin.update',[$admin])}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="password">邮箱</label>
            <input type="text" class="form-control" id="password" name="email" value="{{old('email')}}" placeholder="请输入新邮箱">
        </div>
        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定重置</button>
    </form>
@stop
@include('layout._showImg')