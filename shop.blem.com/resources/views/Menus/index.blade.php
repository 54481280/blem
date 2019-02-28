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
                    <div class="col-md-offset-1 col-md-4 col-xs-12">
                        <button class="btn btn-success" onclick="location.href='{{route('menus.create')}}'"><span class="icon fa fa-plus"></span> 新增菜品分类</button>
                    </div>
                    <div class="col-md-3">
                        <form action="{{--{{route('menus.index',['id'=>$requret->id])}}--}}" method="get" class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" name="keyword" id="exampleInputEmail2" placeholder="请输入菜品分类名称">
                            </div>
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-primary"><span class="icon fa fa-search"></span></button>
                        </form>
                    </div>
                    <div class="col-md-3">
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
                       <th>菜品分类名称</th>
                       <th>分类编号</th>
                       <th>描述</th>
                       <th>是否默认分类</th>
                       <th>添加时间</th>
                       <th style="text-align: center">操作</th>
                   </tr>
                    @foreach($rows as $row)
                        <tr>
                            <td>{{$row->name}}</td>
                            <td>{{$row->type_accumulation}}</td>
                            <td>{{$row->description}}</td>
                            <td>{{$row->is_selected ? '是' : '否'}}</td>
                            <td>{{$row->created_at}}</td>
                            <td style="text-align: center">
                                <button class="btn btn-warning" title="更新" onclick="location.href='{{route('menus.edit',[$row])}}'"><span class="icon fa fa-pencil"></span> </button>
                                <form action="{{route('menus.destroy',[$row])}}" method="post" style="display: inline;">
                                    {{method_field('delete')}}
                                    {{csrf_field()}}
                                <button class="btn btn-danger" type="submit" title="删除"><span class="icon fa fa-trash"></span> </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>

                    <div style="float: right">
                        {{$rows->appends(['keyword'=>$keyword])->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

