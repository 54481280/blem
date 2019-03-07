@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">角色管理</a></li>
<li><a href="#">角色列表</a></li>
<li><a href="#">更新角色</a></li>
@stop
@section('content')
    @include('layout._error')
    <form action="{{route('role.update',[$role])}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="username">角色名称</label>
            <input type="text" class="form-control" id="username" name="name" value="{{$role->name}}" placeholder="请输入权限名称">
        </div>
        <div class="form-group row col-md-12">
            <label for="username">赋属权限</label><br>
            @foreach($permissionsAll as $row)
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox1" name="role[]" value="{{$row->name}}"
                        @if($role->hasPermissionTo($row->name))
                            checked
                        @endif
                  > {{$row->name}}
                </label>
            @endforeach

        </div>
        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定更新</button>
    </form>
@stop
@include('layout._showImg')