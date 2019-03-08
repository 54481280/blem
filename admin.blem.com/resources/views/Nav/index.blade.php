@extends('layout.list')
@can('添加菜单')
@section('CreateUrl'){{route('nav.create')}}@stop{{--添加链接--}}
@section('CreateStr')新增菜单@stop{{--添加语--}}
@else
@section('CreateStr')菜单@stop{{--添加语--}}
@endcan

@section('logo_search') glyphicon-align-justify @stop{{--图标--}}
@section('SearchUrl'){{route('nav.index')}}@stop{{--搜索链接--}}
@section('Search')搜索菜单@stop{{--提示语--}}
@section('path'){{--页面位置--}}
    <li><a href="#">菜单管理</a></li>
    <li><a href="#">菜单列表</a></li>
@stop
@section('content')
@include('layout._tips')

    <table class="table table-hover" id="list">
        <tr>
            <th><input type="checkbox" name="ids" id="ids" value="0"> 序号</th>
            <th>菜单名称</th>
            <th>地址</th>
            <th>权限</th>
            <th>操作</th>
        </tr>
        @foreach($rows as $row)
        <tr class="active">
            <td style="line-height: 60px"><input type="checkbox" name="id" class="id" value="{{$row->id}}"> {{$row->id}}</td>
            <td style="line-height: 60px">{{$row->name}}</td>
            <td style="line-height: 60px">{{$row->url}}</td>
            <td style="line-height: 60px">{{$row->permission->name}}</td>
            <td style="line-height: 60px">
                @can('修改菜单	')
                    <button class="btn btn-warning" title="编辑" onclick="location.href='{{route('nav.edit',[$row])}}'"><span class="glyphicon glyphicon-pencil"></span></button>
                @endcan
                @can('	删除菜单')
                    <form action="{{route('nav.destroy',[$row])}}" method="post" style="display: inline">
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

