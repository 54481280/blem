@extends('layout.list')
@can('添加角色')
@section('CreateUrl'){{route('role.create')}}@stop
@section('CreateStr')新增角色@stop{{--添加语--}}
@else
@section('CreateStr')新角色@stop{{--添加语--}}
@endcan

@section('logo_search') glyphicon-knight @stop{{--图标--}}
@section('SearchUrl'){{route('role.index')}}@stop{{--搜索链接--}}
@section('Search')搜索角色名称@stop{{--提示语--}}
@section('path'){{--页面位置--}}
<li><a href="#">角色管理</a></li>
<li><a href="#">角色列表</a></li>
@stop
@section('content')
@include('layout._tips')
<table class="table table-hover" id="list">
    <tr>
        <th><input type="checkbox" name="ids" id="ids" value="0"> 序号</th>
        <th>角色名称</th>
        <th>权限描述</th>
        <th>添加时间</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
    @foreach($rows as $row)
        <tr class="active">
            <td style="line-height: 60px"><input type="checkbox" name="id" class="id" value="{{$row->id}}"> {{$row->id}}</td>
            <td style="line-height: 60px">{{$row->name}}</td>
            <td style="line-height: 60px">{{$row->guard_name}}</td>
            <td style="line-height: 60px">{{$row->created_at}}</td>
            <td style="line-height: 60px">{{$row->updated_at}}</td>
            <td style="line-height: 60px">
                @can('修改角色')
                <button class="btn btn-warning" title="更新角色" onclick="location.href='{{route('role.edit',[$row])}}'"><span class="glyphicon glyphicon-pencil"></span></button>
                @endcan
                @can('删除角色')
                <form action="{{route('role.destroy',[$row])}}" method="post" style="display: inline">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    <button class="btn btn-danger" title="删除"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
                    @endcan
            </td>
        </tr>
    @endforeach
</table>
<div style="float: right">
    {{$rows->appends(['keyword'=>$keyword])->links()}}
</div>
@stop

