@extends('layout.list')

@can('添加商家分类')
@section('CreateUrl'){{route('shop.create')}}@stop{{--添加链接--}}
@section('CreateStr')新增商家分类@stop{{--添加语--}}
@else
@section('CreateStr')商家分类@stop{{--添加语--}}
@endcan



@section('logo_search') glyphicon-align-justify @stop{{--图标--}}
@section('SearchUrl'){{route('shop.index')}}@stop{{--搜索链接--}}
@section('Search')搜索商家分类@stop{{--提示语--}}
@section('path'){{--页面位置--}}
    <li><a href="#">商家分类管理</a></li>
    <li><a href="#">商家分类列表</a></li>
@stop

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
            <td style="line-height: 60px"><img src="{{$row->img}}" width="60" height="60"/> </td>
            <td style="line-height: 60px">{{$row->updated_at}}</td>
            <td style="line-height: 60px">{{$row->created_at}}</td>
            <td style="line-height: 60px">
                @if($row->status) <button class="btn btn-success btn-xs">显示</button>
                @else <button class="btn btn-xs">隐藏</button>
                    @endif
            </td>
            <td style="line-height: 60px">
                @can('修改商家分类状态')
                @if($row->status)
                    <button class="btn" title="隐藏" onclick="location.href='{{route('shop.status',[$row])}}'"><span class="glyphicon glyphicon-edit"></span></button>
                @else
                    <button class="btn btn-primary" title="显示" onclick="location.href='{{route('shop.status',[$row])}}'"><span class="glyphicon glyphicon-check"></span></button>
                @endif
                @endcan
                @can('修改商家分类')
                    <button class="btn btn-warning" title="编辑" onclick="location.href='{{route('shop.edit',[$row])}}'"><span class="glyphicon glyphicon-pencil"></span></button>
                    @endcan

                    @can('删除商家分类	')
                    <form action="{{route('shop.destroy',[$row])}}" method="post" style="display: inline">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    <button class="btn btn-danger" title="删除"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
                        @endcan
            </td>
        </tr>
        @endforeach
    </table>
    <div style="float: right">
        {{$rows->appends(['keyword'=>$keyword])->links()}}
    </div>
@stop

