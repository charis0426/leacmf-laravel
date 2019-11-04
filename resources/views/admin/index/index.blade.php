<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>监管页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
    <link id="layuicss-layer" rel="stylesheet"
          href="/static/layuiadmin/layui/css/modules/layer/default/layer.css?v=3.1.1" media="all">
    <link rel="stylesheet" href="/static/layuiadmin/style/common.css" media="all">
    <link rel="stylesheet" href="/static/admin/plugins/font/iconfont.css" media="all">
</head>
<style>
    .count-events .layui-col-md3 .layui-card .layui-card-header {
        height: 30px !important;
        border: none !important;
        font-size: 16px;
        color: #fff;
    }

    .count-events > div:nth-child(1) > div {
        background: #66a5e3;
    }

    .count-events > div:nth-child(2) > div {
        background: #ffa31a;
    }

    .count-events > div:nth-child(3) > div {
        background: #d175d1;
    }

    .count-events > div:nth-child(4) > div {
        background: #47a375;
    }

    .layuiadmin-card-list {
        padding: 0 10px 0 10px !important;
    }

    .layuiadmin-card-list p.layuiadmin-big-font {
        color: #fff !important;
        font-size: 26px !important;
        text-align: right;
    }

    .jindu .layui-form-item {
        margin-bottom: 0px !important;
        padding-left: 10px !important;
        margin-right: 20px;
    }

    .jindu .layui-form-item .bl {
        float: right;
    }

    .jindu .layui-form-item .layui-form-label {
        width: 40px !important;
        height: 20px !important;
        color: #787878;
        padding: 0px !important;

    }

    .jindu .layui-form-item .layui-input-block {
        margin-left: 40px;
        margin-right: 45px;
        min-height: 20px !important;
        max-height: 20px !important;
        height: 20px !important;
    }

    .layui-progress {
        height: 10px !important;
        top: 5px;
    }

    .layui-progress-bar {
        background: #54b6ff;
        height: 10px !important;
    }

    .index-left, .index-right {
        height: 100%;
        padding-top: 25px !important;
    }

    .count-events {
        margin-top: -25px !important;
    }

    .right-top {
        height: 33.33%;
    }

    .right-top:nth-child(1) {
        margin-top: -20px;
    }

    .right-top:nth-child(2) {
        margin-top: 10px;
    }

    .right-top:nth-child(3) {
        margin-top: 10px;
    }

    .right-top > div {
        width: 100%;
        height: 100%;
        border: 1px solid #e4e4e4;
    }

    .layui-fluid .x-body {
        height: calc(100% - 20px) !important;
        height: -moz-calc(100% - 20px) !important;
        height: -webkit-calc(100% - 20px) !important;
    }

    .index-right .right-top > div .top-title {
        color: #505050;
        font-size: 16px;
        padding: 10px 0px 10px 10px;
        font-weight: 600;
        height: 20px;
    }

    .index-right .right-top > div .jindu {
        height: calc(100% - 40px) !important;
        height: -moz-calc(100% - 40px) !important;
        height: -webkit-calc(100% - 40px) !important;
        overflow-y: auto;
    }

    .index-right .right-top > div .jindu::-webkit-scrollbar { /*滚动条整体样式*/
        width: 5px; /*高宽分别对应横竖滚动条的尺寸*/
        height: 1px;
    }

    .index-right .right-top > div .jindu::-webkit-scrollbar-thumb { /*滚动条里面小方块*/
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        background: #535353;
    }

    .index-right .right-top > div .jindu::-webkit-scrollbar-track { /*滚动条里面轨道*/
        -webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        background: #EDEDED;
    }

    .echart {
        width: 100%;
        height: 100%;
    }

    .event-text {
        height: calc(100% - 61px) !important;
        height: -moz-calc(100% - 61px) !important;
        height: -webkit-calc(100% - 61px) !important;
    }

    .events-list {
        padding: 10px 10px 10px 0px;
        height: 50%;
    }

    .events-list > div {
        height: 100%;
    }

    .events-list > div .layui-card {
        border: 1px solid #e4e4e4;
        -moz-box-shadow: 1px 1px 3px 0px #e4e4e4;
        -webkit-box-shadow: 1px 1px 3px 0px #e4e4e4;
        box-shadow: 1px 1px 3px 0px #e4e4e4;
        height: 100%;
    }

    .event-text .layui-col-md3 {
        height: 100%;
        padding-top: 40px;
    }

    .events-list > div .layui-card .layui-card-header {
        font-weight: 600;
        color: #505050;
        font-size: 16px;
        border-bottom: 0px;
    }

    .event-card-body {
        height: calc(100% - 62px) !important;
        height: -moz-calc(100% - 62px) !important;
        height: -webkit-calc(100% - 62px) !important;
        overflow-y: auto;
        font-size: 14px;
        line-height: 16px;
    }

    .new-icon {
        width: 8px;
        height: 8px;
        background: #66a5e3;
        margin-top: 3px;
        float: left;
    }

    .event-card-body:nth-child(2) > p {
        margin-left: 10px;
    }

    .event-text .layui-col-md9 {
        height: 100%;
    }

    #map {
        height: 100%;
        width: 100%;
    }

    .event-card-body::-webkit-scrollbar { /*滚动条整体样式*/
        width: 5px; /*高宽分别对应横竖滚动条的尺寸*/
        height: 1px;
    }

    .event-card-body::-webkit-scrollbar-thumb { /*滚动条里面小方块*/
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        background: #535353;
    }

    .event-card-body::-webkit-scrollbar-track { /*滚动条里面轨道*/
        -webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        background: #EDEDED;
    }

    .event-card-body .event-info > p {
        margin-left: 10px;
    }

    .event-card-body .event-info {
        margin-bottom: 10px;
    }
