<?php /*a:2:{s:58:"themes/admin_simpleboot3/admin\statistics\onlin_curve.html";i:1609998753;s:80:"D:\phpstudy_pro\WWW\ThinkCMF\public/themes/admin_simpleboot3/public\headers.html";i:1610004213;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->
    <link href="/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/static/layui/css/layui.css" rel="stylesheet" type="text/css">
    <link href="/static/css/jedate.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        form .input-order {
            margin-bottom: 0px;
            padding: 0 2px;
            width: 42px;
            font-size: 12px;
        }

        form .input-order:focus {
            outline: none;
        }

        .table-actions {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 0px;
        }

        .table-list {
            margin-bottom: 0px;
        }

        .form-required {
            color: red;
        }
    </style>
    <?php $_app=app()->http->getName(); ?>
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/",
            WEB_ROOT: "/",
            JS_ROOT: "static/js/",
            APP: '<?php echo $_app; ?>'/*当前应用名*/
        };
    </script>
    <script src="/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/static/js/wind.js"></script>
    <script src="/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
    <script src="/static/js/layer/layer.js"></script>
    <script src="/static/js/laypage/laypage.js"></script>
    <script src="/static/js/laytpl/laytpl.js"></script>
    <script src="/static/js/echarts/echarts.min.js"></script>
    <script src="/static/js/jedate.js"></script>
    <script src="/static/js/vue.js"></script>
    <script src="/static/js/axios.min.js"></script>
    <script>
        Wind.css('artDialog');
        Wind.css('layer');
        $(function () {
            $("[data-toggle='tooltip']").tooltip({
                container:'body',
                html:true,
            });
            $("li.dropdown").hover(function () {
                $(this).addClass("open");
            }, function () {
                $(this).removeClass("open");
            });
        });
    </script>
    <?php if(APP_DEBUG): ?>
        <style>
            #think_page_trace_open {
                z-index: 9999;
            }
        </style>
    <?php endif; ?>

<style>
    td{
        text-align: center;
    }
</style>
<body class="gray-bg">
<div style="padding: 20px; background-color: #F2F2F2;" id="dailyStat">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    <div class="col-sm-2" style="font-weight: bold;color: red">在线人数统计</div>
                    <div class="col-sm-4">
                                <span class="input-group-btn" id="dateShowBtn" style="height: 50px;">
                                    <input type="text" name="start_time" id="dateSelectorTwo" lay-verify="date" placeholder="开始时间" autocomplete="off"
                                           class="form-control jeinput" value="<?php echo $start_time; ?>">
                                </span>
                        <span class="input-group-btn" id="dateShowBtn1" style="height: 50px;">
                                    <input type="text" name="end_time" id="dateSelectorTwo1" lay-verify="date" placeholder="结束时间" autocomplete="off" class="form-control jeinput" value="<?php echo $end_time; ?>">
                                </span>
                    </div>
                    <button class="layui-btn" @click="seach()">搜索</button></div>
                <div class="layui-card-body">
                    <div id="containertrend" style="border: 1px solid #e2e2e2;height: 600px"></div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>
