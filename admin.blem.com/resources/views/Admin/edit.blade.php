@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">管理员管理</a></li>
<li><a href="#">管理员列表</a></li>
<li><a href="#">更新管理员角色</a></li>
@stop
@section('content')
@include('layout._error')
    <form action="{{route('admin.update',[$admin])}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="username">重置角色</label><br>
            @foreach($rows as $row)
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox1" name="role[]" value="{{$row->name}}"
                    @if($admin->hasRole($row->name))
                        checked
                   @endif
                    > {{$row->name}}
                </label>
            @endforeach
        </div>
        {{csrf_field()}}
        {{method_field('patch')}}
        <button type="submit" class="btn btn-success col-md-1">确定重置</button>
    </form>
@stop
@include('layout._showImg')