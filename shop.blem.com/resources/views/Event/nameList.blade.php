@extends('layout.app')
@section('content')

    <div class="card-header">
        <div class="card-title">
            <div class="title" style="font-size: 24px">抽奖得奖名单</div>
        </div>
    </div>
    <div class="card-body">
        @foreach($rows as $row)
            <div class="jumbotron">
                <h2>{{$row->title}} <small style="font-size: 18px;"> 得奖名单</small></h2>
                <p>
                @foreach($row->getPrize as $up)
                    <ol style="color: orangered;">{{\App\Models\Event::singUpName($up->member_id)->name}} 获得 <b>{{$up->name}}</b></ol>
                    @endforeach
                </p>

            </div>
        @endforeach


    </div>


@stop


