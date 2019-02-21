@extends('layout.form')
@section('content')
@include('layout._error')
    <form action="{{route('shop.update',[$shop])}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="username">商家分类名称</label>
            <input type="text" class="form-control" id="username" name="name" value="{{$shop->name}}" placeholder="请输入商家分类名称">
        </div>
        <div class="form-group row col-md-4">
            <label for="info_photo">选择商家分类图片</label>
            <input type="file" name="img" onchange="PreviewImage(this)" id="info_photo">
            <p class="help-block">请选择合适的图片作为分类图片.</p>
        </div>
        <div class="col-md-8">
            <img src="{{$shop->img()}}" width="100" height="100" id="default">
            <div id="photo_info" class="photo_info"></div>
        </div>
        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定编辑</button>
    </form>
@stop
@include('layout._showImg')