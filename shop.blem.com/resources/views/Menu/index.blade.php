@extends('layout.app')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="card">

                <div class="card-header">
                    <div class="card-title">
                        <div class="title" style="font-size: 24px">菜品分类列表</div>
                    </div>
                </div>

                <div class="card-body" style="margin-bottom: 50px">
                    <div class="col-md-offset-1 col-md-2">
                        <button class="btn btn-success" onclick="location.href='{{route('menu.create')}}'"><span class="icon fa fa-plus"></span> 新增菜品</button>
                        <button class="btn btn-danger" onclick="moreDelete()"><span class="icon fa fa-institution"></span> 批量删除</button>
                    </div>
                    <div class="col-md-6">
                        <form action="{{route('menu.index')}}" method="get" class="form-inline">
                            <div class="form-group">
                                <button class="btn btn-info">价格区间</button>
                                <input type="hidden" name="id" value="{{$request->id}}">
                                <input type="text" class="form-control"  name="min" id="" placeholder="请输入价格（最低价格）">
                                <input type="text" class="form-control" name="max" id="" placeholder="请输入价格（最高价格）">
                                <input type="text" class="form-control" style="margin-left: 20px" name="keyword" id="exampleInputEmail2" placeholder="请输入菜品名称">
                            </div>
                            <button type="submit" class="btn btn-primary"><span class="icon fa fa-search"></span></button>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <div style="float: right">
                            <button class="btn btn-default" title="返回上一页" onclick="javascript:history.go(-1)"><span class="icon fa fa-mail-reply-all"></span></button>
                            <button class="btn btn-success" title="刷新本页面" onclick="window.location.reload()"><span class="icon fa fa-refresh"></span></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-body" style="margin-bottom: 50px">
                <table class="table table-bordered">
                   <tr>
                       <th>
                           <div class="checkbox3 checkbox-inline checkbox-check checkbox-light">
                               <input type="checkbox" id="moreDelete">
                               <label for="moreDelete">
                               </label>
                           </div>
                       </th>
                       <th>菜品名称</th>
                       <th>菜品图片</th>
                       <th>菜品分类</th>
                       <th>价格</th>
                       <th>月销量</th>
                       <th>评分数量</th>
                       <th>满意度数量</th>
                       <th>状态</th>
                       <th style="text-align: center">操作</th>
                   </tr>
                    @foreach($rows as $row)
                        <tr>
                            <td>
                                <div class="checkbox3 checkbox-inline checkbox-check checkbox-light">
                                    <input type="checkbox" id="checkbox-fa-light-{{$row->id}}" class="delId" value="{{$row->id}}">
                                    <label for="checkbox-fa-light-{{$row->id}}">
                                    </label>
                                </div>
                            </td>
                            <td>{{$row->goods_name}}</td>
                            <td><img src="{{$row->goods_img}}" width="60" height="60"/> </td>
                            <td>{{$row->Catemenus->name}}</td>
                            <td>{{$row->goods_price}}</td>
                            <td>{{$row->month_sales}}</td>
                            <td>{{$row->rating_count}}</td>
                            <td>{{$row->satisfy_count}}</td>
                            <td>
                                @if($row->status)
                                    <button class="btn btn-success btn-xs">启用</button>
                                @else
                                    <button class="btn btn-danger btn-xs">禁用</button>
                                @endif
                            </td>
                            <td style="text-align: center">
                                @if($row->status)
                                <button class="btn btn-danger" title="禁用" onclick="location.href='{{route('status',[$row])}}'"><span class="icon fa fa-close"></span> </button>
                                @else
                                <button class="btn btn-success" title="启用" onclick="location.href='{{route('status',[$row])}}'"><span class="icon fa fa-check"></span> </button>
                                @endif
                                <button class="btn btn-warning" title="更新" onclick="location.href='{{route('menu.edit',[$row])}}'"><span class="icon fa fa-pencil"></span> </button>
                                <form action="{{route('menu.destroy',[$row])}}" method="post" style="display: inline;">
                                    {{method_field('delete')}}
                                    {{csrf_field()}}
                                <button class="btn btn-danger" type="submit" title="删除"><span class="icon fa fa-trash"></span> </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>

                    <div style="float: right">
                        {{$rows->appends($data)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('layout._moreDel');{{--批量删除--}}
@stop

