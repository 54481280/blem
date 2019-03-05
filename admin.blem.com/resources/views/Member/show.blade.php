@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">会员管理</a></li>
<li><a href="#">会员个人详情</a></li>
@stop
@section('content')
@include('layout._error')
@include('layout._tips')
        @if(empty($member))
            <div class="page-header">
                <h1>暂无详细信息</h1>
            </div>
        @endif
        @foreach($member as $row)

            <div class="look" style="height: 600px;overflow-y: scroll">
            <div class="page-header">
                <h1>{{$row->username}} <small>{{$row->created_at}}</small></h1>
            </div>
            <div class="form-group row col-md-12">
                <label for="email">会员注册时间</label>
                <input type="text" class="form-control" id="email" name="email" value="{{$row->created_at}}" disabled>
            </div>
            <div class="form-group row col-md-12">
                <label for="email">会员联系电话</label>
                <input type="text" class="form-control" id="email" name="email" value="{{$row->tel}}" disabled>
            </div>
            @for($i=0;$i<count($row->tels);$i++)
            <div class="page-header row col-md-12">
                <h2><small>常用配送地址 {{$i+1}}</small></h2>
            </div>
            <div class="form-group row col-md-12">
                <label for="email">详细地址</label>
                <input type="text" class="form-control" id="email" name="email" value="{{$row->province[$i].$row->city[$i].$row->area[$i].$row->detail_address[$i]}}" disabled>
            </div>
            <div class="form-group row col-md-12">
                <label for="email">收货联系电话</label>
                <input type="text" class="form-control" id="email" name="email" value="{{$row->tels[$i]}}" disabled>
            </div>
        @endfor
            </div>
    @endforeach



@stop
