@extends('layout.app')
@section('content')
    <script src="https://cdn.bootcss.com/echarts/4.1.0.rc1/echarts.min.js"></script>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="side-body padding-top">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="#">
                        <div class="card red summary-inline">
                            <div class="card-body">
                                <i class="icon fa fa-shopping-cart fa-4x"></i>
                                <div class="content">
                                    <div class="title">{{$data['orderNum']}}</div>
                                    <div class="sub-title">累计订单量</div>
                                </div>
                                <div class="clear-both"></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="#">
                        <div class="card yellow summary-inline">
                            <div class="card-body">
                                <i class="icon fa fa-send fa-4x"></i>
                                <div class="content">
                                    <div class="title">{{$data['successOrderNum']}}</div>
                                    <div class="sub-title">成功订单量</div>
                                </div>
                                <div class="clear-both"></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="#">
                        <div class="card green summary-inline">
                            <div class="card-body">
                                <i class="icon fa fa-shopping-cart fa-4x"></i>
                                <div class="content">
                                    <div class="title">{{$data['goodsNum']}}</div>
                                    <div class="sub-title">累计销售商品量</div>
                                </div>
                                <div class="clear-both"></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="#">
                        <div class="card blue summary-inline">
                            <div class="card-body">
                                <i class="icon fa fa-cny fa-4x"></i>
                                <div class="content">
                                    <div class="title">{{$data['money']}}</div>
                                    <div class="sub-title">累计收入</div>
                                </div>
                                <div class="clear-both"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="page-header">
                <h1>图表信息 <small>我们商铺的整体数据</small></h1>
            </div>
           {{--图表--}}
            <div class="row">
                {{--近一周--}}
                <div class="col-sm-6 col-xs-12">
                    <h3>最近一周<small> 订单数量</small></h3>
                    <div id="main" style="width: 800px;height:400px;"></div>
                    <script type="text/javascript">
                        // 基于准备好的dom，初始化echarts实例
                        var myChart = echarts.init(document.getElementById('main'));

                        // 指定图表的配置项和数据
                        var option = {
                            xAxis: {
                                type: 'category',
                                data: {!! json_encode(array_keys($data['week'])) !!}
                            },
                            yAxis: {
                                type: 'value'
                            },
                            series: [{
                                data: {!! json_encode(array_values($data['week'])) !!},
                                type: 'line'
                            }]
                        };

                        // 使用刚指定的配置项和数据显示图表。
                        myChart.setOption(option);
                    </script>
                </div>

                {{--近三月--}}
                <div class="col-sm-6 col-xs-12">
                    <h3>最近三月<small> 订单数量</small></h3>
                    <div id="main2" style="width: 800px;height:400px;"></div>
                    <script type="text/javascript">
                        // 基于准备好的dom，初始化echarts实例
                        var myChart = echarts.init(document.getElementById('main2'));

                        // 指定图表的配置项和数据
                        var option = {
                            tooltip: {
                                trigger: 'item',
                                formatter: "{a} <br/>{b}: {c} ({d}%)"
                            },
                            legend: {
                                orient: 'vertical',
                                x: 'left',
                                data:{!! json_encode(array_keys($data['month'])) !!}
                            },
                            series: [
                                {
                                    name:'订单数量',
                                    type:'pie',
                                    radius: ['50%', '70%'],
                                    avoidLabelOverlap: false,
                                    label: {
                                        normal: {
                                            show: false,
                                            position: 'center'
                                        },
                                        emphasis: {
                                            show: true,
                                            textStyle: {
                                                fontSize: '30',
                                                fontWeight: 'bold'
                                            }
                                        }
                                    },
                                    labelLine: {
                                        normal: {
                                            show: false
                                        }
                                    },
                                    data:[
                                        @foreach($data['month'] as $k => $v)
                                        {value:{{$v}}, name:'{{$k}}'},
                                        @endforeach
                                    ]
                                }
                            ]
                        };

                        // 使用刚指定的配置项和数据显示图表。
                        myChart.setOption(option);
                    </script>
                </div>
            </div>

            <div class="row">
                {{--近一周--}}
                <div class="col-sm-6 col-xs-12">
                    <h3>最近一周<small> 菜品销量</small></h3>

                    <div id="main3" style="width: 800px;height:400px;"></div>
                    <script type="text/javascript">
                        // 基于准备好的dom，初始化echarts实例
                        var myChart = echarts.init(document.getElementById('main3'));

                        // 指定图表的配置项和数据
                        var option = {
                            tooltip: {
                                trigger: 'axis'
                            },
                            legend: {
                                data:{!! json_encode(array_keys($data['menuWeek'])) !!}
                            },
                            grid: {
                                left: '3%',
                                right: '4%',
                                bottom: '3%',
                                containLabel: true
                            },
                            toolbox: {
                                feature: {
                                    saveAsImage: {}
                                }
                            },
                            xAxis: {
                                type: 'category',
                                boundaryGap: false,
                                data: {!! json_encode(array_keys($data['week'])) !!},
                            },
                            yAxis: {
                                type: 'value'
                            },
                            series: [
                                @foreach($data['menuWeek'] as $k => $v)
                                {
                                    name:'{{$k}}',
                                    type:'line',
                                    stack: '总量',
                                    data:{!! json_encode(array_values($v)) !!}
                                },
                                @endforeach
                            ]
                        };

                        // 使用刚指定的配置项和数据显示图表。
                        myChart.setOption(option);
                    </script>
                </div>

                {{--近三月--}}
                <div class="col-sm-6 col-xs-12">
                    <h3>最近三月<small> 菜品销量</small></h3>
                    <div id="main4" style="width: 800px;height:400px;"></div>
                    <script type="text/javascript">
                        // 基于准备好的dom，初始化echarts实例
                        var myChart = echarts.init(document.getElementById('main4'));

                        // 指定图表的配置项和数据
                        var option = {
                            tooltip: {
                                trigger: 'axis'
                            },
                            legend: {
                                data:{!! json_encode(array_keys($data['menuMonth'])) !!}
                            },
                            grid: {
                                left: '3%',
                                right: '4%',
                                bottom: '3%',
                                containLabel: true
                            },
                            toolbox: {
                                feature: {
                                    saveAsImage: {}
                                }
                            },
                            xAxis: {
                                type: 'category',
                                boundaryGap: false,
                                data: {!! json_encode(array_keys($data['month'])) !!},
                            },
                            yAxis: {
                                type: 'value'
                            },
                            series: [
                                    @foreach($data['menuMonth'] as $k => $v)
                                {
                                    name:'{{$k}}',
                                    type:'line',
                                    stack: '总量',
                                    data:{!! json_encode(array_values($v)) !!}
                                },
                                @endforeach
                            ]
                        };

                        // 使用刚指定的配置项和数据显示图表。
                        myChart.setOption(option);
                    </script>
                </div>
            </div>
           {{--图表--}}
        </div>
    </div>
@stop

