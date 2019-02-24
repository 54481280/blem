@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">商家信息管理</a></li>
<li><a href="#">更新商家信息</a></li>
@stop
@section('content')
    <form action="{{route('shops.update',[$shop])}}" method="post" enctype="multipart/form-data" style="height: 600px;overflow-y:scroll;">
        @include('layout._error')
        <div class="form-group row col-md-12">
            <h3>商家相关信息：</h3>
        </div>
        <div class="form-group row col-md-12">
            <label for="username">商家分类</label>
            <select class="form-control" name="shop_category_id">
                @foreach($rows as $row)
                    <option value="{{$row->id}}" @if($shop->shop_category_id == $row->id) selected @endif>{{$row->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group row col-md-12">
            <label for="shop_name">商家名称</label>
            <input type="text" class="form-control" id="shop_name" name="shop_name" value="{{$shop->shop_name}}" placeholder="请输入店铺名称">
        </div>
        <div class="form-group row col-md-4">
            <label for="info_photo">选择商家图片</label>
            <input type="file" name="shop_img" onchange="PreviewImage(this)" id="info_photo">
            <p class="help-block">请选择合适的图片作为商家图片.</p>
        </div>
        <div class="col-md-8">
            <img src="{{$shop->img()}}" width="100" height="100" id="default">
            <div id="photo_info" class="photo_info"></div>
        </div>
        <div class="form-group row col-md-12">
            <label for="shop_rating">商家评分</label>
            <input type="text" class="form-control" id="shop_rating" name="shop_rating" value="{{$shop->shop_rating}}" placeholder="请输入店铺评分">
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="brand">是否品牌</label></br>
            <label class="radio-inline">
                <input type="radio" name="brand" id="brand" value="1" @if($shop->brand == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="brand" id="brand2" value="0" @if($shop->brand != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="on_time">是否准时送达</label></br>
            <label class="radio-inline">
                <input type="radio" name="on_time" id="on_time" value="1" @if($shop->on_time == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="on_time" id="on_time2" value="0" @if($shop->on_time != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="fengniao">是否蜂鸟配送</label></br>
            <label class="radio-inline">
                <input type="radio" name="fengniao" id="fengniao" value="1" @if($shop->fengniao == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="fengniao" id="fengniao2" value="0" @if($shop->fengniao != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="bao">是否保标记</label></br>
            <label class="radio-inline">
                <input type="radio" name="bao" id="bao" value="1" @if($shop->bao == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="bao" id="bao2" value="0" @if($shop->bao != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="piao">是否票标记</label></br>
            <label class="radio-inline">
                <input type="radio" name="piao" id="piao" value="1" @if($shop->piao == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="piao" id="piao2" value="0" @if($shop->piao != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="zhun">是否准标记</label></br>
            <label class="radio-inline">
                <input type="radio" name="zhun" id="zhun" value="1" @if($shop->zhun == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="zhun" id="zhun2" value="0" @if($shop->zhun != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-12">
            <label for="start_send">起送金额</label>
            <input type="text" class="form-control" id="start_send" name="start_send" value="{{$shop->start_send}}" placeholder="请输入起送金额">
        </div>
        <div class="form-group row col-md-12">
            <label for="send_cost">配送费</label>
            <input type="text" class="form-control" id="send_cost" name="send_cost" value="{{$shop->send_cost}}" placeholder="请输入配送费">
        </div>
        <div class="form-group row col-md-12">
            <label for="discount">优惠信息</label>
            <textarea class="form-control" rows="3" name="discount" id="discount">{{$shop->discount}}</textarea>
        </div>
        <div class="form-group row col-md-12">
            <label for="notice">店公告</label>
            <textarea class="form-control" rows="3" name="notice" id="notice">{{$shop->notice}}</textarea>
        </div>

        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定更新</button>
    </form>
@stop
@include('layout._showImg')