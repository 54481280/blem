@extends('layout.app')
@section('content')

    <div class="card-header">
        <div class="card-title">
            <div class="title" style="font-size: 24px">进行中的活动</div>
        </div>
    </div>
    <div class="card-body">
        @foreach($runActives as $r)
            <div class="jumbotron">
                <h2>{{$r->title}}<small style="font-size: 18px;"> 活动时间：{{$r->start}} 至 {{$r->end_time}}</small></h2>
                <p>{!! $r->content !!}</p>
                <p><a class="btn btn-danger btn-lg" href="#" role="button">结束时间：{{$r->end_time}}</a></p>
            </div>
        @endforeach


    </div>


@stop


