@extends('layout.list')
@section('CreateUrl'){{route('admin.create')}}@stop
@section('CreateStr')新增管理员@stop{{--添加语--}}
@section('logo_search') glyphicon-education @stop{{--图标--}}
@section('SearchUrl'){{route('admin.index')}}@stop{{--搜索链接--}}
@section('Search')搜索管理员@stop{{--提示语--}}
@section('path'){{--页面位置--}}
<li><a href="#">管理员管理</a></li>
<li><a href="#">管理员列表</a></li>
@stop
@section('content')
@include('layout._tips')
<table class="table table-hover" id="list">
    <tr>
        <th><input type="checkbox" name="ids" id="ids" value="0"> 序号</th>
        <th>管理员账号</th>
        <th>管理员邮箱</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
    @foreach($rows as $row)
        <tr class="active">
            <td style="line-height: 60px"><input type="checkbox" name="id" class="id" value="{{$row->id}}"> {{$row->id}}</td>
            <td style="line-height: 60px">{{$row->name}}</td>
            <td style="line-height: 60px">{{$row->email}}</td>
            <td style="line-height: 60px">{{$row->updated_at}}</td>
            <td style="line-height: 60px">
                <button class="btn btn-warning" title="修改邮箱" onclick="location.href='{{route('admin.edit',[$row])}}'"><span class="glyphicon glyphicon-envelope"></span></button>
            </td>
        </tr>
    @endforeach
</table>
@stop

