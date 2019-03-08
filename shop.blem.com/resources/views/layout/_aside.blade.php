<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <div class="icon fa fa-paper-plane"></div>
                    <div class="title">商家平台</div>
                </a>
                <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                    <i class="fa fa-times icon"></i>
                </button>
            </div>
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{route('user.index')}}">
                        <span class="icon fa fa-tachometer"></span><span class="title">数据信息</span>
                    </a>
                </li>
                <li class="panel panel-default dropdown">
                    <a data-toggle="collapse" href="#dropdown-element">
                        <span class="icon fa fa-bars"></span><span class="title">菜品分类管理</span>
                    </a>
                    <!-- Dropdown level 1 -->
                    <div id="dropdown-element" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul class="nav navbar-nav">
                                <li><a href="{{route('menus.index')}}">分类列表</a>
                                </li>
                                <li><a href="{{route('menus.create')}}">新增菜品分类</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="panel panel-default dropdown">
                    <a data-toggle="collapse" href="#dropdown-table">
                        <span class="icon fa fa-leaf"></span><span class="title">菜品管理</span>
                    </a>
                    <!-- Dropdown level 1 -->
                    <div id="dropdown-table" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul class="nav navbar-nav">
                                @foreach(\App\Models\MenuCategories::cate() as $cate)
                                    <li><a href="{{route('menu.index',['id'=>$cate])}}">{{$cate->name}}</a></li>
                                @endforeach
                                <li><a href="{{route('menu.create')}}">新增菜品</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="panel panel-default dropdown">
                    <a data-toggle="collapse" href="#dropdown-form">
                        <span class="icon fa fa-cubes"></span><span class="title">平台活动</span>
                    </a>
                    <!-- Dropdown level 1 -->
                    <div id="dropdown-form" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul class="nav navbar-nav">
                                <li><a href="{{route('active.index')}}">正在进行的活动</a>
                                <li><a href="{{route('active.wait')}}">即将上线的活动</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Dropdown-->
                <li class="panel panel-default dropdown">
                    <a data-toggle="collapse" href="#component-example">
                        <span class="icon fa fa-file-text-o"></span><span class="title">订单管理</span>
                    </a>
                    <!-- Dropdown level 1 -->
                    <div id="component-example" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul class="nav navbar-nav">
                                <li><a href="{{route('order.index')}}">订单列表</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <!-- Dropdown-->
                <li class="panel panel-default dropdown">
                    <a data-toggle="collapse" href="#dropdown-example">
                        <span class="icon fa fa-slack"></span><span class="title">更多</span>
                    </a>
                    <!-- Dropdown level 1 -->
                    <div id="dropdown-example" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul class="nav navbar-nav">
                                <li><a href="Mores/index">主题化</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <!-- Dropdown-->
                <li class="panel panel-default dropdown">
                    <a data-toggle="collapse" href="#dropdown-icon">
                        <span class="icon fa fa-archive"></span><span class="title">Icons</span>
                    </a>
                    <!-- Dropdown level 1 -->
                    <div id="dropdown-icon" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul class="nav navbar-nav">
                                <li><a href="icons/glyphicons.html">Glyphicons</a>
                                </li>
                                <li><a href="icons/font-awesome.html">Font Awesomes</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="license.html">
                        <span class="icon fa fa-thumbs-o-up"></span><span class="title">License</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</div>


<div class="container-fluid">
    <div class="side-body">
        <div class="row nonediv">
            <div class="col-xs-12">
                <div class="card">
@include('layout._error'){{--提示--}}
@include('layout._tips')

