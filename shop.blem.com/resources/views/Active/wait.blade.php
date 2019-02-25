@extends('layout.app')
@section('content')

    <div class="card-header">
        <div class="card-title">
            <div class="title" style="font-size: 24px">即将上线的活动</div>
        </div>
    </div>
    <div class="card-body">
        @foreach($waitActives as $w)
            <div class="jumbotron">
                <h2>{{$w->title}}<small style="font-size: 18px;"> 活动时间：{{$w->start}} 即将上线</small></h2>
                <p>{!! $w->content !!}</p>
                <p><a class="btn btn-danger btn-lg" href="#" role="button">即将上线：{{$w->start_time}}</a></p>
            </div>
        @endforeach


    </div>


@stop


