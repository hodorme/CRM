<extend name="Public/hplus" />
<block name="main">
    <script charset="utf-8" src="__ADDONS__/Echarts/echarts.common.min.js"></script>
    <div class="col-md-12 ibox-content">
        <div class="col-md-6">
            <div class="text-center">
                <div id="topup" style="width: 100%;height:400px;"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <div id="yyer" style="width: 100%;height:400px;"></div>
            </div>
        </div>
    </div>
    <hr />
    <div class="col-md-12 ibox-content">
        <div class="col-md-6">
            <div class="text-center">
                <div id="tosales" style="width: 100%;height:400px;"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <div id="tosalesinfo" style="width: 100%;height:400px;"></div>
            </div>
        </div>
    </div>
    <hr />
    <div class="col-md-12 ibox-content">
        <div class="col-md-12">
            <div class="text-center">
                <div id="zhuanhualv" style="width: 100%;height:400px;"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <div id="guadan" style="width: 100%;height:400px;"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <div id="kehu" style="width: 100%;height:400px;"></div>
            </div>
        </div>
    </div>
        <hr />
        <div class="col-md-12 ibox-content">
            <div class="col-md-6">
                <div class="text-center">
                    <div id="stuan" style="width: 100%;height:400px;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-center">
                    <div id="sex" style="width: 100%;height:400px;"></div>
                </div>
            </div>
        </div>
        <script>
            var myChart = echarts.init(document.getElementById('topup'));
            myChart.setOption({
                toolbox: {
                    show : true,
                    feature : {
                        saveAsImage : {show: true}
                    }
                },
                title: {
                    text: '2016年营业额增长率最高的展会（单位：元人民币）',
                    subtext: '',
                    x:'left'
                },
                grid: {
                    left: '2%',
                    right: '2%',
                    bottom: '2%',
                    containLabel: true
                },
                xAxis: {
                    data: ["2015年5月迪拜汽配展","2016年5月迪拜汽配展"]
                },
                yAxis: {},
                series: [
                    {
                        name: '2015年',
                        type: 'line',
                        label: {
                            normal: {
                                show: true,
                                position: 'top'
                            }
                        },
                        data: [3479147.92,5637482.7]

                    }
                ]
            });
            var myChart = echarts.init(document.getElementById('yyer'));
            myChart.setOption({
                title: {
                    text: '2016年项目营业额成交量最高三家客户',
                    subtext: '',
                    x:'left'
                },
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                legend: {
                    left: 'right',
                    data:['会展服务','展示设计']
                },
                grid: {
                    left: '2%',
                    right: '2%',
                    bottom: '2%',
                    containLabel: true
                },
                xAxis : [
                    {
                        type : 'category',
                        data : ['山东永泰集团','百达维斯公关','昊华轮胎']
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'会展服务',
                        type:'bar',
                        stack: '合计',
                        label: {
                            normal: {
                                show: true,
                                position: 'inside'
                            }
                        },
                        data:[558003,0,605880]
                    },
                    {
                        name:'展示设计',
                        type:'bar',
                        stack: '合计',
                        label: {
                            normal: {
                                show: true,
                                position: 'inside'
                            }
                        },
                        data:[794839,988869,379200]
                    }
                ]
            });
            var myChart = echarts.init(document.getElementById('tosales'));
            myChart.setOption({
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'line'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                toolbox: {
                    show : true,
                    feature : {
                        saveAsImage : {show: true}
                    }
                },
                title: {
                    text: '2016年项目到账金额最大的销售（单位：元人民币）',
                    subtext: '',
                    x:'left'
                },
                grid: {
                    left: '2%',
                    right: '2%',
                    bottom: '2%',
                    containLabel: true
                },
                xAxis: {
                    data: ["王娟娟","方柳青"]
                },
                yAxis: {},
                series: [
                    {
                        name: '到账',
                        type: 'bar',
                        label: {
                            normal: {
                                show: true,
                                position: 'top'
                            }
                        },
                        data: [8269100.1,4906611.2]
                    }
                ]
            });
            var myChart = echarts.init(document.getElementById('tosalesinfo'));
            myChart.setOption({
                toolbox: {
                    show : true,
                    feature : {
                        saveAsImage : {show: true}
                    }
                },
                title: {
                    text: '王娟娟的签约客户分析',
                    subtext: '',
                    x:'left'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },

                calculable : true,
                series : [
                    {
                        name:'2015',
                        type:'pie',
                        radius : [50, 100],
                        center : ['25%', '50%'],
                        roseType : 'radius',
                        label: {
                            normal: {
                                show: true
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        lableLine: {
                            normal: {
                                show: true
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        data:[
                            {value:67, name:'老客户'},
                            {value:33, name:'新客户'}
                        ]
                    },
                    {
                        name:'2016',
                        type:'pie',
                        radius : [50, 100],
                        center : ['75%', '50%'],
                        roseType : 'radius',
                        data:[
                            {value:51, name:'2015年以前还持续合作'},
                            {value:2, name:'2015年持续合作'}
                        ]
                    }
                ]
            });
            var myChart = echarts.init(document.getElementById('zhuanhualv'));
            myChart.setOption({
                title: {
                    text: '2016年度展示设计事业部转化率',
                    subtext: '',
                    x:'left'
                },
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                legend: {
                    left: 'right',
                    data:['挂单','有效订单']
                },
                grid: {
                    left: '2%',
                    right: '2%',
                    bottom: '2%',
                    containLabel: true
                },
                xAxis : [
                    {
                        type : 'category',
                        data : ['一部34.84% ','二部16.77% ','三部15.52% ','四部11.65%']
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'挂单',
                        type:'bar',
                        stack: '合计',
                        label: {
                            normal: {
                                show: true,
                                position: 'inside'
                            }
                        },
                        data:[606,541,283,311]
                    },
                    {
                        name:'有效订单',
                        type:'bar',
                        stack: '合计',
                        label: {
                            normal: {
                                show: true,
                                position: 'top'
                            }
                        },
                        data:[324,109,52,41]
                    }
                ]
            });
            // 挂单原因分析
            var myChart = echarts.init(document.getElementById('guadan'));
            myChart.setOption({
                title : {
                    text: '挂单分析',
                    subtext: '',
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'right',
                    data: ['价格原因','位置原因','跟同行签约','销售问题','设计不通过','取消特装']
                },
                series : [
                    {
                        name: '占比',
                        type: 'pie',
                        radius : '60%',
                        center: ['50%', '60%'],
                        data:[
                            {value:23, name:'价格原因'},
                            {value:3, name:'位置原因'},
                            {value:16, name:'跟同行签约'},
                            {value:42, name:'销售问题'},
                            {value:14, name:'设计不通过'},
                            {value:2, name:'取消特装'}
                        ],
                        itemStyle : {
//                            normal : {
//                                label : {
//                                    position : 'inner',
//                                    formatter : function (params) {
//                                        return (params.percent - 0).toFixed(0) + '%'
//                                    }
//                                },
//                                labelLine : {
//                                    show : true
//                                }
//                            },
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            });
            // 挂单原因分析
            var myChart = echarts.init(document.getElementById('kehu'));
            myChart.setOption({
                title : {
                    text: '星级客户分布',
                    subtext: '',
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'right',
                    data: ['一星(1-10万)','二星(10-30万)','三星(30万以上)']
                },
                series : [
                    {
                        name: '占比',
                        type: 'pie',
                        radius : '70%',
                        center: ['50%', '60%'],
                        data:[
                            {value:459, name:'一星(1-10万)'},
                            {value:55, name:'二星(10-30万)'},
                            {value:4, name:'三星(30万以上)'}
                        ],
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            });
            // 随团人员
            var myChart = echarts.init(document.getElementById('stuan'));
            myChart.setOption({
                title : {
                    text: '随团人员年龄段分析(2015年对比2016年)',
                    subtext: '',
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    x : 'center',
                    y : 'bottom',
                    data:['90后','80后','70后','60后']
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        //dataView : {show: true, readOnly: false},
                        magicType : {
                            show: true,
                            type: ['pie', 'funnel']
                        },
                        //restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                series : [
                    {
                        name:'2015',
                        type:'pie',
                        radius : [20, 110],
                        center : ['25%', '50%'],
                        roseType : 'radius',
                        label: {
                            normal: {
                                show: true
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        lableLine: {
                            normal: {
                                show: true
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        data:[
                            {value:115, name:'90后'},
                            {value:1195, name:'80后'},
                            {value:262, name:'70后'},
                            {value:115, name:'60后'}
                        ]
                    },
                    {
                        name:'2016',
                        type:'pie',
                        radius : [30, 110],
                        center : ['75%', '50%'],
                        roseType : 'radius',
                        data:[
                            {value:234, name:'90后'},
                            {value:1280, name:'80后'},
                            {value:115, name:'70后'},
                            {value:246, name:'60后'}
                        ]
                    }
                ]
            });
            // 随团人员男女
            var myChart = echarts.init(document.getElementById('sex'));
            myChart.setOption({
                title : {
                    text: '随团人员男女性别分析(2015年对比2016年)',
                    subtext: '',
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    x : 'center',
                    y : 'bottom',
                    data:['男','女']
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        //dataView : {show: true, readOnly: false},
                        magicType : {
                            show: true,
                            type: ['pie', 'funnel']
                        },
                        //restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                series : [
                    {
                        name:'2015',
                        type:'pie',
                        radius : [50, 100],
                        center : ['25%', '50%'],
                        roseType : 'radius',
                        label: {
                            normal: {
                                show: true
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        lableLine: {
                            normal: {
                                show: true
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        data:[
                            {value:63, name:'男'},
                            {value:37, name:'女'}
                        ]
                    },
                    {
                        name:'2016',
                        type:'pie',
                        radius : [50, 100],
                        center : ['75%', '50%'],
                        roseType : 'radius',
                        data:[
                            {value:64, name:'男'},
                            {value:36, name:'女'}
                        ]
                    }
                ]
            });
        </script>
</block>
