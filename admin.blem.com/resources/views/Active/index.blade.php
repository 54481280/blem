@extends('layout.list')


@can('添加商家活动')

@section('CreateUrl'){{route('active.create')}}@stop
@section('CreateStr')新增商家活动@stop{{--添加语--}}

@else
@section('CreateStr')商家活动@stop{{--添加语--}}
@endcan


@section('logo_search') glyphicon glyphicon-th-large @stop{{--图标--}}
@section('SearchUrl'){{route('active.index')}}@stop{{--搜索链接--}}
@section('Search')搜索商家活动@stop{{--提示语--}}
@section('path'){{--页面位置--}}
<li><a href="#">商家活动管理</a></li>
<li><a href="#">商家活动列表</a></li>
@stop
@section('searchDiv')
    <div class="form-group">
        <div class="input-group">
            <select class="form-control" name="status">
                <option value="0">全部</option>
                <option value="-1">未开始</option>
                <option value="1">进行中</option>
                <option value="2">已结束</option>
            </select>
        </div>
    </div>
@stop
@section('content')
@include('layout._tips')
<table class="table table-hover" id="list">
    <tr>
        <th><input type="checkbox" name="ids" id="ids" value="0"> 序号</th>
        <th>活动名称</th>
        <th>活动详情</th>
        <th>活动开始时间</th>
        <th>活动结束时间</th>
        <th>活动状态</th>
        <th>操作</th>
    </tr>
    @foreach($rows as $row)
        <tr class="active">
            <td style="line-height: 60px"><input type="checkbox" name="id" class="id" value="{{$row->id}}"> {{$row->id}}</td>
            <td style="line-height: 60px">{{$row->title}}</td>
            <td style="line-height: 60px">{!! $row->content !!}</td>
            <td style="line-height: 60px">{{$row->start_time}}</td>
            <td style="line-height: 60px">{{$row->end_time}}</td>
            <td style="line-height: 60px">
                @if(date('Y-m-d H:i:s') < $row->start_time)
                    <button class="btn btn-primary">未开始</button>
                @elseif(date('Y-m-d H:i:s') >= $row->start_time && date('Y-m-d') <= $row->end_time)
                    <button class="btn btn-success">进行中</button>
                @else
                    <button class="btn btn-default">已结束</button>
                @endif
            </td>
            <td style="line-height: 60px">
                @can('修改商家活动')
                <button class="btn btn-warning" title="更新活动" onclick="location.href='{{route('active.edit',[$row])}}'"><span class="glyphicon glyphicon-pencil"></span></button>
                    @endcan
            </td>
        </tr>
    @endforeach
</table>
<div style="float: right">
    {{$rows->appends([$data])->links()}}
</div>
@stop

