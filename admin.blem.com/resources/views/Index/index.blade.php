@include('layout._head'){{--页面头部--}}
@include('layout._nav2'){{--页面导航--}}
<script src="https://cdn.bootcss.com/echarts/4.1.0.rc1/echarts.min.js"></script>

<div class="row">
    <div class="col-md-6" style="padding-left: 50px">
        <h3><small>平台近一周的订单数据</small></h3>
        <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
        <div id="main" style="width: 800px;height:350px;"></div>
        <script type="text/javascript">
            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById('main'));

            // 指定图表的配置项和数据
            var option = {
                tooltip: {},
                legend: {
                    data:['订单量']
                },
                xAxis: {
                    data: {!! json_encode(array_keys($data['weekAll'])) !!}
                },
                yAxis: {},
                series: [{
                    name: '订单量',
                    type: 'bar',
                    data: {!! json_encode(array_values($data['weekAll'])) !!}
                }]
            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        </script>
    </div>

    <div class="col-md-6">
        <h3><small>平台近三月的订单数据</small></h3>
        <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
        <div id="main2" style="width: 600px;height:350px;"></div>
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
                    data:{!! json_encode(array_keys($data['monthAll'])) !!}
                },
                series: [
                    {
                        name:'订单量',
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
                            @foreach($data['monthAll'] as $k=>$v)
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

    <div class="col-md-6" style="padding-left: 50px">
        <h3><small>平台近一周的订单数据(按商家)</small></h3>
        <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
        <div id="main3" style="width: 750px;height:400px;"></div>
        <script type="text/javascript">
            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById('main3'));

            // 指定图表的配置项和数据
            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:{!! json_encode(array_keys($data['weekShopsAll'])) !!}
                },
                grid: {
                    left: '5%',
                    right: '6%',
                    bottom: '5%',
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
                    data: {!! json_encode(array_keys($data['weekAll'])) !!},
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                        @foreach($data['weekShopsAll'] as $k => $v)
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

    <div class="col-md-6">
        <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
        <h3><small>平台近三月的订单数据(按商家)</small></h3>
        <div id="main4" style="width: 600px;height:400px;"></div>
        <script type="text/javascript">
            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById('main4'));

            // 指定图表的配置项和数据
            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:{!! json_encode(array_keys($data['monthShopsAll'])) !!}
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
                    data: {!! json_encode(array_keys($data['monthAll'])) !!},
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                        @foreach($data['monthShopsAll'] as $k => $v)
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

@include('layout._end'){{--页面结束功能--}}
@include('layout._foot'){{--页面尾部--}}