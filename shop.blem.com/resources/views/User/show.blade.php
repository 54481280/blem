@extends('layout.app')
@section('content')


    <!-- Main Content -->
    <div class="container-fluid">
        <div class="side-body">
            <div class="row nonediv">
                <div class="col-xs-12">
                    <div class="card">
                        @include('layout._error'){{--提示--}}
                        @include('layout._tips')
                        <div class="card-header">
                            <div class="card-title">
                                <div class="title" style="font-size: 24px">商家信息</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="page-header">
                                <h1>商家店铺名称： <small>{{auth()->user()->shops->shop_name}}</small></h1>
                            </div>

                                <h3 class="col-md-12">商家LOGO： <small><img src="/images/00.jpg" width="80" height="80"/></small></h3>
                                <h3 class="col-md-6">店铺类别： <small>{{auth()->user()->shops->shop_category_id}}</small></h3>
                                <h3 class="col-md-6">店铺评分： <small>{{auth()->user()->shops->shop_rating}} 分</small></h3>
                                <h3 class="col-md-12" style="border-bottom: 2px solid #eee"></h3>

                                <h3 class="col-md-4">是否品牌： <small>@if(auth()->user()->shops->brand)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</small></h3>
                                <h3 class="col-md-4">是否准时送达： <small>@if(auth()->user()->shops->on_time)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</small></h3>
                                <h3 class="col-md-4">是否蜂鸟配送： <small>@if(auth()->user()->shops->fengniao)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</small></h3>
                                <h3 class="col-md-4">是否保标记： <small>@if(auth()->user()->shops->bao)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</small></h3>
                                <h3 class="col-md-4">是否票标记： <small>@if(auth()->user()->shops->piao)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</small></h3>
                                <h3 class="col-md-4">是否准标记： <small>@if(auth()->user()->shops->zhun)<span class="glyphicon glyphicon-ok"></span>@else<span class="glyphicon glyphicon-remove"></span>@endif</small></h3>
                                <h3 class="col-md-12" style="border-bottom: 2px solid #eee"></h3>

                                <h3 class="col-md-6">起送金额： <small>{{auth()->user()->shops->start_send}} <span class="glyphicon glyphicon-yen"></span> </small></h3>
                                <h3 class="col-md-6">配送费： <small>{{auth()->user()->shops->send_cost}} <span class="glyphicon glyphicon-yen"></span></small></h3>
                                <h3 class="col-md-12" style="border-bottom: 2px solid #eee"></h3>

                                <h3 class="col-md-12">店公告： <small>{{auth()->user()->shops->notice}}</small></h3>
                                <h3 class="col-md-12">优惠信息： <small>{{auth()->user()->shops->discount}}</small></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row nonediv">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="title" style="font-size: 24px">商家个人信息</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="sub-title">账户名称</div>
                            <div>
                                <input type="text" class="form-control" value="{{auth()->user()->name}}" disabled placeholder="Text input">
                            </div>
                            <div class="sub-title">账户邮箱</div>
                            <div>
                                <input type="text" class="form-control" name="email" value="{{auth()->user()->email}}" disabled placeholder="Text input">
                            </div><br/>

                            {{--修改密码--}}
                            <button class="btn btn-info" id="Pwd">点击此处修改密码</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="upPwdForm" style="display: none">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="title" style="font-size: 24px">修改个人密码</div>
                            </div>
                        </div>
                        <div class="card-body">

                            {{--修改密码表单--}}
                            <form action="{{route('user.update',[auth()->user()])}}" method="post" >
                                <div class="sub-title">原始密码</div>
                                <div>
                                    <input type="password" class="form-control" name="oldPwd" placeholder="请输入原始密码">
                                </div>
                                <div class="sub-title">新密码</div>
                                <div>
                                    <input type="password" class="form-control" name="password" placeholder="请输入新密码">
                                </div>
                                <div class="sub-title">再次密码</div>
                                <div>
                                    <input type="password" class="form-control" name="password2" placeholder="请再次输入密码">
                                </div>
                                <div class="sub-title">验证码</div>
                                <div>
                                    <input type="text" class="form-control" name="captcha" placeholder="请再次输入验证码"><br/>
                                </div>
                                <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                                {{csrf_field()}}
                                {{method_field('patch')}}
                                <button class="btn btn-success" type="submit">确认修改</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@stop


