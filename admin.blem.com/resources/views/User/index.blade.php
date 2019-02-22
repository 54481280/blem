@extends('layout.list')
@section('CreateUrl'){{route('shop.create')}}@stop
@section('content')
@include('layout._tips')
    <table class="table table-hover" id="list">
        <tr>
            <th><input type="checkbox" name="ids" id="ids" value="0"> 序号</th>
            <th>商家账号</th>
            <th>商家邮箱</th>
            <th>关联商家</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($rows as $row)
        <tr class="active">
            <td style="line-height: 60px"><input type="checkbox" name="id" class="id" value="{{$row->id}}"> {{$row->id}}</td>
            <td style="line-height: 60px">{{$row->name}}</td>
            <td style="line-height: 60px">{{$row->email}}</td>
            <td style="line-height: 60px">{{$row->shops->shop_name}}</td>
            <td style="line-height: 60px">
                @if($row->status) <button class="btn btn-success btn-xs">启用</button>
                @else <button class="btn btn-xs">禁用</button>
                    @endif
            </td>
            <td style="line-height: 60px">
                @if($row->status)
                    <button class="btn" title="禁用" onclick="location.href='{{route('user.status',[$row])}}'"><span class="glyphicon glyphicon-edit"></span></button>
                @else
                    <button class="btn btn-primary" title="启用" onclick="location.href='{{route('user.status',[$row])}}'"><span class="glyphicon glyphicon-check"></span></button>
                @endif
                    <button class="btn btn-warning" title="重置密码" onclick="location.href='{{route('user.edit',[$row])}}'"><span class="glyphicon glyphicon-lock"></span></button>
                    <form action="{{route('shop.destroy',[$row])}}" method="post" style="display: inline">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <div style="float: right">
        {{$rows->appends(['keyword'=>$keyword])->links()}}
    </div>
@stop

