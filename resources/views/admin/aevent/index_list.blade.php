<html>
<head>
    <meta charset="utf-8">
    <title>作业违规巡检</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate"/>
    <meta http-equiv="Expires" content="0"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
    <link id="layuicss-layer" rel="stylesheet"
          href="/static/layuiadmin/layui/css/modules/layer/default/layer.css?v=3.1.1" media="all">
    <link id="layuicss-layer" rel="stylesheet"
          href="/static/layui/css/modules/formSelects-v4.css" media="all">
    <link rel="stylesheet" href="/static/layuiadmin/style/common.css" media="all">
</head>
<body layadmin-themealias="default">
<style>
    .xm-cz-group {
        margin-right: 0px !important;
        border-right: 2px solid #FFFFFF !important;
    }

    .xm-select-title {
        height: 30px;
        min-height: 30px !important;
    }

    .xm-select-parent .xm-select {
        line-height: 30px;
        height: 30px;
        min-height: 30px;
        left: 0px;
        z-index: 99;
        position: absolute;
        padding-top: 0px !important;
        overflow: hidden;
        background: 0px 0px;
    }

    .xm-select-parent .xm-input {
        height: 30px !important;
        padding-left: 11px !important;
    }

    .xm-cz {
        display: none;
    }

    .video-style {
        height: calc(60%);
        height: -moz-calc(60%);
        height: -webkit-calc(60%);
    }

    .video-style .layui-form-item {
        margin: 10px auto;
    }

    .video-list {
        margin-left: 0 !important;
    }

    .video-date {
        color: dodgerblue;
        margin-top: 5px;
        margin-left: 0;
        font-size: 14px;
        text-align: center;
    }

    .video-img {
        height: 120px;
        width: 200px;
        margin: auto;
    }

    .playWnd {
        margin-left: 20px;
        height: 100%;
        width: 90%;
        background: black;
    }

    .video-hk {
        height: calc(60% + 39px) !important;
        height: -moz-calc(60% + 39px) !important;
        height: -webkit-calc(60% + 39px) !important;
        width: 58.33% !important;
    }

    .item-info {
        border: 1px solid #EDEDED;
        box-shadow: 2px 2px 2px #EDEDED;
        height: 33.33% !important;
    }

    .source-list {
        text-align: left;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 800;
        color: #4A535C;
    }

    .event-top {
        height: 17px;
        line-height: 17px;
        width: 17px;
        background: #2e93ee;
        text-align: center;
        display: inline-block;
        color: #EDEDED;
        border-radius: 50%;
    }

    .tac {
        text-align: center;
        width: 16.66%;
    }

    .right-item {
        width: calc(100% - 20px);
        width: -moz-calc(100% - 20px);
        width: -webkit-calc(100% - 20px);
        margin-left: 15px;
    }

    .event-item {
        height: 200px;
        margin-top: 5px;
        font-size: 12px;
        color: #787878;
    }

    .jindu {
        height: calc(100% - 40px) !important;
        height: -moz-calc(100% - 40px) !important;
        height: -webkit-calc(100% - 40px) !important;
        overflow-y: auto;
        color: #787878;
    }

    .jindu .layui-form-item {
        margin: 1px auto !important;
        line-height: 19px;
    }

    .jindu .layui-form-item .bl {
        float: right;
        margin-right: 30px;
    }

    .jindu .layui-form-item .layui-form-label {
        width: 80px !important;
        height: 22px !important;
        line-height: 22px;
        color: #787878;
        padding: 0px !important;
        text-align: right;
    }

    .jindu .layui-form-item .layui-input-block {
        margin: 0px 90px;
        min-height: 22px !important;
        max-height: 22px !important;
        height: 22px !important;
    }

    .jindu::-webkit-scrollbar { /*滚动条整体样式*/
        width: 5px; /*高宽分别对应横竖滚动条的尺寸*/
        height: 1px;
    }

    .layui-progress {
        height: 10px !important;
        top: 6px;
    }

    .layui-progress-bar {
        background: #54b6ff;
        height: 10px !important;
    }

    .info-detail1 {
        /* position: fixed; */
        _position: absolute;
        width: calc(100% - 40px);
        width: -moz-calc(100% - 40px);
        width: -webkit-calc(100% - 40px);
        height: calc(100% - 91px);
        height: -moz-calc(100% - 91px);
        height: -webkit-calc(100% - 91px);
        left: 0;
        top: 0;
        z-index: 97;
        background: #fff;
        margin: auto;
    }

    .info-detail1 .top {
        padding: 0px 20px;
        background: #fff;
        height: 50px;
        line-height: 50px;
        color: #505050;
        font-size: 16px;
        border-bottom: 1px solid #dcdcdc;
    }

    .info-detail1 .layui-row .top-right {
        text-align: right;
    }

    .info-detail1 .layui-row .top-right a {
        color: #1e9fff;
        cursor: pointer;
    }

    .info-detail1 .main {
        background: #FFF;
        padding: 20px;
    }

    .info-detail1 .main > div > ul {
        margin-left: 26px;
    }
