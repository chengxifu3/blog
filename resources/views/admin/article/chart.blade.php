@extends('admin.layout.layout')
@section('content')
    <style>
        .page-item {
            display: inline-block;
        }
    </style>
    <body>

    <form method="post" action="" id="listform">
        <div class="panel admin-panel">
            <div class="panel-head"><strong class="icon-reorder"> 内容列表</strong> <a href=""
                                                                                   style="float:right; display:none;">添加字段</a>
            </div>

            <div id="chartmain" style="width:600px; height: 400px;"></div>
        </div>
    </form>
    <script type="text/javascript">
        read();
        function read() {
            $.ajax({
                url: "{{url('admin/art/chart_list')}}",
                type: 'get',
                dataType: 'json',
                data: null,
                success: function (res) {
                    //app.title = res.title;
                    var nameData = '[';
                    var numData = '[';
                    for (var i = 0; i < res.result.name.length; i++) {
                        nameData += "'" + res.result.name[i] + "',";
                        numData += res.result.num[i] + ",";
                    }
                    nameData = nameData.substring(0, nameData.length - 1);
                    numData = numData.substring(0, numData.length - 1);
                    nameData += ']';
                    numData += ']';

                    var option = {
                        color: ['#3398DB'],
                        title: {
                            text: res.title
                        },
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                                type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                            }
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        xAxis: [
                            {
                                type: 'category',
                                data: nameData,
                                axisTick: {
                                    alignWithLabel: true
                                }
                            }
                        ],
                        yAxis: [
                            {
                                type: 'value'
                            }
                        ],
                        series: [
                            {
                                name: '直接访问',
                                type: 'bar',
                                barWidth: '60%',
                                data: numData
                            }
                        ]
                    };

                    //初始化echarts实例
                    var myChart = echarts.init(document.getElementById('chartmain'));

                    //使用制定的配置项和数据显示图表
                    myChart.setOption(option);


                }
            });
        }

    </script>
    </body>
@endsection