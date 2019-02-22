@extends('layout.list')
@section('CreateUrl'){{route('shops.create')}}@stop
@section('content')
@include('layout._tips')
    <table class="table table-hover" id="list">
        <tr>
            <th><input type="checkbox" name="ids" id="ids" value="0"> 序号</th>
            <th>商家分类</th>
            <th>商家名称</th>
            <th>商家图片</th>
            <th>是否品牌</th>
            <th>评分</th>
            <th>入驻时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($rows as $row)
        <tr class="active">
            <td style="line-height: 60px"><input type="checkbox" name="id" class="id" value="{{$row->id}}"> {{$row->id}}</td>
            <td style="line-height: 60px">{{$row->cate->name}}</td>
            <td style="line-height: 60px">{{$row->shop_name}}</td>
            <td style="line-height: 60px"><img src="{{$row->img()}}" width="60" height="60"/> </td>
            <td style="line-height: 60px">{{$row->brand ? '品牌' : '非品牌'}}</td>
            <td style="line-height: 60px">{{$row->shop_rating}}</td>
            <td style="line-height: 60px">{{$row->created_at}}</td>
            <td style="line-height: 60px">
                @if($row->status == 1) <button class="btn btn-success btn-xs">正常</button>
                @elseif($row->status == 0) <button class="btn btn-xs">待审核</button>
                @elseif($row->status == -1) <button class="btn-danger btn-xs">禁用</button>
                @endif
            </td>
            <td style="line-height: 60px">
                @if($row->status == 0)
                <button class="btn" title="验证审核" onclick="location.href='{{route('shops.status',[$row])}}';"><span class="glyphicon glyphicon-minus"></span></button>
                @elseif($row->status == 1)
                <button class="btn btn-primary" title="禁用" onclick="location.href='{{route('shops.status',[$row])}}';"><span class="glyphicon glyphicon-ok"></span></button>
                @elseif($row->status == -1)
                <button class="btn btn-danger" title="启用" onclick="location.href='{{route('shops.status',[$row])}}';"><span class="glyphicon glyphicon-remove"></span></button>
                @endif

                <button class="btn btn-success" title="查看详情" onclick="location.href='{{route('shops.show',[$row])}}'"><span class="glyphicon glyphicon-eye-open"></span></button>
                <button class="btn btn-warning" title="编辑" onclick="location.href='{{route('shops.edit',[$row])}}'"><span class="glyphicon glyphicon-pencil"></span></button>
                <form action="{{route('shop.destroy',[$row])}}" method="post" style="display: inline">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    <button class="btn btn-danger" title="删除"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    <div style="float: right">
        {{$rows->appends(['keyword'=>$keyword])->links()}}
    </div>


@stop

