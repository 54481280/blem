@extends('layout.list')


@can('新增抽奖活动')

@section('CreateUrl'){{route('event.create')}}@stop
@section('CreateStr')新增抽奖活动@stop{{--添加语--}}

@else
@section('CreateStr')抽奖活动@stop{{--添加语--}}
@endcan


@section('logo_search') glyphicon glyphicon-th @stop{{--图标--}}
@section('SearchUrl'){{route('event.index')}}@stop{{--搜索链接--}}
@section('Search')搜索抽奖活动@stop{{--提示语--}}
@section('path'){{--页面位置--}}
<li><a href="#">商家抽奖活动管理</a></li>
<li><a href="#">商家抽奖活动列表</a></li>
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
        <th>抽奖活动名称</th>
        <th>抽奖详情</th>
        <th>报名开始时间</th>
        <th>报名结束时间</th>
        <th>开奖时间</th>
        <th>报名人数限制</th>
        <th>活动状态</th>
        <th>操作</th>
    </tr>
    @foreach($rows as $row)
        <tr class="active">
            <td style="line-height: 60px"><input type="checkbox" name="id" class="id" value="{{$row->id}}"> {{$row->id}}</td>
            <td style="line-height: 60px">{{$row->title}}</td>
            <td style="line-height: 60px">{!! $row->content !!}</td>
            <td style="line-height: 60px">{{date('Y-m-d H:i:s',$row->signup_start)}}</td>
            <td style="line-height: 60px">{{date('Y-m-d H:i:s',$row->signup_end)}}</td>
            <td style="line-height: 60px">{{$row->prize_date}}</td>
            <td style="line-height: 60px">{{$row->signup_num}}</td>
            <td style="line-height: 60px">
                @if($row->is_prize)
                    已开奖
                    @else
                未开奖
                    @endif
            </td>
            <td style="line-height: 60px">
                @can('修改商家活动')
                <button class="btn btn-warning" title="更新活动" onclick="location.href='{{route('event.edit',[$row])}}'"><span class="glyphicon glyphicon-pencil"></span></button>
                    @endcan
                    <button class="btn btn-success" title="查看详情" onclick="location.href='{{route('event.show',[$row])}}'"><span class="glyphicon glyphicon-eye-open"></span></button>
                    @if(!$row->is_prize)
                    <button class="btn btn-primary" title="添加抽奖商品" onclick="location.href='{{route('event.prize',[$row])}}'"><span class="glyphicon glyphicon-plus"></span></button>
                    @endif

                    <form action="{{route('event.destroy',[$row])}}" method="post" style="display: inline">
                        {{csrf_field()}}
                        {{method_field('delete')}}
                        <button class="btn btn-danger" title="删除"><span class="glyphicon glyphicon-trash"></span></button>
                    </form>
            </td>
        </tr>
    @endforeach
</table>
<div style="float: right">
    {{$rows->appends($keyword)->links()}}
</div>
@stop

