@extends('layout.app')
@section('content')

    <div class="row" id="upPwdForm">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title col-md-6">
                        <div class="title" style="font-size: 24px;line-height: 80px">新增菜品分类</div>


                    </div>
                    <div class="col-md-5">
                    <div style="float: right;line-height: 100px">
                        <button class="btn btn-default" title="返回上一页" onclick="javascript:history.go(-1)"><span class="icon fa fa-mail-reply-all"></span></button>
                        <button class="btn btn-success" title="刷新本页面" onclick="window.location.reload()"><span class="icon fa fa-refresh"></span></button>
                    </div>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{route('menus.store')}}" method="post">
                        <div class="sub-title">菜品分类名称</div>
                        <div>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="请输入菜品分类名称">
                        </div>
                        <div class="sub-title">菜品编号</div>
                        <div>
                            <input type="text" class="form-control" name="type_accumulation" value="{{old('type_accumulation')}}" placeholder="请输入菜品编号">
                        </div>
                        <div class="sub-title">是否默认分类</div>
                        <div>
                            <div class="radio3 radio-check radio-success radio-inline">
                                <input type="radio" id="radio5" name="is_selected" value="1" @if(old('is_selected')) checked @endif>
                                <label for="radio5">
                                    是
                                </label>
                            </div>
                            <div class="radio3 radio-check radio-inline">
                                <input type="radio" id="radio6" name="is_selected" value="0" @if(!old('is_selected')) checked @endif>
                                <label for="radio6">
                                    否
                                </label>
                            </div>
                        </div>
                        <div class="sub-title">菜品分类描述</div>
                        <div>
                            <textarea class="form-control" name="description" rows="3">{{old('description')}}</textarea>
                        </div>
                        {{csrf_field()}}
                        <button class="btn btn-success" type="submit">确认新增</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop


