@extends('layout.list')
@section('CreateUrl'){{route('member.create')}}@stop
@section('CreateStr')新增会员@stop{{--添加语--}}
@section('logo_search') glyphicon-star @stop{{--图标--}}
@section('SearchUrl'){{route('member.index')}}@stop{{--搜索链接--}}
@section('Search')搜索会员名称@stop{{--提示语--}}
@section('path'){{--页面位置--}}
<li><a href="#">会员管理</a></li>
<li><a href="#">会员列表</a></li>
@stop
@section('content')
@include('layout._tips')
    <table class="table table-hover" id="list">
        <tr>
            <th><input type="checkbox" name="ids" id="ids" value="0"> 序号</th>
            <th>会员名称</th>
            <th>会员联系电话</th>
            <th>注册时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($rows as $row)
        <tr class="active">
            <td style="line-height: 60px"><input type="checkbox" name="id" class="id" value="{{$row->id}}"> {{$row->id}}</td>
            <td style="line-height: 60px">{{$row->username}}</td>
            <td style="line-height: 60px">{{$row->tel}}</td>
            <td style="line-height: 60px">{{$row->created_at}}</td>
            <td style="line-height: 60px">
                @if($row->status) <button class="btn btn-success btn-xs">启用</button>
                @else <button class="btn btn-xs">禁用</button>
                    @endif
            </td>
            <td style="line-height: 60px">
                @if($row->status)
                    <button class="btn" title="禁用" onclick="location.href='{{route('member.status',[$row])}}'"><span class="glyphicon glyphicon-edit"></span></button>
                @else
                    <button class="btn btn-primary" title="启用" onclick="location.href='{{route('member.status',[$row])}}'"><span class="glyphicon glyphicon-check"></span></button>
                @endif
                    <button class="btn btn-primary" title="查看会员信息" onclick="location.href='{{route('member.show',[$row])}}'"><span class="glyphicon glyphicon-eye-open"></span></button>
                    {{--<form action="{{route('shop.destroy',[$row])}}" method="post" style="display: inline">--}}
                    {{--{{csrf_field()}}--}}
                    {{--{{method_field('delete')}}--}}
                {{--</form>--}}
            </td>
        </tr>
        @endforeach
    </table>
    <div style="float: right">
        {{$rows->appends(['keyword'=>$keyword])->links()}}
    </div>
@stop

