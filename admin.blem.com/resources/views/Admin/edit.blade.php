@extends('layout.form')
@section('content')
@include('layout._error')
    <form action="{{route('admin.update',[$admin])}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="email">管理员邮箱</label>
            <input type="text" class="form-control" id="email" name="email" value="{{$admin->email}}" placeholder="请输入密码">
        </div>
        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定重置</button>
    </form>
@stop
@include('layout._showImg')