</style>
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div v-show="info_main">
        <form class="layui-form">
            <div class="layui-row m-lr20">
                <div class="layui-col-md12">
                    <div class="layui-inline layui-form-serch">
                        <label class="layui-form-label-search">事件类型</label>
                        <div class="layui-input-inline" style="width: 278px;">
                            <select name="event_type" xm-select="event_type" xm-select-show-count="1">
                                <option v-for="vo,id in region" :value="id">@{{vo}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline layui-form-serch">
                        <label class="layui-form-label-search">监管对象</label>
                        <div class="layui-input-inline">
                            <select name="modules" id="selectData" lay-filter="selectData" placeholder="请输监管入对象名称"
                                    lay-verify="" lay-search>
                                <option value="">请输入监管对象名称</option>
                                <option :value="getObjectId(va)" v-for="va in objectList">@{{ va.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline layui-form-serch">
                        <label class="layui-form-label">筛选时间段</label>
                        <div class="layui-input-inline" style="width: 300px;">
                            <input type="text" placeholder="请输入起止时间" autocomplete="off"
                                   class="layui-input layui-input-search" id="ste">
                        </div>
                    </div>
                    <div class="layui-input-inline">
                        <button type="button" class="layui-btn layui-btn-normal layui-btn-sm"
                                @click="getList(1,true)">
                            <i class="layui-icon">&#xe615;</i>筛选
                        </button>
                    </div>
                </div>
                <div class="layui-row" style="float: right;margin: -50px auto">
                    <div class="layui-input-inline">
                        <button type="button" class="layui-btn layui-btn-sm" @click="data_board">数据看板</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="layui-row m-lr20">
            <div class="layui-col-md2 c-left" v-if="department_pid==1 || department_pid == ''">
                <div class="grid-demo grid-demo-bg1" style="text-align: center">组织机构</div>
                <ul id="demop"></ul>
            </div>
            <div :class="department_pid==1 || department_pid=='' ? 'layui-col-md10' : ''">
                <div class="layui-col-md12">
                    <table class="layui-table text-center" lay-size="sm">
                        <thead>
                        <tr>
                            <th style="width: 48px">#</th>
                            <th>
                                <div class="text-left">监管对象名称</div>
                            </th>
                            <th>
                                <div class="text-left">对象类型</div>
                            </th>
                            <th>
                                <div class="text-left">设备名称</div>
                            </th>
                            <th>
                                <div class="text-left">设备编号</div>
                            </th>
                            <th>
                                <div class="text-left">告警时间</div>
                            </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(vo,id) in formData">
                            <td v-text="id+1+size"></td>
                            <td>
                                <div class="text-left" v-text="vo['object']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-for="item,index in region" v-if="index == vo['event_type']"
                                     v-text="item"></div>
                            </td>
                            <td v-text="vo['cameraname']"></td>
                            <td>
                                <div class="text-left" v-text="vo['cameraid']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['created_time']"></div>
                            </td>
                            <td>
                                <button type="button" @click="queryDetail(vo['id'])"
                                        class="layui-btn layui-btn-xs">详情
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="layui-col-md12">
                    <div id="demoa"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="info-detail1" v-show="detail_info">
        <div class="layui-row top">
            <div class="layui-col-md6">
                事件详情
            </div>
            <div class="layui-col-md6 top-right">
                <a @click="goBack(0)">返回</a>
            </div>
        </div>
        <div class="layui-row main">
            <div class="layui-col-md2">
                <div class="source-list" style="text-align: center;background-color: #2e93ee;color: #EDEDED">事件列表</div>
                <div class="video-style" id="dvList" @scroll="onScroll">
                    <div class="layui-form-item" v-for="item,id in dvList" @click="queryDvConfig(item)">
                        <div class="layui-input-block video-list">
                            <div class="video-img">
                                <img :src="item.pic_node_path+item.pic_name" alt="" height="100%" width="100%"
                                     @mouseover="mouseOver(item.pic_node_path+item.pic_name)" @mouseleave="mouseLeave">
                            </div>
                            <div class="video-date" v-text="item.created_time"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layui-col-md7 video-hk">
                <div id="playWnd" class="playWnd"></div>
            </div>
            <div class="layui-col-md3">
                <div style="width:100%;height:30%;margin-bottom:10px;">
                    <img id="PicShow" src="/static/img/timg.jpg" style="width:100%;height:100%"/>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">监管对象</label>
                    <div class="layui-input-block" style="line-height: 30px" v-text="info.object"></div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">设备编号</label>
                    <div class="layui-input-block" style="line-height: 30px" v-text="info.cameraid"></div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">设备名称</label>
                    <div class="layui-input-block" style="line-height: 30px" v-text="info.cameraname"></div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">事件类型</label>
                    <div class="layui-input-block" style="line-height: 30px" v-for="item,index in region"
                         v-if="index == info.event_type" v-text="item"></div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">发生时间</label>
                    <div class="layui-input-block" style="line-height: 30px" v-text="info.created_time"></div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">预警说明</label>
                    <div class="layui-input-block">
                    <textarea name="city_bm_explain" class="layui-textarea" v-model="info.city_bm_explain"
                              v-text="info.city_bm_explain"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否上报</label>
                    <div class="layui-input-block">
                        <label style="line-height: 30px">
                            <input type="radio" name="city_bm_report" value="1" title="是" v-model="info.city_bm_report">是&nbsp;&nbsp;&nbsp;&nbsp;
                        </label>
                        <label style="line-height: 30px">
                            <input type="radio" name="city_bm_report" value="0" title="否" v-model="info.city_bm_report">否
                        </label>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block" v-if="department_pid==1||!department_pid">
                        <button class="layui-btn layui-btn-sm layui-btn-disabled" disabled>已处理</button>
                        <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary" @click="goBack()">返回
                        </button>
                    </div>
                    <div class="layui-input-block" v-else>
                        <button class="layui-btn layui-btn-sm layui-btn-disabled" v-if="city_bm_report==1" disabled>已处理
                        </button>
                        <button class="layui-btn layui-btn-sm" @click="putReport(info.id)" v-else>提交</button>
                        <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary" @click="goBack()">返回
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-show="data_info">
        <div class="layui-row layui-col-space20 x-body" style="margin: 10px;height: calc(100% - 40px) !important;">
            <div class="layui-col-md4" style="height: 100%;margin-bottom: 20px;padding-right: 0px">
                <div class="layui-col-md12 item-info" v-if="department_id==1">
                    <div class="source-list">各省事件排行TOP10</div>
                    <div class="jindu layui-form">
                        <div class="layui-form-item" v-for="vo,id in EventTop10" v-if="vo.Name && id < 10">
                            <label class="layui-form-label" v-text="vo.Name">北京</label>
                            <label class="layui-form-label bl" v-text="vo.Value+'%'">90%</label>
                            <div class="layui-input-block">
                                <div class="layui-progress">
                                    <div class="layui-progress-bar"
                                         :style="'background-color:#009688;width:'+vo.Value+'%'"
                                         :lay-percent="vo.Value+'%'"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12 item-info" v-else>
                    <div class="source-list">事件排行</div>
                    <div class="jindu layui-form">
                        <div class="layui-form-item" v-for="vo,id in EventTop10" v-if="vo.Name && id < 10">
                            <label class="layui-col-md2 tac">
                                <span class="event-top" v-text="id+1">1</span>
                            </label>
                            <label class="layui-col-md7" style="width: 58.33%;" v-text="vo.Name">安能分拣中心</label>
                            <label class="layui-col-md3" style="width: 25%;" v-text="vo.Value">1234569</label>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12 item-info" style="margin: 10px auto;">
                    <div class="source-list">数据总量</div>
                    <div id="eventbar"></div>
                </div>
                <div class="layui-col-md12 item-info">
                    <div class="source-list">历史数据</div>
                    <div id="eventline"></div>
                </div>
            </div>
            <div class="layui-col-md8" style="height: 100%;margin-bottom: 20px;">
                <div class="layui-row">
                    <div class="layui-col-md12 right-item"
                         style="height: calc(66.66% + 20px) !important">
                        <div class="layui-row">
                            <div class="layui-col-md11" id="map"></div>
                        </div>
                    </div>
                    <div class="layui-col-md12 right-item item-info">
                        <div class="source-list">事件列表</div>
                        <div class="layui-row" id="eventList"
                             style="height: -webkit-calc(100% - 40px) !important;overflow: auto;padding-right: 8.33%">
                            <div class="layui-col-md3 event-item layui-col-md-offset1" v-for="vo,id in DynamicEventZNs">
                                <div class="layui-row">
                                    <div class="layui-col-md12">
                                        <img :src="'data:image/png;base64,'+vo.Img" alt=""
                                             style="height: 120px;width: 100%;margin-bottom:5px">
                                        <span v-text="vo.CameraName">北京-北京-朝阳&nbsp;申通快递分拣中心</span><br/>
                                        <span v-text="vo.EventType">暴力分拣</span><br/>
                                        <span v-text="vo.CreatedTime">2019-08-15 15:37:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-row"
                     style="position: relative;margin-left: calc(100% - 70px);top:calc(-100% - 20px);">
                    <button type="button" class="layui-btn layui-btn-sm" @click="listDemo()">列表模式
                    </button>
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
<script src="/static/jsencrypt.min.js"></script>
<script src="/static/jsWebControl-1.0.0.min.js"></script>
<script src="/static/layuiadmin/echarts.js"></script>
<script src="/static/layuiadmin/china.js?id={{ rand(10000, 99999) }}"></script>

</body>
</html>
<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                objectList: '',
                object_id: '',
                form: null,
                size: 0,
                formData: {},
                region: {},
                type: "",
                start_time: "",
                end_time: "",
                department_id: "",
                department_pid: "",
                detail_info: false,
                info_main: true,
                data_info: false,
                govcode: "",
                name: "",
                timer: "",
                info: {},
                city_bm_report: 0,
                dvList: [],
                index: 1,
                isTrue: false,
                oWebControl: null,// 插件对象
                bIE: (!!window.ActiveXObject || 'ActiveXObject' in window),// 是否为IE浏览器
                pubKey: '',
                iLastCoverLeft: 0,
                iLastCoverTop: 0,
                iLastCoverRight: 0,
                iLastCoverBottom: 0,
                initCount: 0,
                marginLeft: 218,
                marginTop: 90,
                v_width: 600,
                v_height: 400,
                playBackTime: '{{$time}}',
                path: "{{Session::get('socket_adr')}}",
                socket: "",
                govInfo: [],
                EventTop10: {},
                DynamicEventZNs: {}
            }
        },
        methods: {
            mouseOver(src) {
                console.log(src);
                $("#PicShow").attr('src', src);
            },
            // 移出
            mouseLeave() {
                $("#PicShow").attr('src', '/static/img/timg.jpg');
            },
            getObjectId: function (va) {
                return va.id + "_" + va.type;
            },
            listDemo: function () {
                this.getAllObject();
                if (this.timer != '') {
                    clearInterval(this.timer);
                }
                this.detail_info = false;
                this.data_info = false;
                this.info_main = true;
            },
            getPage: function () {
                var limit = window.localStorage.getItem('page_size');
                if (limit != null) {
                    return limit
                }
                return 10
            },
            setPage: function (num) {
                var limit = window.localStorage.getItem('page_size');
                if (limit != num) {
                    window.localStorage.setItem('page_size', num);
                }
            },
            // 录像回放
            queryDvConfig: function (obj) {
                this.queryDetail(obj.id, true);
                var params = [];
                this.$http.post('/api/eventrecord/find', {
                    CameraIndexCode: obj.cameraid,
                    StartTime: obj.created_time,
                    EventType: obj.event_type
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.ErrCode == 0) {
                            var rsp = JSON.parse(res.body.Rsp);
                            if (rsp.code == 0) {
                                params = rsp.data[0];
                                var dvConfig = {};
                                this.$http.post('/admin/device/vdconfig', {cameraid: obj.cameraid}, {emulateJSON: true})
                                    .then(function (res) {
                                        if (res.body.code == 0) {
                                            dvConfig = res.body.data;
                                            this.startPlayback(params, dvConfig)
                                        } else {
                                            layer.msg("服务异常");
                                            return;
                                        }
                                    }, function () {
                                        layer.msg("服务异常");
                                        return;
                                    })
                            }
                        } else {
                            layer.msg("服务异常");
                            return;
                        }
                    }, function () {
                        layer.msg("服务异常");
                        return;
                    })
            },
            startPlayback: function (params, dvConfig) {
                // 录像回放
                var cameraIndexCode = params.indexCode;
                var startTimeStamp = this.getTimeStamp(params.startTime) - this.playBackTime * 1000;
                var endTimeStamp = this.getTimeStamp(params.endTime) + this.playBackTime * 1000;
                var appkey = dvConfig.appkey;
                var secret = this.setEncrypt(dvConfig.appsecret);
                var ip = dvConfig.artemisip;
                var szPort = dvConfig.artemisport;
                var szPermisionType = dvConfig.privilege;
                var recordLocation = +dvConfig.recordLocation;
                var transMode = +dvConfig.transMode;
                var gpuMode = +dvConfig.gpuMode;
                var wndId = dvConfig.wndId;  //默认为选中窗口回放
                var encryptedFields = dvConfig.encryptedFieldsPLay;
                encryptedFields = encryptedFields.split(',');
                encryptedFields.forEach((item) => {
                    // secret固定加密，其它根据用户勾选加密
                    if (item == 'ip') {
                        ip = this.setEncrypt(ip)
                    }
                    if (item == 'appkey') {
                        appkey = this.setEncrypt(appkey)
                    }
                })
                encryptedFields = encryptedFields.join(",");
                var port = parseInt(szPort);
                var PermisionType = parseInt(szPermisionType);
                var enableHttps = parseInt(dvConfig.enableHTTPS);
                if (wndId >= 1)//指定窗口回放
                {
                    wndId = parseInt(wndId, 10);
                } else if (0 == wndId) //空闲窗口回放
                {
                    wndId = 0;
                }

                if (!cameraIndexCode) {
                    layer.msg("监控点编号不能为空！");
                    return
                }

                if (!appkey) {
                    layer.msg("appkey不能为空！");
                    return
                }

                if (!secret) {
                    layer.msg("secret不能为空！");
                    return
                }

                if (!ip) {
                    layer.msg("ip不能为空！");
                    return
                }

                if (!PermisionType) {
                    layer.msg("PermisionType不能为空");
                    return
                }

                if (!port) {
                    layer.msg("端口不能为空！");
                    return
                } else if (!/^([0-9]|[1-9]\d{1,3}|[1-5]\d{4}|6[0-5]{2}[0-3][0-5])$/.test(port)) {
                    layer.msg("端口填写有误！");
                    return
                }

                if (!Number.isNaN) {
                    Number.isNaN = function (n) {
                        return (
                            typeof n === "number" &&
                            window.isNaN(n)
                        );
                    };
                }
                if (Number.isNaN(+startTimeStamp) || Number.isNaN(+endTimeStamp)) {
                    layer.msg("时间格式有误！");
                    return
                }
                this.oWebControl.JS_RequestInterface({
                    funcName: "startPlayback",
                    argument: JSON.stringify({
                        cameraIndexCode: cameraIndexCode,
                        appkey: appkey,
                        secret: secret,
                        ip: ip,
                        port: port,
                        enableHTTPS: enableHttps,
                        startTimeStamp: Math.floor(startTimeStamp / 1000),
                        endTimeStamp: Math.floor(endTimeStamp / 1000),
                        recordLocation: recordLocation,
                        transMode: transMode,
                        gpuMode: gpuMode,
                        wndId: wndId,
                        encryptedFields: encryptedFields,
                        privilege: PermisionType
                    })
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
            },
            // ISO8601时间转时间戳
            getTimeStamp: function (isostr) {
                var parts = isostr.match(/\d+/g);
                return new Date(parts[0] + '-' + parts[1] + '-' + parts[2] + ' ' + parts[3] + ':' + parts[4] + ':' + parts[5]).getTime();
            },
            // 初始化
            init: function () {
                var that = this
                that.getPubKey(function () {
                    var snapDir = '{{Session::get('sys_hk_video')['snapDir']}}'
                    var videoDir = '{{Session::get('sys_hk_video')['videoDir']}}'
                    var layout = '{{Session::get('sys_hk_video')['layout']}}'
                    var encryptedFields = '{{Session::get('sys_hk_video')['encryptedFieldsPLay']}}'
                    encryptedFields = encryptedFields.split(',');
                    var btIds = '{{Session::get('sys_hk_video')['btIds']}}'
                    var showToolbar = '{{Session::get('sys_hk_video')['showToolbar']}}';
                    var showSmart = '{{Session::get('sys_hk_video')['showSmart']}}';
                    showSmart = parseInt(showSmart)
                    showToolbar = parseInt(showToolbar)
                    snapDir = snapDir.replace(/(^\s*)/g, "");
                    snapDir = snapDir.replace(/(\s*$)/g, "");
                    videoDir = videoDir.replace(/(^\s*)/g, "");
                    videoDir = videoDir.replace(/(\s*$)/g, "");
                    encryptedFields.forEach((value) => {
                        // secret固定加密，其它根据配置加密
                        if (value == 'snapDir') {
                            snapDir = this.setEncrypt(snapDir)
                        }
                        if (value == 'videoDir') {
                            videoDir = this.setEncrypt(videoDir)
                        }
                        if (value == 'layout') {
                            layout = this.setEncrypt(layout)
                        }
                    })
                    encryptedFields = encryptedFields.join(",");
                    that.oWebControl.JS_RequestInterface({
                        funcName: "init",
                        argument: JSON.stringify({
                            playMode: 1, // 回放
                            snapDir: snapDir,
                            videoDir: videoDir,
                            layout: layout,
                            encryptedFields: encryptedFields,
                            showToolbar: showToolbar,
                            showSmart: showSmart,
                            buttonIDs: btIds,
                        })
                    }).then(function (oData) {
                        console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                        //初始化后resize一次，规避firefox下首次显示窗口后插件窗口未与DIV窗口重合问题
                        that.oWebControl.JS_Resize(that.v_width, that.v_height);
                    });
                })
            },
            //初始化插件
            initPlugin: function () {
                var that = this
                that.oWebControl = new WebControl({
                    szPluginContainer: "playWnd",
                    iServicePortStart: 15900,
                    iServicePortEnd: 15909,
                    cbConnectSuccess: function () {
                        that.setCallbacks();
                        that.oWebControl.JS_StartService("window", {
                            dllPath: "./VideoPluginConnect.dll"
                            //dllPath: "./DllForTest-Win32.dll"
                        }).then(function () {
                            var map = {}
                            if (self != top && $('#LAY_app', parent.document).attr('class') != "layadmin-side-shrink") {
                                map.left = that.marginLeft
                                map.top = that.marginTop
                            } else if (self != top && $('#LAY_app', parent.document).attr('class') == "layadmin-side-shrink") {
                                map.left = that.marginLeft - 160
                                map.top = that.marginTop
                            } else {
                                map.left = 0
                                map.top = 0
                            }
                            var bili = that.detectZoom()
                            //map.left = Math.round(map.left * (bili / 100))
                            //map.top = Math.round(map.top * (bili / 100))
                            that.oWebControl.JS_SetDocOffset(map)
                            that.v_width = $(".video-hk").width() * 90 / 100;
                            that.v_height = $(".video-hk").height()
                            that.oWebControl.JS_CreateWnd("playWnd", that.v_width, that.v_height).then(function () {
                                that.init()
                            });
                        }, function () {

                        });
                    },
                    cbConnectError: function () {
                        console.log("cbConnectError");
                        that.oWebControl = null;
                        WebControl.JS_WakeUp("VideoWebPlugin://");
                        that.initCount++;
                        layer.msg("插件未启动，正在尝试第" + that.initCount + "次启动，请稍候...");
                        if (that.initCount < 3) {
                            setTimeout(function () {
                                that.initPlugin();
                            }, 3000)
                        } else {
                            layer.confirm("插件启动失败，请检测下载，下载后需重启浏览器", {title: "下载"}, function (index) {
                                $("#layui-layer-shade4").hide();
                                that.detail_info = false;
                                that.info_main = true;
                                that.downLoadExe();
                                layer.close(index);
                            })
                        }
                    },
                    cbConnectClose: function () {
                        console.log("cbConnectClose");
                        that.oWebControl = null;
                    }
                });
            },
            downLoadExe: function () {
                var $form = $('<form method="GET"></form>');
                $form.attr('action', '/VideoWebPlugin.exe');
                $form.appendTo($('body'));
                $form.submit();
            },
            // 获取公钥
            getPubKey: function (callback) {
                var that = this
                this.oWebControl.JS_RequestInterface({
                    funcName: "getRSAPubKey",
                    argument: JSON.stringify({
                        keyLength: 1024
                    })
                }).then(function (oData) {
                    console.log(oData)
                    if (oData.responseMsg.data) {
                        that.pubKey = oData.responseMsg.data
                        callback()
                    }
                })
            },
            // RSA加密
            setEncrypt: function (value) {
                var encrypt = new JSEncrypt();
                encrypt.setPublicKey(this.pubKey);
                return encrypt.encrypt(value);
            },
            // 设置窗口控制回调
            setCallbacks: function () {
                this.oWebControl.JS_SetWindowControlCallback({
                    cbIntegrationCallBack: this.cbIntegrationCallBack
                });
            },
            // 推送消息
            cbIntegrationCallBack: function (oData) {
                console.log(JSON.stringify(oData.responseMsg));
            },
            // 停止回放
            stopAllPlayback: function () {
                this.oWebControl.JS_RequestInterface({
                    funcName: "stopAllPlayback"
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
            },
            // 反初始化
            uninit: function () {
                this.oWebControl.JS_RequestInterface({
                    funcName: "uninit"
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
            },
            // 获取布局
            getLayout: function () {
                oWebControl.JS_RequestInterface({
                    funcName: "getLayout"
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
            },
            // 设置布局
            setLayout: function () {
                var layout = $("#layoutType").val();
                oWebControl.JS_RequestInterface({
                    funcName: "setLayout",
                    argument: JSON.stringify({
                        layout: layout
                    })
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
            },
            getDepartment: function () {
                this.$http.post('/admin/department', {}, {emulateJSON: true})
                    .then(function (res) {
                        var th = this
                        var data = res.body.data;
                        this.department_pid = data[0].pid;
                        data[0]['spread'] = true;
                        if (this.department_pid == 1 || !this.department_pid) {
                            layui.use('tree', function () {
                                layui.tree({
                                    elem: '#demop' //传入元素选择器
                                    , nodes: data,
                                    shin: "ssss",
                                    click: function (node) {
                                        // console.log(node) //node即为当前点击的节点数据
                                        th.department_id = node.id;
                                        th.getList(1, true);
                                    }
                                });
                            });
                            $(document).on("mouseover", "#demop li a", function (e) {
                                e.currentTarget.setAttribute("title", e.currentTarget.children[1].innerText)
                            })
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            getList: function (page, isSearch) {
                var num = this.getPage();
                var data = {
                    "page": page,
                    'page_size': num
                };
                if (this.department_id != '') {
                    data.department_id = this.department_id;
                }
                if (this.type != '') {
                    data.type = this.type;
                } else {
                    layer.msg("请选择事件类型");
                    return false;
                }
                if (this.object_id != '') {
                    var map = this.object_id.split('_');
                    data.id = map[0];
                    data.objectType = map[1];
                }
                this.start_time ? data.start_time = this.start_time : '';
                this.end_time ? data.end_time = this.end_time : '';
                var that = this;
                this.$http.post('{{ url()->current() }}', data, {emulateJSON: true})
                    .then(function (res) {
                        if (isSearch) {
                            layer.msg("正在分析中，请耐心等待", {time: 5000}, function () {
                                if (res.body.code == 0) {
                                    that.formData = res.body.data.data;
                                    that.size = page > 1 ? (page - 1) * num : 0;
                                    layui.use('laypage', function () {
                                        var laypage = layui.laypage;
                                        //执行一个laypage实例
                                        laypage.render({
                                            elem: 'demoa'
                                            , count: res.body.data.count
                                            , curr: res.body.data.current_page
                                            , limit: num
                                            , layout: ['limit', 'prev', 'page', 'next', 'count', 'skip']
                                            , jump: function (obj, first) {
                                                if (!first) {
                                                    //当前点击页面
                                                    var curr = obj.curr;
                                                    that.setPage(obj.limit);
                                                    that.getList(curr);
                                                }
                                            }
                                        })
                                    });
                                } else {
                                    var str = lea.msg(res.body.msg) || '服务器异常';
                                    layer.msg(str);
                                }
                            });
                        } else {
                            if (res.body.code == 0) {
                                that.formData = res.body.data.data;
                                that.size = page > 1 ? (page - 1) * num : 0;
                                layui.use('laypage', function () {
                                    var laypage = layui.laypage;
                                    //执行一个laypage实例
                                    laypage.render({
                                        elem: 'demoa'
                                        , count: res.body.data.count
                                        , curr: res.body.data.current_page
                                        , limit: num
                                        , layout: ['limit', 'prev', 'page', 'next', 'count', 'skip']
                                        , jump: function (obj, first) {
                                            if (!first) {
                                                //当前点击页面
                                                var curr = obj.curr;
                                                that.setPage(obj.limit);
                                                that.getList(curr);
                                            }
                                        }
                                    })
                                });
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            getRegion: function () {
                this.$http.get("/admin/aevent/region", {}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.region = res.body.data;
                                // this.initCanvas();
                                var that = this;
                                this.$nextTick(function () {
                                    layui.use('formSelects', function () {
                                        var formSelects = layui.formSelects;
                                        formSelects.on('event_type', function (id, vals, val, isAdd, isDisabled) {
                                            var arr = [];
                                            for (var i = 0; i < vals.length; i++) {
                                                arr.push(vals[i].value)
                                            }
                                            that.type = arr;
                                        }, true);
                                    });
                                })
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    )
            },
            queryDetail: function (id, bool) {
                this.$http.get('/admin/aevent/show/' + id, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.info = res.body.data;
                                this.event_type = this.info.event_type;
                                this.department_id = this.info.department_id;
                                this.city_bm_report = res.body.data.city_bm_report;
                                this.detail_info = true;
                                this.info_main = false;
                                if (!bool) {
                                    this.dvList = [];
                                    this.getNavList(1, 4);
                                    this.initPlugin();
                                }

                                // var t;
                                // var that = this
                                // clearTimeout(t)
                                // t = setTimeout(function () {
                                //     that.init()
                                // }, 1000);
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    )
            },
            getNavList: function (page, num) {
                var data = {
                    "page": page,
                    'page_size': num,
                    "department_id": this.info.department_id,
                    "type": [this.info.event_type]
                };
                this.name ? data.name = this.name : '';
                this.$http.post('/admin/aevent', data, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.isTrue = true;
                            var arr = res.body.data.data;
                            for (i = 0; i < arr.length; i++) {
                                this.dvList.push(arr[i]);
                            }
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            putReport: function (id) {
                this.$http.post("/admin/aevent/report", {
                    "id": id,
                    "report": this.info.city_bm_report,
                    "explain": this.info.city_bm_explain
                }, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                var str = lea.msg(res.body.msg) || '上报成功';
                                layer.msg(str);
                                var that = this;
                                this.city_bm_report = 1;
                                this.dvList = [];
                                this.getNavList(1, 4);
                                // setTimeout(function () {
                                //     layer.closeAll();
                                //     that.goBack()
                                // }, 2000)
                            } else {
                                var str = lea.msg(res.body.msg) || '没有上报权限';
                                layer.msg(str);
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    )
            },
            getParameterByName: function (name) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            },
            //点击码率直播开始播放
            playit: function (mrl) {
                var stream = this.getParameterByName('stream') || mrl;
                var video = document.getElementById('video');
                var hls = new Hls();
                if (Hls.isSupported()) {
                    hls.loadSource(stream);
                    hls.attachMedia(video);
                    hls.on(Hls.Events.MANIFEST_PARSED, function () {
                        video.play();
                    });
                }
            },
            playHls: function (id) {
                this.playit('http://ivi.bupt.edu.cn/hls/cctv1hd.m3u8')
            },
            onScroll: function (event) {
                if (this.isTrue) {
                    let clHeight = event.currentTarget.clientHeight;  //容器的高度
                    let scTop = event.currentTarget.scrollTop;   //滚动条的scrolltop
                    let scHeight = event.currentTarget.scrollHeight;  //内容的高度
                    if (clHeight + scTop >= scHeight - 0.5) { // 客户端高度 + 距离顶部高度 > 滚动条高度  查询下一页
                        this.getNavList(++this.index, 4);
                        this.isTrue = false;
                    }
                    this.isTrue = true;
                }
            },
            goBack: function () {
                this.dvList = [];
                var that = this;
                if (this.oWebControl != null) {
                    // this.stopAllPlayback();
                    // this.uninit();
                    this.oWebControl.JS_HideWnd();
                    if (!!window.ActiveXObject || "ActiveXObject" in window) {// IE
                        $("#layui-layer-shade4").hide();
                        that.detail_info = false;
                        that.info_main = true;
                        that.data_info = false;
                    } else {
                        this.oWebControl.JS_Disconnect().then(function () {
                            //关闭成功后再关闭窗口不然会延迟
                            $("#layui-layer-shade4").hide();
                            that.detail_info = false;
                            that.info_main = true;
                            that.data_info = false;
                        }, function () {
                        });
                    }
                } else {
                    //插件未安装或启动直接关闭弹出层
                    $("#layui-layer-shade4").hide();
                    that.detail_info = false;
                    that.info_main = true;
                    that.data_info = false;
                }
            },
            initCanvas: function () {
                //各省事件top10
                var EventTop10 = JSON.parse(window.localStorage.getItem('aEventTop10'));
                if (EventTop10 && this.department_id == 1) {
                    for (var i in EventTop10) {
                        if (EventTop10[i].Name) {
                            //省市名称
                            var name = EventTop10[i].Name.substring(0, 2);
                            if (name == '黑龙' || name == '内蒙') {
                                EventTop10[i].Name = EventTop10[i].Name.substring(0, 3);
                            } else {
                                EventTop10[i].Name = name;
                            }
                            // 事件百分比
                            EventTop10[i].Value = EventTop10[i].Value / 100;
                        }
                    }
                }
                this.EventTop10 = EventTop10;
                //作业违规监管最新事件
                this.DynamicEventZNs = JSON.parse(window.localStorage.getItem('aDynamicEventZNs'));
                //历史数据
                var lineData = [];
                if (JSON.parse(window.localStorage.getItem('aTimeETypeCount')))
                    lineData = JSON.parse(window.localStorage.getItem('aTimeETypeCount'))[4].TimeEventTypes;

                var region = [];
                var barData = [];
                var lineSeries = [];
                var colorList = ['#F6A7F0', '#FF9660', '#33CBFD', '#FF5F5B', '#6797FF', '#5FB878', '#54b6ff', '#787878', '#5FB878'];
                var EventTypes = [];
                if (JSON.parse(window.localStorage.getItem('aEventTypes')))
                    EventTypes = JSON.parse(window.localStorage.getItem('aEventTypes'));
                var dateData = [];

                if (Object.values(this.region).length > 0) {
                    for (var i in this.region) {
                        //柱状图Y轴数据
                        for (var j in EventTypes) {
                            if (this.region[i] === EventTypes[j].Name) {
                                barData.push(EventTypes[j].Value);
                            }
                        }
                        //组装事件类型
                        region.push(this.region[i]);
                        var data = [];
                        if (lineData[i]) {
                            for (var k in lineData[i].TimeCounts) {
                                // 取出事件相关时间段
                                if (!dateData.includes(lineData[i].TimeCounts[k].Ctime)) {//includes 检测数组是否有某个值
                                    dateData.push(lineData[i].TimeCounts[k].Ctime);
                                }
                                //组装事件各时间段及数量
                                data.push({
                                    name: lineData[i].Name,
                                    value: [
                                        lineData[i].TimeCounts[k].Ctime,
                                        lineData[i].TimeCounts[k].Value
                                    ]
                                });
                            }
                        }
                        //折线图series数据组装
                        lineSeries.push({
                            name: Object.values(this.region)[i],
                            type: 'line',
                            smooth: true,
                            data: data,
                        });
                    }
                } else {
                    for (var i in EventTypes) {
                        barData.push(EventTypes[i].Value);
                        region.push(EventTypes[i].Name);
                        var data = [];
                        if (lineData[i]) {
                            for (var k in lineData[i].TimeCounts) {
                                // 取出事件相关时间段
                                if (!dateData.includes(lineData[i].TimeCounts[k].Ctime)) {//includes 检测数组是否有某个值
                                    dateData.push(lineData[i].TimeCounts[k].Ctime);
                                }
                                //组装事件各时间段及数量
                                data.push({
                                    name: lineData[i].Name,
                                    value: [
                                        lineData[i].TimeCounts[k].Ctime,
                                        lineData[i].TimeCounts[k].Value
                                    ]
                                });
                            }
                        }
                        //折线图series数据组装
                        lineSeries.push({
                            name: EventTypes[i].Name,
                            type: 'line',
                            smooth: true,
                            data: data,
                        });
                    }
                }

                var that = this;
                var height = ($(document.body).height() - 100) * 33.33 / 100 - 39;
                //柱状图
                echarts.dispose(document.getElementById('eventbar'));
                var bar = document.getElementById("eventbar");
                bar.style.width = $(document.body).width() >= 992 ? ($(document.body).width() - 100) * 33.33 / 100 + 'px' : $(document.body).width() - 100 + 'px';
                bar.style.height = height + 'px';
                var optionBar = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            magicType: {show: true, type: ['line']},
                            restore: {show: true},
                        }
                    },
                    grid: {
                        left: '20px',
                        right: '5%',
                        bottom: '10%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        data: region,
                        axisLabel: {
                            interval: 0,
                            rotate: 25,
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#787878' //更改坐标轴颜色
                            }
                        },
                    },
                    yAxis: {
                        type: 'value',
                        name: '单位（万）',
                        axisLine: {
                            lineStyle: {
                                color: '#787878' //更改坐标轴颜色
                            }
                        },
                    },
                    series: [
                        {
                            type: 'bar',
                            barWidth: 100 / region.length,
                            data: barData,
                            itemStyle: {
                                normal: {
                                    color: function (params) {
                                        return colorList[params.dataIndex];
                                    }
                                }
                            },
                        }
                    ],
                };
                //折线图
                echarts.dispose(document.getElementById('eventline'))
                var line = document.getElementById("eventline");
                line.style.width = $(document.body).width() >= 992 ? ($(document.body).width() - 100) * 33.33 / 100 + 'px' : $(document.body).width() - 100 + 'px';
                line.style.height = height + 'px';
                var optionLine = {
                    tooltip: {
                        trigger: 'axis',
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            magicType: {show: true, type: ['bar']},
                            restore: {show: true},
                        }
                    },
                    legend: {
                        data: region,
                        y: "top",
                        textStyle: {
                            color: '#787878',
                        },
                    },
                    grid: {
                        left: '20px',
                        right: '5%',
                        bottom: '15%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: dateData.sort(),
                        axisLine: {
                            lineStyle: {
                                color: '#787878' //更改坐标轴颜色
                            }
                        },
                    },
                    yAxis: {
                        type: 'value',
                        axisLine: {
                            lineStyle: {
                                color: '#787878' //更改坐标轴颜色
                            }
                        },
                    },
                    series: lineSeries
                };
                if (this.data_info) {
                    var myChart1 = echarts.init(bar);
                    myChart1.setOption(optionBar);
                    var myChart2 = echarts.init(line);
                    myChart2.setOption(optionLine);
                }

                // 地图
                // 事件总数
                var eventCount = window.localStorage.getItem('aAllNums');
                that.IMapsInfo = JSON.parse(window.localStorage.getItem('aIMapsInfo'));
                var mapSeries = [], mydata = [];
                var optionMap = {
                    backgroundColor: '#FFFFFF',
                    title: {
                        text: '智能分析监督事件总数：',
                        textStyle: {
                            fontWeight: 800,
                            fontSize: '16',
                            color: '#4A535C',
                        },
                        subtext: eventCount ? eventCount : '0',
                        subtextStyle: {
                            fontSize: '18',
                            fontWeight: 800,
                            color: '#53A6FA',
                        },
                        x: 'left',
                        padding: [50, 0, 0, 50],
                    },
                    tooltip: {
                        trigger: 'item',
                        position: function (point, params, dom, rect, size) {
                            if (params.data) {
                                var html = ' <ul id="plan"><li><span>' + params.data.name + ': ' + params.data.value + '</span></li>';
                                var myseries = optionMap.series;
                                //循环遍历series数据系列
                                var html1 = '';
                                for (var i in myseries) {
                                    var html2 = '';
                                    //在内部继续循环series[i],从data中判断：当地区名称等于params.name的时候就将当前数据和名称添加到res中供显示
                                    for (var j in myseries[i].data) {
                                        //如果data数据中的name和地区名称一样
                                        if (myseries[i].data[j].name == params.name) {
                                            for (var k in myseries[i].data[j].eventType) {
                                                //将series数据系列每一项中的name和数据系列中当前地区的数据添加到res中
                                                html2 += myseries[i].data[j].eventType[k].Name + ': ' + myseries[i].data[j].eventType[k].Value + '<br />';
                                            }
                                        }
                                    }
                                    html1 = html2;
                                }
                                html += html1 + '</ul>';
                                $(dom).html(html);
                            }
                        },
                    },
                    //小导航图标
                    visualMap: {
                        show: true,
                        x: '5%',
                        y: '75%',
                        splitList: [
                            {start: 100000, label: '10万以上'},
                            {start: 50000, end: 100000, label: '5~10万'},
                            {end: 50000, label: '5万以下'},
                        ],
                        color: ['#5475f5', '#9feaa5', '#85daef']
                    },
                    //配置属性
                    series: mapSeries
                };
                //初始化echarts实例
                echarts.dispose(document.getElementById('map'));
                var map = document.getElementById('map');
                map.style.width = Math.floor((($(document.body).width() - 40) * 66.66 / 100 - 20) * 91.66 / 100 - 35) + 'px';
                map.style.height = Math.floor($(document.body).height() * 66.66 / 100 - 45) + 'px';
                var myChart3 = echarts.init(map);
                var mapType = 'china';
                if (that.govcode) {
                    mapType = that.govcode;
                    $.get('/static/layuiadmin/json/china-main-city/' + that.govcode + '.json', function (Citymap) {
                        that.govInfo = [];
                        for (var j in Citymap.features) {
                            that.govInfo.push({
                                code: Citymap.features[j].properties.id,
                                name: Citymap.features[j].properties.name
                            });
                        }
                        if (that.IMapsInfo && that.IMapsInfo.length > 0) {
                            if (that.department_id === 1) {
                                for (var i in that.IMapsInfo) {
                                    if (that.IMapsInfo[i].Name) {
                                        var name = that.IMapsInfo[i].Name.substring(0, 2);
                                        if (name == '黑龙' || name == '内蒙') {
                                            that.IMapsInfo[i].name = that.IMapsInfo[i].Name.substring(0, 3);
                                        } else {
                                            that.IMapsInfo[i].name = name;
                                        }
                                        mydata.push({
                                            name: that.IMapsInfo[i].name,
                                            value: that.IMapsInfo[i].Value,
                                            eventType: that.IMapsInfo[i].EventType
                                        });
                                    }
                                }
                            } else {
                                var mapData = [];
                                //遍历后端传递地图数据
                                for (var i in that.IMapsInfo) {
                                    //是否存在地区名称
                                    if (that.IMapsInfo[i].GovName) {
                                        //直辖市单独处理
                                        if (that.department_id === 2 || that.department_id === 3 || that.department_id === 21) {
                                            //拆分多个行政代码为数组
                                            var arr = that.IMapsInfo[i].GovName.split(',');
                                            //遍历数组
                                            for (var j in arr) {
                                                //遍历当前组织机构地图区域信息
                                                for (var k in that.govInfo) {
                                                    //如果当前地图区域行政代码与后端传递区域行政代码一致则组装地图数据
                                                    if (arr[j] === that.govInfo[k].code) {
                                                        mydata.push({
                                                            name: that.govInfo[k].name,
                                                            value: that.IMapsInfo[i].Value,
                                                            eventType: that.IMapsInfo[i].EventType
                                                        });
                                                    }
                                                }
                                            }
                                        } else {
                                            for (var k in that.govInfo) {
                                                if (that.IMapsInfo[i].GovName === that.govInfo[k].name) {//省级
                                                    mydata.push({
                                                        name: that.govInfo[k].name,
                                                        value: that.IMapsInfo[i].Value,
                                                        eventType: that.IMapsInfo[i].EventType
                                                    });
                                                } else {
                                                    if (that.IMapsInfo[i].Value != 0) {//地市级统一数据
                                                        mapData.push({
                                                            name: that.govInfo[k].name,
                                                            value: that.IMapsInfo[i].Value,
                                                            eventType: that.IMapsInfo[i].EventType
                                                        });
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                if (that.department_id > '32') {//地市级
                                    mydata = mapData;
                                }
                            }
                            for (var j in region) {
                                mapSeries.push({
                                    name: region[j],
                                    type: 'map',
                                    mapType: mapType,
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
                                });
                            }
                            optionMap.series = mapSeries;
                        } else {
                            mapSeries = [{
                                name: '',
                                type: 'map',
                                mapType: mapType,
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
                                data: []
                            }];
                            optionMap.series = mapSeries;
                        }
                        echarts.registerMap(mapType, Citymap);
                        //修改地图类型名称
                        for (var i in optionMap.series) {
                            optionMap.series[i].mapType = mapType;
                        }
                        myChart3.setOption(optionMap);
                    }, 'json').fail(function () {// 获取失败回调
                        var govcode = mapType = that.govcode.substring(0, 2);//获取上级行政编码
                        $.get('/static/layuiadmin/json/china-main-city/' + govcode + '.json', function (Citymap) {
                            if (typeof Citymap == 'string') {
                                Citymap = JSON.parse(Citymap);
                            }
                            var data = [];
                            var arr = that.govcode.split(',');
                            that.govInfo = [];
                            for (var i in arr) {
                                for (var j in Citymap.features) {
                                    if (Citymap.features[j].properties.id == arr[i]) {
                                        data[i] = Citymap.features[j];
                                        that.govInfo.push({
                                            code: Citymap.features[j].properties.id,
                                            name: Citymap.features[j].properties.name
                                        });
                                    }
                                }
                            }
                            if (that.IMapsInfo) {
                                if (that.department_id === 1) {
                                    for (var i in that.IMapsInfo) {
                                        if (that.IMapsInfo[i].Name) {
                                            var name = that.IMapsInfo[i].Name.substring(0, 2);
                                            if (name == '黑龙' || name == '内蒙') {
                                                that.IMapsInfo[i].name = that.IMapsInfo[i].Name.substring(0, 3);
                                            } else {
                                                that.IMapsInfo[i].name = name;
                                            }
                                            mydata.push({
                                                name: that.IMapsInfo[i].name,
                                                value: that.IMapsInfo[i].Value,
                                                eventType: that.IMapsInfo[i].EventType
                                            });
                                        }
                                    }
                                } else {
                                    //遍历后端传递地图数据
                                    for (var i in that.IMapsInfo) {
                                        //是否存在地区名称
                                        if (that.IMapsInfo[i].GovName) {
                                            //北京天津海南单独处理
                                            if (that.department_id === 2 || that.department_id === 3 || that.department_id === 21) {
                                                //拆分多个行政代码为数组
                                                var arr = that.IMapsInfo[i].GovName.split(',');
                                                //遍历数组
                                                for (var j in arr) {
                                                    //遍历当前组织机构地图区域信息
                                                    for (var k in that.govInfo) {
                                                        //如果当前地图区域行政代码与后端传递区域行政代码一致则组装地图数据
                                                        if (arr[j] === that.govInfo[k].code) {
                                                            mydata.push({
                                                                name: that.govInfo[k].name,
                                                                value: that.IMapsInfo[i].Value,
                                                                eventType: that.IMapsInfo[i].EventType
                                                            });
                                                        }
                                                    }
                                                }
                                            } else {
                                                //地市级统一颜色
                                                for (var k in that.govInfo) {
                                                    mydata.push({
                                                        name: that.govInfo[k].name,
                                                        value: that.IMapsInfo[i].Value,
                                                        eventType: that.IMapsInfo[i].EventType
                                                    });
                                                }
                                            }
                                        } else {
                                            //地市级统一颜色
                                            for (var k in that.govInfo) {
                                                mydata.push({
                                                    name: that.govInfo[k].name,
                                                    value: that.IMapsInfo[i].Value,
                                                    eventType: that.IMapsInfo[i].EventType
                                                });
                                            }
                                        }
                                    }
                                }
                                for (var j in region) {
                                    mapSeries.push({
                                        name: region[j],
                                        type: 'map',
                                        mapType: mapType,
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
                                    });
                                }
                                optionMap.series = mapSeries;
                            } else {
                                mapSeries = [{
                                    name: '',
                                    type: 'map',
                                    mapType: mapType,
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
                                    data: []
                                }];
                                optionMap.series = mapSeries;
                            }
                            Citymap.features = data;
                            echarts.registerMap(mapType, Citymap);
                            //修改地图类型名称
                            for (var i in optionMap.series) {
                                optionMap.series[i].mapType = mapType;
                            }
                            myChart3.setOption(optionMap);
                        }, 'json');
                    });
                } else {
                    if (that.IMapsInfo) {
                        for (var i in that.IMapsInfo) {
                            if (that.IMapsInfo[i].Name) {
                                var name = that.IMapsInfo[i].Name.substring(0, 2);
                                if (name == '黑龙' || name == '内蒙') {
                                    that.IMapsInfo[i].name = that.IMapsInfo[i].Name.substring(0, 3);
                                } else {
                                    that.IMapsInfo[i].name = name;
                                }
                                mydata.push({
                                    name: that.IMapsInfo[i].name,
                                    value: that.IMapsInfo[i].Value,
                                    eventType: that.IMapsInfo[i].EventType
                                });
                            }
                        }
                        optionMap.series = {
                            name: 'china',
                            type: 'map',
                            mapType: mapType,
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
                        optionMap.tooltip = {
                            trigger: 'item',
                            position: function (point, params, dom, rect, size) {
                                if (params.data) {
                                    var html = ' <ul id="plan"><li><span>' + params.data.name + ': ' + params.data.value + '</span></li>';
                                    var myseries = optionMap.series;
                                    //循环遍历series数据系列
                                    var html1 = '';
                                    //在内部继续循环series[i],从data中判断：当地区名称等于params.name的时候就将当前数据和名称添加到res中供显示
                                    for (var j in myseries.data) {
                                        //如果data数据中的name和地区名称一样
                                        if (myseries.data[j].name == params.name) {
                                            for (var k in myseries.data[j].eventType) {
                                                //将series数据系列每一项中的name和数据系列中当前地区的数据添加到res中
                                                html1 += myseries.data[j].eventType[k].Name + ': ' + myseries.data[j].eventType[k].Value + '<br />';
                                            }
                                        }
                                    }
                                    html += html1 + '</ul>';
                                    $(dom).html(html);
                                }
                            },
                        };
                        myChart3.setOption(optionMap);
                    }
                }
            },
            data_board: function () {
                this.data_info = true;
                this.info_main = false;
                this.detail_info = false;
                var that = this;
                //监听窗口变化
                $(window).resize(function () {
                    if (that.data_info == true) {
                        that.initCanvas();
                    }
                });
                //先清除保存的所有缓存
                //window.localStorage.clear();
                //执行websocket
                if (this.path) this.socketInit();
                this.initCanvas();
                // 事件列表滚动
                this.timer = setInterval(myfunc, 3000);
                var d = document.getElementById("eventList");

                function myfunc() {
                    if (d.length > 4) {
                        var o = d.firstChild;
                        if (o) {
                            d.removeChild(o);
                            d.appendChild(o);
                        }
                    }
                }

                d.onmouseover = function () {
                    clearInterval(this.timer);
                };

                d.onmouseout = function () {
                    this.timer = setInterval(myfunc, 3000);
                };
            }
            ,
            socketInit: function () {
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
                    // 监听socket关闭
                    this.socket.onclose = this.close;
                }
            }
            ,
            open: function () {
                console.log("socket连接成功");
                this.send();
            }
            ,
            error: function () {
                console.log("连接错误")
            }
            ,
            getMessage: function (msg) {
                var sData = msg.data;
                if (msg.data) sData = JSON.parse(sData);
                if (sData.AllNums) window.localStorage.setItem('aAllNums', sData.AllNums);
                if (sData.DynamicEventZNs) window.localStorage.setItem('aDynamicEventZNs', JSON.stringify(sData.DynamicEventZNs));
                if (sData.EventTop10) window.localStorage.setItem('aEventTop10', JSON.stringify(sData.EventTop10));
                if (sData.EventTypes) window.localStorage.setItem('aEventTypes', JSON.stringify(sData.EventTypes));
                if (sData.IMapsInfo) window.localStorage.setItem('aIMapsInfo', JSON.stringify(sData.IMapsInfo));
                if (sData.TimeETypeCount) window.localStorage.setItem('aTimeETypeCount', JSON.stringify(sData.TimeETypeCount));
                if (sData.XJNums) window.localStorage.setItem('aXJNums', sData.XJNums);
                if (sData.ZNNums) window.localStorage.setItem('aZNNums', sData.ZNNums);
                //作业违规监管最新事件
                this.DynamicEventZNs = JSON.parse(window.localStorage.getItem('aDynamicEventZNs'));
            }
            ,
            send: function () {
                var map = {};
                map['Action'] = "heart";
                map['Message'] = this.department_id.toString();
                map['DataType'] = 0;
                this.socket.send(JSON.stringify(map));
            }
            ,
            close: function () {
                console.log("socket已经关闭")
            }
            ,
            // 设置窗口遮挡
            setWndCover: function () {
                var iWidth = $(window).width();
                var iHeight = $(window).height();
                var oDivRect = $("#playWnd").get(0).getBoundingClientRect();
                var iCoverLeft = (oDivRect.left < 0) ? Math.abs(oDivRect.left) : 0;
                var iCoverTop = (oDivRect.top < 0) ? Math.abs(oDivRect.top) : 0;
                var iCoverRight = (oDivRect.right - iWidth > 0) ? Math.round(oDivRect.right - iWidth) : 0;
                var iCoverBottom = (oDivRect.bottom - iHeight > 0) ? Math.round(oDivRect.bottom - iHeight) : 0;

                iCoverLeft = (iCoverLeft > this.v_width) ? this.v_width : iCoverLeft;
                iCoverTop = (iCoverTop > this.v_height) ? this.v_height : iCoverTop;
                iCoverRight = (iCoverRight > this.v_width) ? this.v_width : iCoverRight;
                iCoverBottom = (iCoverBottom > this.v_height) ? this.v_height : iCoverBottom;
                if (this.iLastCoverLeft != iCoverLeft) {
                    this.iLastCoverLeft = iCoverLeft;
                    this.oWebControl.JS_SetWndCover("left", iCoverLeft);
                }
                if (this.iLastCoverTop != iCoverTop) {
                    this.iLastCoverTop = iCoverTop;
                    this.oWebControl.JS_SetWndCover("top", iCoverTop);
                }
                if (this.iLastCoverRight != iCoverRight) {
                    this.iLastCoverRight = iCoverRight;
                    this.oWebControl.JS_SetWndCover("right", iCoverRight);
                }
                if (this.iLastCoverBottom != iCoverBottom) {
                    this.iLastCoverBottom = iCoverBottom;
                    this.oWebControl.JS_SetWndCover("bottom", iCoverBottom);
                }
            }
            ,
            detectZoom: function () {
                var ratio = 0,
                    screen = window.screen,
                    ua = navigator.userAgent.toLowerCase();
                if (window.devicePixelRatio !== undefined) {
                    ratio = window.devicePixelRatio;
                } else if (~ua.indexOf('msie')) {
                    if (screen.deviceXDPI && screen.logicalXDPI) {
                        ratio = screen.deviceXDPI / screen.logicalXDPI;
                    }
                } else if (window.outerWidth !== undefined && window.innerWidth !== undefined) {
                    ratio = window.outerWidth / window.innerWidth;
                }
                if (ratio) {
                    ratio = Math.round(ratio * 100);
                }
                return ratio;
            }
            ,
            getAllObject: function () {
                this.$http.post('/admin/ievent/object', {}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                var that = this;
                                this.objectList = res.body.data
                                this.$nextTick(function () {
                                    that.form.render();
                                })
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    )
            }
        },
        mounted: function () {
            //执行websocket
            if (this.path) this.socketInit();
            this.getRegion();
            this.getDepartment();
            $("#load_gif").hide()
            $("#app").show();
            var that = this
            // 滚动条scroll
            $(window).scroll(function () {
                if (that.oWebControl != null) {
                    that.v_width = $(".video-hk").width() * 90 / 100;
                    that.v_height = Math.round(that.v_width * 6 / 9)
                    var height = (that.v_height < 500) ? that.v_height : 500;
                    $(".video-hk").css("height", height);
                    $(".playWnd").css("height", height);
                    $(".video-style").css("height", height - 39);
                    that.oWebControl.JS_Resize(that.v_width, height);
                    that.setWndCover();
                }
            });

            // 窗口resize
            $(window).resize(function () {
                if (that.oWebControl != null) {
                    var map = {}
                    if (self != top && $('#LAY_app', parent.document).attr('class') != "layadmin-side-shrink") {
                        map.left = that.marginLeft
                        map.top = that.marginTop
                    } else if (self != top && $('#LAY_app', parent.document).attr('class') == "layadmin-side-shrink") {
                        map.left = that.marginLeft - 160
                        map.top = that.marginTop
                    } else {
                        map.left = 0
                        map.top = 0
                    }
                    var bili = that.detectZoom()
                    //map.left = Math.round(map.left * (bili / 100))
                    //map.top = Math.round(map.top * (bili / 100))
                    that.oWebControl.JS_SetDocOffset(map)
                    that.v_width = $(".video-hk").width() * 90 / 100;
                    that.v_height = Math.round(that.v_width * 6 / 9)
                    var height = (that.v_height < 500) ? that.v_height : 500;
                    $(".video-hk").css("height", height);
                    $(".playWnd").css("height", height);
                    $(".video-style").css("height", height - 39);
                    that.oWebControl.JS_Resize(that.v_width, height);
                    that.setWndCover();
                }
            })
            // 标签关闭
            $(window).unload(function () {
                // 此处请勿调反初始化
                if (this.oWebControl != null) {
                    this.oWebControl.JS_HideWnd();
                    this.oWebControl.JS_Disconnect().then(function () {
                    }, function () {
                    });
                }
            });
        },
        created: function () {
            this.getAllObject();
            var that = this;
            this.$http.post("/admin/department/govcode", {}, {emulateJSON: true})
                .then(function (res) {
                        if (res.body.code == 0) {
                            that.department_id = res.body.data.id;
                            that.govcode = res.body.data.govcode.split('0000')[0];

                            if (this.path) this.socketInit();
                            this.initCanvas();
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    }
                )
            layui.config({
                base: '/static/layuiadmin/'
            }).extend({
                formSelects: 'layui_extends/formSelects-v4',
            }).use(['laydate', 'form'], function () {
                var form = layui.form;
                form.render();
                var laydate = layui.laydate;
                laydate.render({
                    elem: '#ste'
                    , type: 'datetime'
                    , range: '~'
                    , format: 'yyyy-MM-dd HH:mm:ss'
                    , done: function (value) {
                        var time = value.split(' ~ ');
                        that.start_time = time[0];
                        that.end_time = time[1];
                    }
                });
                that.form = form
                that.form.on('select(selectData)', function (data) {
                    that.object_id = data.value
                });
                that.form.render();
            })
        }
    });
</script>
