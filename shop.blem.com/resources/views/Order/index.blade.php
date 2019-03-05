@extends('layout.app')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="card">

                <div class="card-header">
                    <div class="card-title">
                        <div class="title" style="font-size: 24px">订单列表</div>
                    </div>
                </div>

                <div class="card-body" style="margin-bottom: 50px">
                    <div class="col-md-offset-1 col-md-2">
                        <button class="btn btn-success" onclick="location.href='{{route('menu.create')}}'"><span class="icon fa fa-plus"></span> 新增菜品</button>
                    </div>
                    <div class="col-md-6">

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
                       <th>订单编号</th>
                       <th>收货人姓名</th>
                       <th>收货人电话</th>
                       <th>送达地址</th>
                       <th>购买商品信息</th>
                       <th>价格</th>
                       <th>下单时间</th>
                       <th>状态</th>
                       <th style="text-align: center">操作</th>
                   </tr>
                    @foreach($rows as $row)
                        <tr name="{{$row->id}}">
                            <td>
                                <div class="checkbox3 checkbox-inline checkbox-check checkbox-light">
                                    <input type="checkbox" id="checkbox-fa-light-{{$row->id}}" class="delId" value="{{$row->id}}">
                                    <label for="checkbox-fa-light-{{$row->id}}">
                                    </label>
                                </div>
                            </td>
                            <td>{{$row->sn}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->tel}}</td>
                            <td>{{$row->address}}</td>
                            <td>

                                @for($i=0;$i<count($row->goods_name);$i++)
                                    {{$row->goods_name[$i]}} * {{$row->amount[$i]}}
                                @endfor

                            </td>
                            <td>{{$row->total}}</td>
                            <td>{{$row->created_at}}</td>
                            <td>
                                @if($row->status == -1)
                                    <button class="btn btn-default btn-xs">已取消</button>
                                @elseif($row->status == 0)
                                    <button class="btn btn-primary btn-xs">待支付</button>
                                @elseif($row->status == 1)
                                    <button class="btn btn-danger btn-xs">待发货</button>
                                @elseif($row->status == 2)
                                    <button class="btn btn-warning btn-xs">待确认</button>
                                @elseif($row->status == 3)
                                    <button class="btn btn-success btn-xs">已完成</button>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <button class="btn btn-success Upsta" title="更新订单" data-toggle="modal" data-target="#myModal"><span class="icon fa fa-gavel"></span> </button>
                            </td>
                        </tr>
                    @endforeach
                </table>

                    <div style="float: right">
                        {{--{{$rows->links()}}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">重新确认订单状态</h4>
                </div>
                <div class="modal-body">
                    <style>
                        .status button{
                            margin-left: 10px;
                        }
                    </style>
                    <div class="status" style="padding: 0 150px">
                        <button class="Upsta2 btn btn-danger" onclick="location.href=Order/status?status=-1">取消订单</button>
                        <button class="Upsta2 btn btn-primary" onclick="location.href=Order/status?status=2">商家发货</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消操作</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.Upsta').on('click',function(){
            var id = $(this).closest('tr').attr('name');
            $('.Upsta2').each(function(){
                var str = $(this).attr('onclick');
                str = str.replace('.href=','.href=\'');
                $(this).attr('onclick',str+'&id='+id+'\'');
            })
        })
    </script>
@include('layout._moreDel');{{--批量删除--}}
@stop

