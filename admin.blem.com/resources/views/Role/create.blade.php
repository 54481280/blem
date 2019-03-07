@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">权限管理</a></li>
<li><a href="#">添加权限</a></li>
@stop
@section('content')
@include('layout._error')
    <form action="{{route('role.store')}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="username">角色名称</label>
            <input type="text" class="form-control" id="username" name="name" value="{{old('name')}}" placeholder="请输入权限名称">
        </div>
        <div class="form-group row col-md-12">
            <label for="username">赋属权限</label><br>
            @foreach($rows as $row)
                <label class="checkbox-inline">
            <input type="checkbox" id="inlineCheckbox1" name="role[]" value="{{$row->name}}"> {{$row->name}}
                </label>
            @endforeach

        </div>
        {{csrf_field()}}
        <button type="submit" class="btn btn-success col-md-1">确定添加</button>
    </form>
@stop
@include('layout._showImg')