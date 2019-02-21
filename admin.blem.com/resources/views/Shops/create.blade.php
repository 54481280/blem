@extends('layout.form')
@section('content')
    <form action="{{route('shops.store')}}" method="post" enctype="multipart/form-data" style="height: 600px;overflow-y:scroll;">
        @include('layout._error')
        <div class="form-group row col-md-12">
            <h3>商家相关信息：</h3>
        </div>
        <div class="form-group row col-md-12">
            <label for="username">商家分类</label>
            <select class="form-control" name="shop_category_id">
                @foreach($rows as $row)
                <option value="{{$row->id}}" @if(old('shop_category_id') == $row->id) selected @endif>{{$row->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group row col-md-12">
            <label for="shop_name">商家名称</label>
            <input type="text" class="form-control" id="shop_name" name="shop_name" value="{{old('shop_name')}}" placeholder="请输入店铺名称">
        </div>
        <div class="form-group row col-md-4">
            <label for="info_photo">选择商家图片</label>
            <input type="file" name="shop_img" onchange="PreviewImage(this)" id="info_photo">
            <p class="help-block">请选择合适的图片作为商家图片.</p>
        </div>
        <div class="col-md-8">
            <img src="/images/00.jpg" width="100" height="100" id="default">
            <div id="photo_info" class="photo_info"></div>
        </div>
        <div class="form-group row col-md-12">
            <label for="shop_rating">商家评分</label>
            <input type="text" class="form-control" id="shop_rating" name="shop_rating" value="{{old('shop_rating')}}" placeholder="请输入店铺评分">
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="brand">是否品牌</label></br>
            <label class="radio-inline">
                <input type="radio" name="brand" id="brand" value="1" @if(old('brand') == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="brand" id="brand2" value="0" @if(old('brand') != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="on_time">是否准时送达</label></br>
            <label class="radio-inline">
                <input type="radio" name="on_time" id="on_time" value="1" @if(old('on_time') == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="on_time" id="on_time2" value="0" @if(old('on_time') != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="fengniao">是否蜂鸟配送</label></br>
            <label class="radio-inline">
                <input type="radio" name="fengniao" id="fengniao" value="1" @if(old('fengniao') == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="fengniao" id="fengniao2" value="0" @if(old('fengniao') != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="bao">是否保标记</label></br>
            <label class="radio-inline">
                <input type="radio" name="bao" id="bao" value="1" @if(old('bao') == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="bao" id="bao2" value="0" @if(old('bao') != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="piao">是否票标记</label></br>
            <label class="radio-inline">
                <input type="radio" name="piao" id="piao" value="1" @if(old('piao') == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="piao" id="piao2" value="0" @if(old('piao') != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-4" style="text-align: center">
            <label for="zhun">是否准标记</label></br>
            <label class="radio-inline">
                <input type="radio" name="zhun" id="zhun" value="1" @if(old('zhun') == 1) checked @endif> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="zhun" id="zhun2" value="0" @if(old('zhun') != 1) checked @endif> 否
            </label>
        </div>
        <div class="form-group row col-md-12">
            <label for="start_send">起送金额</label>
            <input type="text" class="form-control" id="start_send" name="start_send" value="{{old('start_send')}}" placeholder="请输入起送金额">
        </div>
        <div class="form-group row col-md-12">
            <label for="send_cost">配送费</label>
            <input type="text" class="form-control" id="send_cost" name="send_cost" value="{{old('send_cost')}}" placeholder="请输入配送费">
        </div>
        <div class="form-group row col-md-12">
            <label for="discount">优惠信息</label>
            <textarea class="form-control" rows="3" name="discount" id="discount">{{old('discount')}}</textarea>
        </div>
        <div class="form-group row col-md-12">
            <label for="notice">店公告</label>
            <textarea class="form-control" rows="3" name="notice" id="notice">{{old('notice')}}</textarea>
        </div>



        <div class="form-group row col-md-12">
            <h3>商家账号相关信息：</h3>
        </div>
        <div class="form-group row col-md-12">
            <label for="name">账号名称</label>
            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="请输入账号">
        </div>
        <div class="form-group row col-md-12">
            <label for="email">邮箱</label>
            <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" placeholder="请输入邮箱">
        </div>
        <div class="form-group row col-md-12">
            <label for="password">密码</label>
            <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}" placeholder="请输入密码">
        </div>
        <div class="form-group row col-md-12">
            <label for="password2">重复密码</label>
            <input type="password" class="form-control" id="password2" name="password2" value="{{old('password2')}}" placeholder="请再次输入密码">
        </div>

        {{csrf_field()}}
        <button type="submit" class="btn btn-success col-md-1">确定添加</button>
    </form>
@stop
@include('layout._showImg')