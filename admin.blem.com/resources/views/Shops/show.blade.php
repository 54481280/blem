@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">商家信息管理</a></li>
<li><a href="#">商家信息列表</a></li>
<li><a href="#">商家信息详情</a></li>
@stop
@section('content')
   <div class="table-responsive">
      <style>
         td{
            text-align: left;
         }
         .name{
            text-align: right;
         }
         .infoShow{
            color: #999;
            font-size: 20px;
            display: block;
            line-height: 120px;
         }
         .shops,.shops td{
            height: 120px;
         }
      </style>
      <div class="alert alert-info" role="alert">
      <table class="table table-hover">
         <tr class="shops">
            <td class="name"><h2>商家：</h2></td>
            <td class="infoShow">{{$shop->shop_name}}<sup>评分:{{$shop->shop_rating}}</sup></td>
            <td colspan="5"><img src="{{$shop->shop_img}}" width="100" height="100"/></td>
         </tr>
         <tr>
            <td class="name"><h3>是否品牌：</h3></td>
            <td>@if($shop->brand)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</td>
            <td><h3>是否准时送达：</h3></td>
            <td>@if($shop->on_time)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</td>
            <td><h3>是否蜂鸟配送：</h3></td>
            <td>@if($shop->fengniao)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</td>
         </tr>
         <tr>
            <td class="name"><h3>是否保标记：</h3></td>
            <td>@if($shop->bao)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</td>
            <td><h3>是否票标记：</h3></td>
            <td>@if($shop->piao)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</td>
            <td><h3>是否准标记：</h3></td>
            <td>@if($shop->zhun)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</td>
         </tr>
         <tr>
            <td class="name"><h3>起送金额：</h3></td>
            <td><span class="glyphicon glyphicon-jpy"></span>{{$shop->start_send}}</td>
            <td><h3>配送费：</h3></td>
            <td colspan="3"><span class="glyphicon glyphicon-jpy">{{$shop->send_cost}}</td>
         </tr>
         <tr>
            <td class="name"><h3>店公告：</h3></td>
            <td>{{$shop->notice}}</td>
            <td><h3>优惠信息：</h3></td>
            <td colspan="3">{{$shop->discount}}</td>
         </tr>
         <tr>
            <td class="name"><h3>更新时间：</h3></td>
            <td>{{$shop->updated_at}}</td>
            <td><h3>入驻时间：</h3></td>
            <td colspan="3">{{$shop->created_at}}</td>
         </tr>
      </table>
   </div>
   </div>
@stop
@include('layout._showImg')