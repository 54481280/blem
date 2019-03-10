@extends('layout.app')
@section('content')

    <div class="card-header">
        <div class="card-title">
            <div class="title" style="font-size: 24px">抽奖活动列表</div>
        </div>
    </div>
    <div class="card-body">
        @foreach($rows as $row)
            <div class="jumbotron">
                <h2>{{$row->title}} <small style="font-size: 18px;"> 报名时间: {{date("Y-m-d H:i:s",$row->signup_start)}} 至 {{date("Y-m-d H:i:s",$row->signup_end)}} </small></h2>
                <p>{!! $row->content !!}</p>
                <p>限制报名人数：{{$row->signup_num}}</p>
                <p>奖品：
                @foreach($row->getPrize as $r)
                    <ol>{{$r->name}}</ol>
                    @endforeach
                    </p>
                    <p>开奖日期：{{$row->prize_date}}</p>
                <p>
                    @if(time()>$row->signup_start)
                    <a class="btn btn-danger btn-lg" href="{{route('event.singUp',[$row])}}" role="button">点击报名</a>
                    @else
                    <a class="btn btn-primary btn-lg" href="#" role="button">敬请期待</a>
                    @endif
                </p>
            </div>
        @endforeach


    </div>


@stop


