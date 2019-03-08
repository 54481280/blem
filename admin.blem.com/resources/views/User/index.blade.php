@extends('layout.list')

@can('新增商家')
@section('CreateUrl'){{route('shops.create')}}@stop
@section('CreateStr')新增商家@stop{{--添加语--}}
@else
@section('CreateStr')商家@stop{{--添加语--}}
@endcan
@section('logo_search') glyphicon-user @stop{{--图标--}}
@section('SearchUrl'){{route('user.index')}}@stop{{--搜索链接--}}
@section('Search')搜索商家账号@stop{{--提示语--}}
@section('path'){{--页面位置--}}
<li><a href="#">商家账号管理</a></li>
<li><a href="#">商家账号列表</a></li>
@stop
@section('content')
@include('layout._tips')
    <table class="table table-hover" id="list">
        <tr>
            <th><input type="checkbox" name="ids" id="ids" value="0"> 序号</th>
            <th>商家账号</th>
            <th>商家邮箱</th>
            <th>关联商家</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($rows as $row)
        <tr class="active">
            <td style="line-height: 60px"><input type="checkbox" name="id" class="id" value="{{$row->id}}"> {{$row->id}}</td>
            <td style="line-height: 60px">{{$row->name}}</td>
            <td style="line-height: 60px">{{$row->email}}</td>
            <td style="line-height: 60px">{{$row->shops->shop_name}}</td>
            <td style="line-height: 60px">
                @if($row->status) <button class="btn btn-success btn-xs">启用</button>
                @else <button class="btn btn-xs">禁用</button>
                    @endif
            </td>
            <td style="line-height: 60px">
                @can('修改商家账号状态')
                @if($row->status)
                    <button class="btn" title="禁用" onclick="location.href='{{route('user.status',[$row])}}'"><span class="glyphicon glyphicon-edit"></span></button>
                @else
                    <button class="btn btn-primary" title="启用" onclick="location.href='{{route('user.status',[$row])}}'"><span class="glyphicon glyphicon-check"></span></button>
                @endif
                @endcan
                @can('重置商家账号密码')
                    <button class="btn btn-warning" title="重置密码" onclick="location.href='{{route('user.edit',[$row])}}'"><span class="glyphicon glyphicon-lock"></span></button>
                    @endcan
            </td>
        </tr>
        @endforeach
    </table>
    <div style="float: right">
        {{$rows->appends(['keyword'=>$keyword])->links()}}
    </div>
@stop

