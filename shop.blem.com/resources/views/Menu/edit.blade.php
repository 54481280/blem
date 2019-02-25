@extends('layout.app')
@section('content')

    <div class="row" id="upPwdForm">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title col-md-6">
                        <div class="title" style="font-size: 24px;line-height: 80px">新增菜品</div>


                    </div>
                    <div class="col-md-5">
                        <div style="float: right;line-height: 100px">
                            <button class="btn btn-default" title="返回上一页" onclick="javascript:history.go(-1)"><span class="icon fa fa-mail-reply-all"></span></button>
                            <button class="btn btn-success" title="刷新本页面" onclick="window.location.reload()"><span class="icon fa fa-refresh"></span></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{route('menu.update',[$menu])}}" method="post" enctype="multipart/form-data">
                        <div class="sub-title">菜品名称</div>
                        <div>
                            <input type="text" class="form-control" name="goods_name" value="{{$menu->goods_name}}" placeholder="请输入菜品名称">
                        </div>
                        <div class="sub-title">菜品图片</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div id="uploader-demo">
                                    <!--用来存放item-->
                                    <div id="fileList" class="uploader-list"></div>
                                    <div id="filePicker">选择图片</div>
                                    <input type="hidden" name="goods_img" id="img_path"/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <img src="{{$menu->goods_img}}" id="autoImg" width="100" height="100" id="default">
                            </div>
                        </div>

                        <div class="sub-title">菜品分类</div>
                        <div class="row">
                            <div class="col-md-5">
                                <select name="category_id" class="form-control">
                                    @foreach($rows as $row)
                                        <option value="{{$row->id}}" @if($menu->category_id == $row->id) selected @endif>{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-7"></div>
                        </div>
                        <div class="sub-title">菜品价格</div>
                        <div>
                            <input type="text" class="form-control" name="goods_price" value="{{$menu->goods_price}}" placeholder="请输入菜品价格">
                        </div>
                        <div class="sub-title">评分</div>
                        <div>
                            <input type="text" class="form-control" name="rating" value="{{$menu->rating}}" placeholder="请输入菜品评分">
                        </div>
                        <div class="sub-title">是否上架</div>
                        <div>
                            <div class="radio3 radio-check radio-success radio-inline">
                                <input type="radio" id="radio5" name="status" value="1" @if($menu->status) checked @endif>
                                <label for="radio5">
                                    是
                                </label>
                            </div>
                            <div class="radio3 radio-check radio-inline">
                                <input type="radio" id="radio6" name="status" value="0" @if(!$menu->status) checked @endif>
                                <label for="radio6">
                                    否
                                </label>
                            </div>
                        </div>
                        <div class="sub-title">提示信息</div>
                        <div>
                            <textarea class="form-control" name="tips" rows="3">{{$menu->tips}}</textarea>
                        </div>
                        <div class="sub-title">描述</div>
                        <div>
                            <textarea class="form-control" name="description" rows="3">{{$menu->description}}</textarea>
                        </div>
                        {{csrf_field()}}
                        {{method_field('patch')}}
                        <button class="btn btn-success" type="submit">确认更新</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layout._showImg')
@stop


