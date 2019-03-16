@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">商家抽奖活动管理</a></li>
<li><a href="#">新增抽奖活动</a></li>
@stop
@section('content')
@include('layout._error')
    <form action="{{route('event.store')}}" method="post" enctype="multipart/form-data" >
        <div class="form-group row col-md-12">
            <label for="title">抽奖活动名称</label>
            <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" placeholder="请输入活动名称">
        </div>
        <div class="form-group row col-md-12">
            <label for="start">活动开始时间</label>
            <input type="datetime-local" class="form-control" value="{{old('start_time')}}"  id="start" name="signup_start" >
        </div>
        <div class="form-group row col-md-12">
            <label for="end_time">活动结束时间</label>
            <input type="datetime-local" class="form-control"  id="end_time" name="signup_end" value="{{old('end_time')}}">
        </div>
        <div class="form-group row col-md-12">
            <label for="end_time">开奖日期</label>
            <input type="date" class="form-control" min="{{$date}}" id="end_time" name="prize_date" value="{{old('end_time') ?? $date}}">
        </div>
        <div class="form-group row col-md-12">
            <label for="end_time">报名限制人数</label>
            <input type="text" class="form-control" id="end_time" name="signup_num" value="{{old('signup_num')}}">
        </div>
        <div class="form-group row col-md-12">
            <label for="content">详情</label>
            <script id="container" class="reply_ueditor" name="content" type="text/plain"></script>
        </div>
        {{csrf_field()}}
        <button type="submit" class="btn btn-success col-md-1">确定添加</button>
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