<script type="text/javascript">
    var app = new Vue({
        el: '#dailyStat',
        data: {
            dateData: [],
            myChart: '',
            start_time: "<?php echo $start_time; ?>",
            end_time: "<?php echo $end_time; ?>",
        },
        created () {
            this.myChart = echarts.init(document.getElementById('containertrend'));
            this.get_data();
        },
        methods: {
            get_data() {
                let vm = this;
                axios
                    .post('/admin/statistics/onlin_curves',{start_time: '',end_time: ''})
                    .then(function (response) {
                        if(response.data.code ==1) {
                            vm.options(response.data.tdate,response.data.cont_f,response.data.cont_f1,response.data.cont_f2,response.data.cont_f3,response.data.cont_f4,response.data.cont_f5
                            ,response.data.cont_f6);
                        }else{

                        }
                        console.log(response);
                    })
                    .catch(function (error) { // 请求失败处理
                        console.log(error);
                    });
            },
            seach () {
                let vm = this;
                let start_time = $('#dateSelectorTwo').val();
                let end_time   = $('#dateSelectorTwo1').val();
                axios
                    .post('/admin/statistics/onlin_curves',{start_time: start_time,end_time: end_time})
                    .then(function (response) {
                        if(response.data.code==1) {
                            vm.options(response.data.tdate,response.data.cont_f,response.data.cont_f1,response.data.cont_f2,response.data.cont_f3,response.data.cont_f4,response.data.cont_f5
                                ,response.data.cont_f6);
                        }else{

                        }
                        console.log(response);
                    })
                    .catch(function (error) { // 请求失败处理
                        console.log(error);
                    });
            },
            options (dateData,cont_f,cont_f1,cont_f2,cont_f3,cont_f4,cont_f5,cont_f6) {
                let option = {
                    title: {
                        text: '每日数据统计',
                        subtext: '今日'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: ['总服在线人数', '1服', '2服', '3服', '4服', '5服', '6服']
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            dataZoom: {
                                yAxisIndex: 'none'
                            },
                            dataView: {readOnly: false},
                            magicType: {type: ['line', 'bar']},
                            restore: {},
                            saveAsImage: {}
                        }
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: dateData
                    },
                    yAxis: {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value} 人'
                        }
                    },
                    series: [
                        {
                            name: '总服在线人数',
                            type: 'line',
                            data: cont_f,
                            markPoint: {
                                data: [
                                    {type: 'max', name: '最大值'},
                                    {type: 'min', name: '最小值'}
                                ]
                            },
                            markLine: {
                                data: [
                                    {type: 'average', name: '平均值'}
                                ]
                            }
                        },
                        {
                            name: '1服',
                            type: 'line',
                            data: cont_f1,
                            markPoint: {
                                data: [

                                ]
                            },
                            markLine: {
                                data: [
                                    {type: 'average', name: '平均值'},
                                    [{
                                        symbol: 'none',
                                        x: '90%',
                                        yAxis: 'max'
                                    }, {
                                        symbol: 'circle',
                                        label: {
                                            position: 'start',
                                            formatter: '最大值'
                                        },
                                        type: 'max',
                                        name: '最高点'
                                    }]
                                ]
                            }
                        },
                        {
                            name: '2服',
                            type: 'line',
                            data: cont_f2,
                            markPoint: {
                                data: [
                                    {type: 'max', name: '最大值'},
                                    {type: 'min', name: '最小值'}
                                ]
                            },
                            markLine: {
                                data: [
                                    {type: 'average', name: '平均值'}
                                ]
                            }
                        },
                        {
                            name: '3服',
                            type: 'line',
                            data: cont_f3,
                            markPoint: {
                                data: [
                                    {type: 'max', name: '最大值'},
                                    {type: 'min', name: '最小值'}
                                ]
                            },
                            markLine: {
                                data: [
                                    {type: 'average', name: '平均值'}
                                ]
                            }
                        },
                        {
                            name: '4服',
                            type: 'line',
                            data: cont_f4,
                            markPoint: {
                                data: [
                                    {type: 'max', name: '最大值'},
                                    {type: 'min', name: '最小值'}
                                ]
                            },
                            markLine: {
                                data: [
                                    {type: 'average', name: '平均值'}
                                ]
                            }
                        },
                        {
                            name: '5服',
                            type: 'line',
                            data: cont_f5,
                            markPoint: {
                                data: [
                                    {type: 'max', name: '最大值'},
                                    {type: 'min', name: '最小值'}
                                ]
                            },
                            markLine: {
                                data: [
                                    {type: 'average', name: '平均值'}
                                ]
                            }
                        },
                        {
                            name: '6服',
                            type: 'line',
                            data: cont_f6,
                            markPoint: {
                                data: [
                                    {type: 'max', name: '最大值'},
                                    {type: 'min', name: '最小值'}
                                ]
                            },
                            markLine: {
                                data: [
                                    {type: 'average', name: '平均值'}
                                ]
                            }
                        }
                    ]
                }
                this.myChart.setOption(option);
            }
        },
        mounted:function(){
        }
    })
    jeDate("#dateSelectorTwo",{
        theme:{bgcolor:"#1ab394",pnColor:"#00CCFF"},
        format: "YYYY-MM-DD hh:mm:ss"
    });
    jeDate("#dateSelectorTwo1",{
        theme:{bgcolor:"#1ab394",pnColor:"#00CCFF"},
        format: "YYYY-MM-DD hh:mm:ss"
    });
</script>
</body>
</html>
