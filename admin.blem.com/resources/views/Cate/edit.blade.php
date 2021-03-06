@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">商家分类管理</a></li>
<li><a href="#">商家分类列表</a></li>
<li><a href="#">更新商家分类</a></li>
@stop
@section('content')
@include('layout._error')
    <form action="{{route('shop.update',[$shop])}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="username">商家分类名称</label>
            <input type="text" class="form-control" id="username" name="name" value="{{$shop->name}}" placeholder="请输入商家分类名称">
        </div>
        <div class="form-group row col-md-4">
            <label for="info_photo">选择商家分类图片</label>
            <div id="uploader-demo">
                <!--用来存放item-->
                <div id="fileList" class="uploader-list"></div>
                <div id="filePicker">选择图片</div>
                <input type="hidden" name="img" id="img_path"/>
            </div>
        </div>
        <div class="col-md-8">
            <img src="{{$shop->img}}" id="autoImg" width="100" height="100" id="default">
        </div>
        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定编辑</button>
    </form>
@include('layout._showImg')
@stop
