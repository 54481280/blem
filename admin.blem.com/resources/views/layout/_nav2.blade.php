<div class="col-md-2 aside">
    <div class="row col-md-12 as-top"><span class="glyphicon glyphicon-tower"></span>    后台系统</div>
    <div class="row col-md-12 as-nav" style="padding:0px;margin: 0px;">
        <ul>
        @foreach(\App\Models\Nav::navData() as $row)
                @if(auth()->user()->hasAnyPermission($row->permission_id))
                <li><span class="glyphicon glyphicon-{{$row->span}}"></span><a href="{{$row->url}}">{{$row->name}}</a></li>
                @endif
            @endforeach
            {{--<li><span class="glyphicon glyphicon-globe"></span><a href="index">系统数据</a></li>--}}
            {{--<li><span class="glyphicon glyphicon-education"></span><a href="{{route('admin.index')}}">管理员管理</a></li>--}}
            {{--<li><span class="glyphicon glyphicon-align-justify"></span><a href="{{route('shop.index')}}">商家分类管理</a></li>--}}
            {{--<li><span class="glyphicon glyphicon-tags"></span><a href="{{route('shops.index')}}">商家信息管理</a></li>--}}
            {{--<li><span class="glyphicon glyphicon-user"></span><a href="{{route('user.index')}}">商家账户管理</a></li>--}}
            {{--<li><span class="glyphicon glyphicon-th-large"></span><a href="{{route('active.index')}}">商家活动管理</a></li>--}}
            {{--<li><span class="glyphicon glyphicon-star"></span><a href="{{route('member.index')}}">会员管理</a></li>--}}
            {{--<li><span class="glyphicon glyphicon-briefcase"></span><a href="{{route('permission.index')}}">权限管理</a></li>--}}
            {{--<li><span class="glyphicon glyphicon-knight"></span><a href="{{route('role.index')}}">角色管理</a></li>--}}
            {{--<li><span class="glyphicon glyphicon-option-horizontal"></span><a href="{{route('nav.index')}}">菜单管理</a></li>--}}
        </ul>
    </div>
</div>

<div class="col-md-10 section">
    <div class="row col-md-12" style="background-color: #adbaa7;height: 50px;margin: 0px">
        <ul class="adm">
            <li><a href="#">
                    <img src="/images/00.jpg" alt="加载中..." width="40" class="img-circle" title="用户名">
                </a></li>
            <li style="position: relative">
                <a href="#" id="on_set"><span class="glyphicon glyphicon-cog"></span></a>
                <ul class="set" id="set" style="left: -80px">
                    <li><a href="{{route('admin.show',[\Illuminate\Support\Facades\Auth::user()->id])}}" class="set_a" style="font-size: 15px;background-color:#8CBFC7;display: block;width:200px;height: 100%;color: #333;text-decoration: none;"><span class="glyphicon glyphicon-user"></span> 个人中心</a></li>
                    <li><a href="{{route('logout')}}" class="set_a" style="font-size: 15px;background-color:#8CBFC7;display: block;width:200px;height: 100%;color: #333;text-decoration: none;"><span class="glyphicon glyphicon-log-in"></span> 退出登录</a></li>
                </ul>
            </li>
        </ul>
    </div>
