@extends('layout.list')
@section('CreateUrl'){{route('permission.create')}}@stop
@section('CreateStr')新增权限@stop{{--添加语--}}
@section('logo_search') glyphicon-briefcase @stop{{--图标--}}
@section('SearchUrl'){{route('permission.index')}}@stop{{--搜索链接--}}
@section('Search')搜索权限名称@stop{{--提示语--}}
@section('path'){{--页面位置--}}
<li><a href="#">权限管理</a></li>
<li><a href="#">权限列表</a></li>
@stop
@section('content')
@include('layout._tips')
<table class="table table-hover" id="list">
    <tr>
        <th><input type="checkbox" name="ids" id="ids" value="0"> 序号</th>
        <th>权限名称</th>
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
                <button class="btn btn-warning" title="修改邮箱" onclick="location.href='{{route('permission.edit',[$row])}}'"><span class="glyphicon glyphicon-pencil"></span></button>
                <form action="{{route('permission.destroy',[$row])}}" method="post" style="display: inline">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    <button class="btn btn-danger" title="删除"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
<div style="float: right">
    {{$rows->appends(['keyword'=>$keyword])->links()}}
</div>
@stop