</style>
<body layadmin-themealias="default">
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div class="layui-row layui-col-space20 x-body" style="margin: 10px;">
        <div class="layui-col-md9 index-left">
            <div class="layui-row layui-col-space10 count-events">
                <div class="layui-col-md3">
                    <div class="layui-card">
                        <div class="layui-card-header">
                            转运中心接入数量
                        </div>
                        <div class="layui-card-body layuiadmin-card-list">
                            <p class="layuiadmin-big-font" v-text="event_1?event_1:'0'"></p>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md3">
                    <div class="layui-card">
                        <div class="layui-card-header">
                            点位接入数量
                        </div>
                        <div class="layui-card-body layuiadmin-card-list">
                            <p class="layuiadmin-big-font" v-text="event_2?event_2:'0'"></p>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md3">
                    <div class="layui-card">
                        <div class="layui-card-header">
                            作业监管总数
                        </div>
                        <div class="layui-card-body layuiadmin-card-list">
                            <p class="layuiadmin-big-font" v-text="event_3?event_3:'0'"></p>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md3">
                    <div class="layui-card">
                        <div class="layui-card-header">
                            视频巡检总数
                        </div>
                        <div class="layui-card-body layuiadmin-card-list">
                            <p class="layuiadmin-big-font" v-text="event_4?event_4:'0'"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-row event-text">
                <div class="layui-col-md3">
                    <div class="layui-row events-list" style="    margin-top: -40px;">
                        <div class="layui-col-md12">
                            <div class="layui-card">
                                <div class="layui-card-header">
                                    作业违规监管最新事件
                                </div>
                                <div class="layui-card-body event-card-body">
                                    <div style="margin-bottom: 10px;border:1px solid #D9D9D9;padding: 5px"
                                         v-for="vo,id in DynamicEventZNs">
                                        <img :src="'data:image/png;base64,'+vo.Img"
                                             style="width: 100%;height: 100px;margin-bottom: 10px;" alt="">
                                        {{--                                        组织结构名称: 北京东区邮政管理局<br>--}}
                                        {{--                                        监管对象名称: 中关村投递部<br>--}}
                                        {{--                                        监管对象类型: 网点<br>--}}
                                        事件上报设备: @{{ vo.CameraName }}<br>
                                        事&nbsp;&nbsp;件&nbsp;&nbsp;类&nbsp;&nbsp;&nbsp;型: @{{ vo.EventType }}<br>
                                        事件上报时间: @{{ vo.CreatedTime }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-row events-list">
                        <div class="layui-col-md12">
                            <div class="layui-card">
                                <div class="layui-card-header">
                                    视频巡检监管最新事件
                                </div>
                                <div class="layui-card-body event-card-body">
                                    <div class="event-info" v-for="vo,id in DynamicEventXJs">
                                        <i class="new-icon"></i>
                                        {{--                                        <p>组织结构名称: 北京东区邮政管理局</p>--}}
                                        {{--                                        <p>监管对象名称: 中关村投递部</p>--}}
                                        {{--                                        <p>监管对象类型: 网点</p>--}}
                                        <p>事件上报设备: @{{ vo.CameraName }}</p>
                                        <p>事&nbsp;&nbsp;件&nbsp;&nbsp;类&nbsp;&nbsp;&nbsp;型: @{{vo.EventType }}</p>
                                        <p>事件上报时间: @{{ vo.CreatedTime }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md9">
                    <div id="map"></div>
                </div>
            </div>
        </div>
        <div class="layui-col-md3 index-right">
            <div class="layui-col-md12 right-top">
                <div>
                    <div class="top-title">
                        企业事件排行TOP10
                    </div>
                    <div class="jindu layui-form">
                        <div class="layui-form-item" v-for="vo,id in EventTop10" v-if="vo.Name && id<10">
                            <label class="layui-form-label" v-text="vo.Name">北京</label>
                            <label class="layui-form-label bl" v-text="vo.Value+'%'">90%</label>
                            <div class="layui-input-block">
                                <div class="layui-progress">
                                    <div class="layui-progress-bar" :lay-percent="vo.Value+'%'"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-col-md12 right-top">
                <div>
                    <div id='event_1' class="echart">
                    </div>
                </div>
            </div>
            <div class="layui-col-md12 right-top">
                <div>
                    <div id='event_2' class="echart">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/layer.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>
<script src="/static/admin/plugins/font/iconfont.js"></script>
<script src="/static/layuiadmin/echarts.js"></script>
<script src="/static/layuiadmin/china.js"></script>
<script>
    console.log('{{Session::get('socket_token')}}');
    new Vue({
        el: '#app',
        data: function () {
            return {
                element: null,
                canvas_task: null,
                canvas_inspection: null,
                canvas_map: null,
                setTime: null,
                event_1: 0,
                event_2: 0,
                event_3: 0,
                event_4: 0,
                EventTop10: {},
                IMapsInfo: {},
                TimeETypeCount: {},
                DynamicEventZNs: {},
                DynamicEventXJs: {},
                load_gif: true,
                path: "{{Session::get('socket_adr')}}",
                socket: ""
            }
        },
        methods: {
            drawMap: function () {
                var div = document.getElementById('map')
                this.setCharts(div, 'map')
                echarts.dispose(div);
                var obj = echarts.init(div);

                //转运中心接入数量
                this.event_1 = window.localStorage.getItem('TransitCenterNums');
                //点位接入数量
                this.event_2 = window.localStorage.getItem('DotsNums');
                //作业监管总数
                this.event_3 = window.localStorage.getItem('ZNNums');
                //视频巡检总数
                this.event_4 = window.localStorage.getItem('XJNums');
                //视频巡检监管最新事件
                this.DynamicEventXJs = JSON.parse(window.localStorage.getItem('DynamicEventXJs'));
                //作业违规监管最新事件
                this.DynamicEventZNs = JSON.parse(window.localStorage.getItem('DynamicEventZNs'));
                //各省事件top10
                this.EventTop10 = JSON.parse(window.localStorage.getItem('EventTop10'));
                if (this.EventTop10) {
                    for (var i in this.EventTop10) {
                        if (this.EventTop10[i].Name) {
                            //省市名称
                            var name = this.EventTop10[i].Name.substring(0, 2);
                            if (name == '黑龙' || name == '内蒙') {
                                this.EventTop10[i].Name = this.EventTop10[i].Name.substring(0, 3);
                            } else {
                                this.EventTop10[i].Name = name;
                            }
                            // 事件百分比
                            this.EventTop10[i].Value = this.EventTop10[i].Value / 100;
                        }
                    }
                }
                //地图数据
                this.IMapsInfo = JSON.parse(window.localStorage.getItem('IMapsInfo'));
                var series = [], mydata = [];
                if (this.IMapsInfo) {
                    for (var i in this.IMapsInfo) {
                        if (this.IMapsInfo[i].Name) {
                            var name = this.IMapsInfo[i].Name.substring(0, 2);
                            if (name == '黑龙' || name == '内蒙') {
                                this.IMapsInfo[i].name = this.IMapsInfo[i].Name.substring(0, 3);
                            } else {
                                this.IMapsInfo[i].name = name;
                            }
                            mydata.push({
                                name: this.IMapsInfo[i].name,
                                value: this.IMapsInfo[i].Value
                            });
                        }
                    }
                    series = {
                        name: 'china',
                        type: 'map',
                        mapType: 'china',
                        roam: false,
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    textStyle: {
                                        color: "black"
                                    }
                                }
                            },
                            emphasis: {label: {show: true}}
                        },
                        data: mydata
                    };
                }
                if (series) {
                    var optionMap = {
                        backgroundColor: '#FFFFFF',
                        title: {
                            text: '',
                            subtext: '',
                            x: 'center'
                        },
                        tooltip: {
                            trigger: 'item',
                            position: function (point, params, dom, rect, size) {
                                var html = ' <ul id="plan"><li><span>' + params.name + ': ' + params.value + '</span></li></ul>';
                                $(dom).html(html);
                            },
                        },
                        //左侧小导航图标
                        visualMap: {
                            show: true,
                            x: 'left',
                            y: 'bottom',
                            splitList: [
                                {start: 500}, {start: 400, end: 500},
                                {start: 300, end: 400}, {start: 200, end: 300},
                                {start: 100, end: 200}, {end: 100},
                            ],
                            color: ['#5475f5', '#9feaa5', '#85daef', '#74e2ca', '#e6ac53', '#9fb5ea']
                        },

                        //配置属性
                        series: series,
                    };
                    obj.setOption(optionMap);
                    this.canvas_map = obj
                }
            },
            setCharts: function (obj, id) {
                obj.setAttribute("width", $("#" + id + "").width() + 'px')
                obj.setAttribute("height", Math.round($("#" + id + "").height()) + 'px')
            },
            cavasLine: function (id) {
                var div = document.getElementById(id);
                this.setCharts(div, id);
                var that = this;
                echarts.dispose(div);
                var obj = echarts.init(div);
                var map = {"event_1": "作业监管事件统计", "event_2": "视频巡检事件统计"};
                //按天推送数据
                this.TimeETypeCount = JSON.parse(window.localStorage.getItem('TimeETypeCount'));
                var EventTypes = [];
                if (id === "event_1") {
                    EventTypes = this.TimeETypeCount[4].TimeEventTypes[0];
                } else if (id === 'event_2') {
                    EventTypes = this.TimeETypeCount[4].TimeEventTypes[1];
                }
                var data = [];
                if (EventTypes) {
                    for (var i in EventTypes.TimeCounts) {
                        data.push({
                            name: EventTypes.TimeCounts[i].Ctime,
                            value: [
                                EventTypes.TimeCounts[i].Ctime,
                                EventTypes.TimeCounts[i].Value
                            ]
                        });
                    }
                }
                var option = {
                    title: {
                        text: map[id]
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            params = params[0];
                            var date = new Date();
                            return params.name + '：' + params.value[1];
                        },
                        axisPointer: {
                            animation: false
                        }
                    },
                    xAxis: {
                        type: 'time',
                        splitLine: {
                            show: false
                        }
                    },
                    yAxis: {
                        type: 'value',
                        boundaryGap: [0, '100%'],
                        splitLine: {
                            show: false
                        }
                    },
                    series: [{
                        name: '模拟数据',
                        type: 'line',
                        showSymbol: false,
                        hoverAnimation: false,
                        data: data
                    }]
                };

                obj.setOption(option);
                if (id === "event_1") {
                    this.canvas_task = obj
                } else if (id === 'event_2') {
                    this.canvas_inspection = obj
                }

            },
            init: function () {
                if (typeof (WebSocket) === "undefined") {
                    alert("您的浏览器不支持socket")
                } else {
                    // 实例化socket
                    this.socket = new WebSocket(this.path);
                    // 监听socket连接
                    this.socket.onopen = this.open;
                    // 监听socket错误信息
                    this.socket.onerror = this.error;
                    // 监听socket消息
                    this.socket.onmessage = this.getMessage;
                }
            },
            open: function () {
                console.log("socket连接成功");
                this.send();
            },
            error: function () {
                console.log("连接错误")
            },
            getMessage: function (msg) {
                var sData = msg.data;
                if (msg.data) sData = JSON.parse(sData);
                if (sData.AllNums) window.localStorage.setItem('AllNums', sData.AllNums);
                if (sData.DynamicEventXJs) window.localStorage.setItem('DynamicEventXJs', JSON.stringify(sData.DynamicEventXJs));
                if (sData.DynamicEventZNs) window.localStorage.setItem('DynamicEventZNs', JSON.stringify(sData.DynamicEventZNs));
                if (sData.EventTop10) window.localStorage.setItem('EventTop10', JSON.stringify(sData.EventTop10));
                if (sData.EventTypes) window.localStorage.setItem('EventTypes', JSON.stringify(sData.EventTypes));
                if (sData.IMapsInfo) window.localStorage.setItem('IMapsInfo', JSON.stringify(sData.IMapsInfo));
                if (sData.TimeETypeCount) window.localStorage.setItem('TimeETypeCount', JSON.stringify(sData.TimeETypeCount));
                if (sData.XJNums) window.localStorage.setItem('XJNums', sData.XJNums);
                if (sData.ZNNums) window.localStorage.setItem('ZNNums', sData.ZNNums);
                if (sData.DotsNums) window.localStorage.setItem('DotsNums', sData.DotsNums);
                if (sData.TransitCenterNums) window.localStorage.setItem('TransitCenterNums', sData.TransitCenterNums);
                this.$nextTick(function () {
                    layui.use(['laydate', 'element'], function () {
                        var element = layui.element;
                        element.render()
                    });
                    this.drawMap();
                    this.cavasLine('event_1');
                    this.cavasLine('event_2');
                })
            },
            send: function () {
                var map = {};
                map['Action'] = "heart";
                map['Message'] = "1";
                map['DataType'] = 2;
                this.socket.send(JSON.stringify(map))
            },
            close: function () {
                console.log("socket已经关闭")
            }
        },
        mounted: function () {
            $("#load_gif").hide();
            $("#app").show();
            this.$nextTick(function () {
                layui.use(['laydate', 'element'], function () {
                    var element = layui.element;
                    element.render()
                });
                //先清除保存的所有缓存
                //window.localStorage.clear();
                //执行websocket
                if (this.path) this.init();
                var that = this;
                $(window).resize(function () {
                    that.canvas_task.resize();
                    that.canvas_inspection.resize();
                    that.canvas_map.resize();
                })

                $(window).unload(function () {
                    if (that.socket != "") {
                        that.socket.onclose = that.close
                    }
                    clearTimeout(that.setTime);
                })
            })

        },
        created: function () {
            var that = this
            layui.use(['laydate', 'element'], function () {
                that.element = layui.element
            })
        }
    })
</script>
</body>

</html>
