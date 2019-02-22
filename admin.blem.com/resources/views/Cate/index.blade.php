@extends('layout.list')
@section('CreateUrl'){{route('shop.create')}}@stop
@section('content')
@include('layout._tips')
    <table class="table table-hover" id="list">
        <tr>
            <th><input type="checkbox" name="ids" id="ids" value="0"> 序号</th>
            <th>商家分类名称</th>
            <th>商家分类图</th>
            <th>最近修改时间</th>
            <th>添加时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($rows as $row)
        <tr class="active">
            <td style="line-height: 60px"><input type="checkbox" name="id" class="id" value="{{$row->id}}"> {{$row->id}}</td>
            <td style="line-height: 60px">{{$row->name}}</td>
            <td style="line-height: 60px"><img src="{{$row->img()}}" width="60" height="60"/> </td>
            <td style="line-height: 60px">{{$row->updated_at}}</td>
            <td style="line-height: 60px">{{$row->created_at}}</td>
            <td style="line-height: 60px">
                @if($row->status) <button class="btn btn-success btn-xs">显示</button>
                @else <button class="btn btn-xs">隐藏</button>
                    @endif
            </td>
            <td style="line-height: 60px">
                @if($row->status)
                    <button class="btn" title="隐藏" onclick="location.href='{{route('shop.status',[$row])}}'"><span class="glyphicon glyphicon-edit"></span></button>
                @else
                    <button class="btn btn-primary" title="显示" onclick="location.href='{{route('shop.status',[$row])}}'"><span class="glyphicon glyphicon-check"></span></button>
                @endif
                    <button class="btn btn-warning" title="编辑" onclick="location.href='{{route('shop.edit',[$row])}}'"><span class="glyphicon glyphicon-pencil"></span></button>
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

