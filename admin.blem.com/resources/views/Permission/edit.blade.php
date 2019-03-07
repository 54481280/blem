@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">权限管理</a></li>
<li><a href="#">更新权限</a></li>
@stop
@section('content')
    @include('layout._error')
    <form action="{{route('permission.update',[$permission])}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="username">权限名称</label>
            <input type="text" class="form-control" id="username" name="name" value="{{$permission->name}}" placeholder="请输入权限名称">
        </div>

        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定更新</button>
    </form>
@stop
@include('layout._showImg')