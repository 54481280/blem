@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">菜单管理</a></li>
<li><a href="#">菜单列表</a></li>
<li><a href="#">更新菜单</a></li>
@stop
@section('content')
    @include('layout._error')
    <form action="{{route('nav.update',[$nav])}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="username">菜单名称</label>
            <input type="text" class="form-control" id="username" name="name" value="{{$nav->name}}" placeholder="请输入菜单名称">
        </div>
        <div class="form-group row col-md-12">
            <label for="username">上级菜单</label>
            <select class="form-control" name="pid">
                <option value="0" @if($nav->pid == 0) selected @endif>默认一级菜单</option>
                @foreach($rows as $row)
                    <option value="{{$row->id}}" @if($nav->pid == $row->id) selected @endif>{{$row->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group row col-md-12">
            <label for="username">地址/路由</label>
            <input type="text" class="form-control" id="username" name="url" value="{{$nav->url}}" placeholder="请输入地址路由">
        </div>
        @if(!$nav->pid)
            <div class="form-group row col-md-12">
                <label for="username">图标</label>
                <input type="text" class="form-control" id="username" name="span" value="{{$nav->span}}" placeholder="请输入图标代码">
            </div>
        @endif

        <div class="form-group row col-md-12">
            <label for="username">对应权限</label><br/>
            @foreach($permissions as $row)
                <label class="radio-inline">
                    <input type="radio" name="permission_id" id="inlineRadio1" value="{{$row->id}}" @if($nav->permission_id == $row->id) checked @endif> {{$row->name}}
                </label>
            @endforeach
        </div>
        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定更新</button>
    </form>
    @include('layout._showImg')
@stop
