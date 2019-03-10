@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">管理员管理</a></li>
<li><a href="#">管理员个人中心</a></li>
@stop
@section('content')
@include('layout._error')
@include('layout._tips')
<div class="page-header" style="height: 600px;overflow-y:scroll;">
    <h1>{{$event->title}} <small>报名时间:{{date("Y-m-d H:i:s",$event->signup_start)}}至{{date("Y-m-d H:i:s",$event->signup_end)}}</small></h1>
    <div class="jumbotron" style="padding-left: 50px">
        <h1 style="color: orangered;">@if($event->is_prize == 0)未开奖@else已开奖@endif</h1>
        <p>{!! $event->content !!}</p>
        <p>限制报名人数：{{$event->signup_num}}</p>
        <p>奖品：
        @foreach($event->getPrize as $row)
            <ol>{{$row->name}}@if(!$event->is_prize)<a class="btn btn-primary btn-xs" href="{{route('event.delPrize',[$row])}}">删除奖品</a>@endif</ol>
            @endforeach
            </p>
            <p>报名商家：
            @foreach($event->singUpUser as $row)
                <ol>{{\App\Models\Event::singUpName($row->member_id)->name}}</ol>
                @endforeach
                </p>


                <p>开奖日期：{{$event->prize_date}}</p>


                @if($event->is_prize)
                    <p>
                        中奖名单：
                    @foreach($event->getPrize as $row)
                        <ol style="color: red;">{{\App\Models\Event::singUpName($row->member_id)->name}}  获得  {{$row->name}}</ol>
                        @endforeach
                        </p>
                        @endif
                        @if(!$event->is_prize)
                            <h2><a class="btn btn-success" href="{{route('event.lottery',[$event])}}" >点击开奖</a> </h2>
                        @endif
    </div>
</div>
@stop
@include('layout._showImg')