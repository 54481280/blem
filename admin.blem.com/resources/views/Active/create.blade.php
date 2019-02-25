@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">商家活动管理</a></li>
<li><a href="#">新增商家活动</a></li>
@stop
@section('content')
@include('layout._error')
    <form action="{{route('active.store')}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="title">活动名称</label>
            <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" placeholder="请输入活动名称">
        </div>
        <div class="form-group row col-md-12">
            <label for="start">活动开始时间</label>
            <input type="date" class="form-control" min="{{$minDate}}" id="start" name="start_time" value="{{old('start_time') ?? $minDate}}">
        </div>
        <div class="form-group row col-md-12">
            <label for="end_time">活动结束时间</label>
            <input type="date" class="form-control" min="{{$maxDate}}" id="end_time" name="end_time" value="{{old('end_time') ?? $maxDate}}">
        </div>
        <div class="form-group row col-md-12">
            <label for="content">活动详情</label>
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