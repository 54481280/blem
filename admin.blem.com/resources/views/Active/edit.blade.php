@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">商家活动管理</a></li>
<li><a href="#">商家活动列表</a></li>
<li><a href="#">更新商家活动</a></li>
@stop
@section('content')
    @include('layout._error')
    <form action="{{route('active.update',[$active])}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="title">活动名称</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$active->title}}" placeholder="请输入活动名称">
        </div>
        <div class="form-group row col-md-12">
            <label for="start">活动开始时间</label>
            <input type="date" class="form-control" value="{{$active->start_time}}" min="{{$minDate}}" id="start" name="start_time" >
        </div>
        <div class="form-group row col-md-12">
            <label for="end_time">活动结束时间</label>
            <input type="date" class="form-control" min="{{$maxDate}}" id="end_time" name="end_time" value="{{$active->end_time}}">
        </div>
        <div class="form-group row col-md-12">
            <label for="content">活动详情</label>
            <script id="container" class="reply_ueditor" name="content" type="text/plain">{!! $active->content !!}</script>
        </div>
        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定更新</button>
    </form>

    <!-- 配置文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
    <script>
        // 实例化编辑器
        var ue = UE.getEditor('container');
    </script>
@stop
@include('layout._showImg')