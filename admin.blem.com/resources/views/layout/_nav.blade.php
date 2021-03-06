<div class="col-md-2 aside">
    <div class="row col-md-12 as-top"><span class="glyphicon glyphicon-tower"></span>    后台系统</div>
    <div class="row col-md-12 as-nav" style="padding:0px;margin: 0px;">
        <ul>
            @foreach(\App\Models\Nav::navData() as $row)
                @if(auth()->user()->hasAnyPermission($row->permission_id))
            <li><span class="glyphicon glyphicon-{{$row->span}}"></span><a href="{{$row->url}}">{{$row->name}}</a></li>
                @endif
            @endforeach
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
    <div class="row content">
        <div class="col-md-12" style="margin-top:20px">
            <ol class="breadcrumb">
                <li><a href="#">后台系统</a></li>
                @yield('path')
            </ol>
        </div>