@extends('layout.form')
@section('content')
   <p>{{$shop->shop_name}}</p>
   <p>{{$shop->cate->name}}</p>
   <p><img src="{{$shop->img()}}" width="100" height="100"/> </p>
   <p>{{$shop->shop_rating}}</p>
   <p>{{$shop->brand}}</p>
   <p>{{$shop->on_time}}</p>
   <p>{{$shop->fengniao}}</p>
   <p>{{$shop->bao}}</p>
   <p>{{$shop->piao}}</p>
   <p>{{$shop->zhun}}</p>
   <p>{{$shop->start_send}}</p>
   <p>{{$shop->send_cost}}</p>
   <p>{{$shop->notice}}</p>
   <p>{{$shop->discount}}</p>
   <p>{{$shop->status}}</p>
   <p>{{$shop->updated_at}}</p>
   <p>{{$shop->created_at}}</p>
@stop
@include('layout._showImg')