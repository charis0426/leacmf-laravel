<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>监管数据</title>
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
    body {
        height: 100%;
        min-height: 800px;
        background: url(/static/admin/img/bg.png) no-repeat #061537;
        background-size: cover;
        overflow-y: hidden;
        position: absolute;
    }

    .head_top {
        height: 56px;
        position: relative;
        background: url(/static/admin/img/znfx.png);
        background-position: center;
        background-repeat: no-repeat;
    }

    .xiala_top {
        cursor: pointer;
        height: 35px;
        width: 120px;
        background: url(/static/admin/img/xiala.png) no-repeat #061537;
        color: #07d8e8;
        position: absolute;
        right: 0px;
        top: 0
    }

    .xiala_top > span {
        line-height: 35px;
        margin-left: 20px;
        cursor: hand;
    }

    .xiala_top > span:hover {
        cursor: hand;
    }

    .xiala_li {
        cursor: pointer;
        width: 118px;
        height: 126px;
        border: 1px solid #3a8ed7;
        box-shadow: 0 0 10px #3a8ed7;
        position: absolute;
        right: 0px;
        top: 40px;
        background: #021b2f;
        z-index: 3243243;
    }

    .xiala_li:hover {
        cursor: hand;
    }

    .xiala_li > ul {
        padding: 10px 20px 10px 20px;
        color: #fff;
    }

    .xiala_li > ul > li {
        margin-bottom: 10px;
    }

    .layui-fluid {
        background: none;
        margin: 0;
    }

    .count_li {
        margin-top: 10px;
    }

    .layui-row .layui-col-md2-5 {
        position: relative;
        display: block;
        box-sizing: border-box;
        width: 20%;
        float: left;

    }

    .layui-row .layui-col-md2-5 > div {
        background-image: url(/static/admin/img/sjbk.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
        height: 87px;
        padding-bottom: 10px;
    }

    #app_new {
        margin: 20px;
        height: calc(100% - 40px);
        height: -moz-calc(100% - 40px);
        height: -webkit-calc(100% - 40px);
    }

    .count_title {
        color: #fff;
        font-size: 14px;
        height: 41px;
    }

    .count_title > img {
        margin: 5px 10px 5px 10px;
    }

    .count_num {
        height: 46px;
        color: #fff;
        font-size: 20px;
        font-weight: 400;
        margin-left: 52px;
    }

    .count_num > div {
        float: left;
        text-align: center;
    }

    .count_num_int {
        line-height: 46px;
        background-image: url(/static/admin/img/sjbk_6.png);
        background-repeat: no-repeat;
        height: 46px;
        width: 30px;
    }

    .count_num_fg {
        line-height: 60px;
    }

    .event_all {
        height: calc(100% - 56px) !important;
        height: -moz-calc(100% - 56px) !important;
        height: -webkit-calc(100% - 56px) !important;
    }

    .event_left:nth-child(1) {
        background-image: url(/static/admin/img/aevent.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
        margin-bottom: 10px;
    }

    .event_left:nth-child(2) {
        background-image: url(/static/admin/img/aevent.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
    }

    #map {
        height: 100%;
        width: 100%;
    }

    .event_right:nth-child(1) {
        color: #fff;
        /*height: 40%;*/
        background-image: url(/static/admin/img/aevent.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;

        margin-bottom: 10px;
        padding: 20px 20px 0px 20px;
    }

    #zuoye, #count {
        margin-top: 5px;
    }

    .event_right:nth-child(2) {
        /*height: 45%;*/
        padding: 20px 20px 0px 20px;
        background-image: url(/static/admin/img/aevent.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
    }

    .video_count {
        height: calc(100% - 20px) !important;
        height: -moz-calc(100% - 20px) !important;
        height: -webkit-calc(100% - 20px) !important;
    }

    .data_count {
        padding: 20px 20px 0px 20px;
        background-image: url(/static/admin/img/aevent.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
        height: calc(100% - 20px) !important;
        height: -moz-calc(100% - 20px) !important;
        height: -webkit-calc(100% - 20px) !important;
    }

    .event_list {
        padding: 20px 20px 0px 20px;
        background-image: url(/static/admin/img/event_list.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
        height: calc(100% - 20px) !important;
        height: -moz-calc(100% - 20px) !important;
        height: -webkit-calc(100% - 20px) !important;
    }

    .event_left, .event_right {
        padding: 10px;
        height: calc(50% - 20px) !important;
        height: -moz-calc(50% - 20px) !important;
        height: -webkit-calc(50% - 20px) !important;
    }

    .event_left .top_title {
        margin: 10px 0 0px 10px;
        color: #fff;
        height: 20px;
    }

    .event_left .event_body {
        height: calc(100% - 160px) !important;
        height: -moz-calc(100% - 160px) !important;
        height: -webkit-calc(100% - 160px) !important;
        padding: 10px;
    }

    .event_left .event_body > img {
        width: 100%;
        height: 100%;
    }

    .event_left::-webkit-scrollbar { /*滚动条整体样式*/
        width: 5px; /*高宽分别对应横竖滚动条的尺寸*/
        height: 1px;
    }

    .event_left::-webkit-scrollbar-thumb { /*滚动条里面小方块*/
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        background: #535353;
    }

    .event_left::-webkit-scrollbar-track { /*滚动条里面轨道*/
        -webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        background: #EDEDED;
    }

    .event_body p {
        color: #fff;
        height: 20px;
    }

    .eventv_body {
        height: calc(100% - 75px) !important;
        height: -moz-calc(100% - 75px) !important;
        height: -webkit-calc(100% - 75px) !important;
        padding: 20px 10px 5px 20px;

    }

    .eventv_body .event-info {
        color: #fff;
        height: 50%;
        background-color: rgba(4, 46, 96, 0.28);
        padding: 10px 10px 0px 15px;

    }

    .eventv_body .event-info p {
        color: #fff;
        height: 25px;
    }

    .eventv_body .event-info:nth-child(1) {
        margin-top: -10px;
        margin-bottom: 5px;

    }

    .event_icon {
        height: 12px;
        width: 2px;
        border: 1px solid #07d8e8;
        background: #07d8e8;
        margin-right: 5px;
        margin-top: 3px;

    }

    .top_title {
        color: #fff;
        line-height: 20px;
        height: 20px;
    }

    .top_title > div {
        float: left;
    }

    .count_map {
        height: calc(100% - 20px) !important;
        height: -moz-calc(100% - 20px) !important;
        height: -webkit-calc(100% - 20px) !important;
    }

    a {
        cursor: hand
    }

    #path {
        color: #fff
    }

    #path a {
        color: #fff
    }

    /*.event_item {*/
    /*    margin: 10px 1.66%;*/
    /*    min-width: 225px;*/
    /*}*/
    .event_item {
        width: 75%;
        text-align: left;
        margin: 10px auto;
        color: #fff
    }

    .event_item span {
        font-size: 10px;
    }

    .event-part {
        height: calc(100% - 30px) !important;
        height: -moz-calc(100% - 30px) !important;
        height: -webkit-calc(100% - 30px) !important;
        overflow-y: auto;
    }

    .event-part::-webkit-scrollbar { /*滚动条整体样式*/
        width: 2px; /*高宽分别对应横竖滚动条的尺寸*/
        height: 1px;
    }

    .event-part::-webkit-scrollbar-thumb { /*滚动条里面小方块*/
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 5px rgba(4, 22, 57, 1);
        background: #535353;
    }

    .event-part::-webkit-scrollbar-track { /*滚动条里面轨道*/
        -webkit-box-shadow: inset 0 0 5px rgba(4, 22, 57, 1);
        border-radius: 10px;
        background: #EDEDED;
    }

    .video-ma {
        padding: 20px 20px 20px 25px;
        background-image: url(/static/admin/img/video.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
        margin: 0 auto;
        width: 600px;
        height: 450px;
        margin-top: 100px;

    }

    .playWnd {
        height: 400px;
        width: 600px;
    }

    .video_cancle {
        width: 20px;
        height: 20px;
        cursor: pointer;
        float: right;
    }

    .xiala_li > ul > li > a {
        color: #fff !important;
    }

    .xiala_li > ul > li > a:hover {
        color: #07d8e8 !important;
    }

    .layui-input {

        background: transparent;
        border: 0px;
        color: #00fefe;
        width: 289px;
    }

    .layui-input:hover {

        background: transparent;
        border: 0px;
        color: #00fefe;
        width: 289px;
    }

    .layui-form-select dl {
        background-color: #061537;
    }

    .layui-form-select dl dd.layui-this {

        background-color: rgba(1, 158, 255, 0.6)
    }

    .layui-form-select dl dd:hover {
        background-color: rgba(1, 158, 255, 0.7)
    }

    .info-detail {
        color: #119fff;
        height: 501px;
        width: 1118px;
        background: url(/static/admin/img/playback.png) no-repeat;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -250px;
        margin-left: -560px;


    }

    .w350 {
        width: 350px;
        background: #001c4d;
        height: 360px;
        margin-top: 20px;
        margin-left: 64px;
        float: left;
    }

    .w350 .name {
        width: 330px;
        background: #002564;
        height: 40px;
        line-height: 40px;
        font-size: 16px;

        padding-left: 20px;
    }

    .w640 {
        width: 640px;
        height: 360px;
        float: left;
        margin-top: 20px;
        margin-left: 10px;
    }

    .Sname {
        height: 45px;
        line-height: 45px;
        width: 1104px;
        text-align: center;
        font-size: 16px;
        color: #07d8e8;
        padding-left: 16px;
    }

    .Sclose {
        height: 10px;
        width: 1064px;
        text-align: right;
        font-size: 16px;
        color: #07d8e8;
        padding-left: 16px;
        padding-right: 50px;
    }

    .Sclose a {
        padding: 5px;
        color: #07d8e8;
    }

    .dv_detail {
        height: 320px;

        overflow-y: auto;
    }

    .out_list, .out_hover {
        margin: 20px 40px;
        height: 140px;
        line-height: 140px;
        overflow: hidden;
    }

    .out_list:hover, .out_hover {
        background: url(/static/admin/img/hover.png) no-repeat;
        cursor: pointer;
    }
    #app_new{
        display: none;
    }
</style>
<body layadmin-themealias="default">
<div id="app_new" class="layui-fluid">
    <div class="head_top">
        <div class="xiala_top" @click="menu_click(0)">
            <span>智能分析</span>
        </div>
        <div class="xiala_li" v-show="menu_choose" @mouseleave="menu_click(1)">
            <ul>
                <li><a href="/">监管对象</a></li>
                <li><a href="/aevent">智能分析</a></li>
                <li><a href="/ievent">视频巡检</a></li>
                <li><a href="/admin/index">系统管理</a></li>
            </ul>
        </div>
    </div>
    <div class="event_all layui-row">
        <div class="layui-row" style="height: 70%;">
            <div class="layui-col-md3" style="height: 100%;margin-bottom: 10px">
                <div class="layui-row event_left">
                    <div class="layui-row video_count">
                        <div class="top_title">
                            <div class="event_icon"></div>
                            <div>本月发生事件</div>
                        </div>
                        <div class="count_map" id="month"></div>
                    </div>
                </div>
                <div class="layui-row event_left">
                    <div class="layui-row video_count">
                        <div class="top_title">
                            <div class="event_icon"></div>
                            <div>本周总事件趋势</div>
                        </div>
                        <div class="count_map" id="week"></div>
                    </div>
                </div>
            </div>
            <div class="layui-col-md6" style="padding-bottom:20px;height: 100%;">
                <div id="path" style="height:30px; text-align:center;color:#fff">全国</div>
                <div id="map"></div>
            </div>
            <div class="layui-col-md3" style="height: 100%;">
                <div class="layui-row event_right">
                    <div class="top_title">
                        <div class="event_icon"></div>
                        <div v-text="top10_title"></div>
                    </div>
                    <div class="count_map" id="top10"></div>
                </div>
                <div class="layui-row event_right" style="margin-bottom: 10px">
                    <div class="top_title">
                        <div class="event_icon"></div>
                        <div>实时数据</div>
                    </div>
                    <div class="count_map" id="time"></div>
                </div>
            </div>
        </div>
        <div class="layui-row" style="height: 30%;">
            <div class="layui-col-md9" style="padding-top: 10px;height: 100%;">
                <div class="layui-row event_list" style="margin-right:20px">
                    <div class="top_title">
                        <div class="event_icon"></div>
                        <div>事件列表</div>
                    </div>
                    <div class="layui-row event-part">
                        <div class="layui-col-md3" v-for="item,id in sdata.aEventZNs" v-if="id < 4">
                            <div class="event_item"
                                 @click="queryEventTime(item.Img)">
                                <img :src="item.Img"
                                     style="width: 100%;margin-bottom: 10px;max-height: 136.5px;min-height: 136.5px">
                                <span v-text="item.CameraName">北京-顺义-天竺</span>
                                <span v-text="item.SupervisionName">安能分拣中心</span><br>
                                <span v-text="item.EventName">暴力分拣</span><br>
                                <span v-text="item.CreatedTime">2019-09-20 15:37:13</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-col-md3" style="padding-top: 10px;height: 100%;">
                <div class="layui-row data_count">
                    <div class="top_title">
                        <div class="event_icon"></div>
                        <div>数据总量</div>
                    </div>
                    <div class="count_map" id="count"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-layer-shade" id="layui-layer-shade" times="4" v-if="video_model"
         style="z-index: 19891017;background-color: rgba(15,7,1,0.64)">
        <div class="video-ma">
            <div style="height: 20px;width: 100%;color:#fff;margin-bottom: 10px;">
                <span>事件回放</span>
                <img src="/static/admin/img/gb.png" alt="" @click="goBack()" class="video_cancle">
            </div>
            <video id="my-video" class="video-js" controls preload="auto"  autoplay="autoplay" style="width:600px;height:400px;"
                   data-setup="{}" :src="BannerVideo" type="video/mp4">

            </video>
        </div>
    </div>
    <div class="info-detail" v-if="device_list">
        <div class="main-new">
            <div class="Sname" v-text="gName">河南省-郑州市-郑州市邮政管理局</div>
            <div class="Sclose"><a style="cursor: pointer" @click="closeDiv(1)"> <i
                            class="layui-icon  layui-icon-close"></i>
                </a></div>
            <div class="w350">
                <div class="name" v-text="dv_title"></div>
                <div class="dv_detail" v-show="dv_detail">
                    <div class="out_list" v-for="vo in dvList" @click="queryDvConfig(vo.pic_path+vo.pic_name)"
                         :title="vo.cameraname">
                        <img :src="vo.pic_path+vo.pic_name" style="width: 100%;height: 100%;"/>
                    </div>
                </div>
            </div>
            <div class="w640 video-hk">
                {{--                <img src="/static/admin/img/123456.png"/>--}}
                <video id="my-video" class="video-js" controls preload="auto" autoplay="autoplay" style="width:600px;height:400px;"
                       data-setup="{}" :src="BannerVideo1" type="video/mp4">
                </video>
                    <p style="text-align: center;color: #fff;">加载中....</p>
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
<script src="/static/jsencrypt.min.js"></script>
<script src="/static/jsWebControl-1.0.0.min.js"></script>
<script src="/static/china_map.js?v={{ rand(0,1000) }}"></script>
<script>
    new Vue({
        el: '#app_new',
        data: function () {
            return {
                top10_title: '各省事件排行TOP10',
                gName: '',
                BannerVideo:'',
                BannerVideo1:'',
                device_list: false,
                dv_detail: true,
                dv_title: 'sasd',
                dvList: [],
                pageKey: 0,
                element: null,
                canvas_map: null,
                menu_choose: false,
                canvas_time: false,
                canvas_count: false,
                canvas_top10: false,
                canvas_month: false,
                canvas_week: false,
                path: "{{Session::get('socket_adr')}}",
                socket: "",
                sdata: {
                    aEventZNs: null,
                    aIMapsInfo: null,
                },
                department_id: '{{$id}}',
                govcode: "",
                gov_code: "",
                govcodes: [],
                govName: "china",
                video_div: false,
                video_model: false,
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
                playData: {
                    CameraIndexCode: '',
                    StartTime: '',
                    EventType: ''
                },
                socketType: 0,
                v_type: 0,
            }
        },
        methods: {
            //查询设备配置
            queryDvConfig: function (obj) {
                var url1 = obj.replace(/.jpg/g,".mp4");
                var url = url1.replace(/C_/g,"");
                this.BannerVideo1 = url;
            },
            aEventNew: function (id, type) {
                this.$http.post('/admin/aevent/top', {id, type}, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.dvList = res.body.data;
                        } else {
                            layer.msg("查询失败");
                            return;
                        }
                    }, function () {
                        layer.msg("查询失败");
                        return;
                    })
            },
            closeDiv: function (type) {
                if (type == 0) {
                    this.detail_info = false;
                    this.info_main = true;
                } else {
                    if (this.oWebControl != null) {
                        // this.stopAllPreview()
                        // this.uninit()
                        this.oWebControl.JS_HideWnd();
                        var that = this
                        if (!!window.ActiveXObject || "ActiveXObject" in window) {// IE
                            that.device_list = false;
                        } else {
                            this.oWebControl.JS_Disconnect().then(function () {
                                //关闭成功后再关闭窗口不然会延迟
                                that.device_list = false;
                            }, function () {
                            });
                        }
                    } else {
                        //插件未安装或启动直接关闭弹出层
                        this.device_list = false;
                    }
                }
            },
            startPlayback: function (params, dvConfig) {
                // 录像回放
                var cameraIndexCode = params.indexCode;
                var startTimeStamp = this.getTimeStamp(params.startTime)
                var endTimeStamp = this.getTimeStamp(params.endTime)
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
                    layer.msg("端口不能为空！", 'error');
                    return
                } else if (!/^([0-9]|[1-9]\d{1,3}|[1-5]\d{4}|6[0-5]{2}[0-3][0-5])$/.test(port)) {
                    layer.msg("端口填写有误！", 'error');
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
                    layer.msg("时间格式有误！", 'error');
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
                        console.log("成功了")
                        if (that.v_type == 1) {
                            that.playVideo();
                        }
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
                            if (that.video_model == true) {
                                that.v_width = $(".video-ma").width()
                                var o_heigth = Math.round(that.v_width * 6 / 9)
                                var p_height = $(".video-ma").height()
                                that.v_height = (o_heigth < p_height) ? o_heigth : p_height;
                                $(".event_play").css("height", that.v_height);
                            }
                            if (that.device_list == true) {
                                that.v_width = $(".video-hk").width()
                                var o_heigth = Math.round(that.v_width * 6 / 9)
                                var p_height = $(".video-hk").height()
                                that.v_height = (o_heigth < p_height) ? o_heigth : p_height;
                                $(".event_play_back").css("height", that.v_height);
                            }
                            that.oWebControl.JS_SetDocOffset(map)
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
                            layer.confirm("插件启动失败，请检测下载，下载后需重启浏览器", {
                                    btn: ["下载", "取消"], cancel: function (index) {
                                        this.video_model = false
                                    }
                                }, function () {
                                    this.video_model = false
                                    that.downLoadExe();
                                    layer.close(index);
                                },
                                function () {
                                    this.video_model = false
                                }
                            )
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
            goBack: function () {
                if (this.oWebControl != null) {
                    this.oWebControl.JS_HideWnd();
                    var that = this;
                    if (!!window.ActiveXObject || "ActiveXObject" in window) {// IE
                        that.video_model = false
                    } else {
                        this.oWebControl.JS_Disconnect().then(function () {
                            //关闭成功后再关闭窗口不然会延迟
                            that.video_model = false
                        }, function () {
                        });
                    }
                } else {
                    //插件未安装或启动直接关闭弹出层
                    this.video_model = false
                }

            },
            queryEventTime: function (obj) {
                var url1 = obj.replace(/.gif/g,".mp4");
                var url = url1.replace(/C_/g,"");
                this.BannerVideo = url;
                this.video_model = true
            },
            playVideo: function () {
                var params = [];
                this.$http.post('/api/eventrecord/find', this.playData, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.ErrCode == 0) {
                            var rsp = JSON.parse(res.body.Rsp);
                            if (rsp.code == 0) {
                                params = rsp.data[0];
                                // params = {indexCode:cameraid,startTime:"2019-10-20 12:23:32",endTime:"2019-10-20 12:33:32"}
                                var dvConfig = {};
                                this.$http.post('/admin/device/vdconfig', {cameraid: cameraid}, {emulateJSON: true})
                                    .then(function (res) {
                                        if (res.body.code == 0) {
                                            dvConfig = res.body.data;
                                            this.startPlayback(params, dvConfig)
                                        } else {
                                            layer.msg("查询失败");
                                            return;
                                        }
                                    }, function () {
                                        layer.msg("查询失败");
                                        return;
                                    })
                            }
                        } else {
                            layer.msg("查询失败");
                            return;
                        }
                    }, function () {
                        layer.msg("查询失败");
                        return;
                    })
            },
            menu_click: function (type) {
                if (type == 0) {
                    this.menu_choose = this.menu_choose == false ? true : false;
                } else {
                    this.menu_choose = false;
                }
            },
            drawTop: function () {
                var div = document.getElementById('top10');
                this.setCharts(div, 'top10');
                var obj = echarts.init(div);
                var myColor = ['#33FFCC', '#33CCFF', '#0096f3', '#00c0e9', '#00e9db', '#34da62', '#d0a00e', '#d0570e', '#eb3600', '#eb2100'];
                var yData = ['北京', '上海', '广东', '江苏', '新疆', '内蒙古', '浙江', '贵州', '云南', '西安'];
                var seData = [6647, 7473, 8190, 8488, 9491, 11726, 12745, 13170, 21319, 24934];
                var option = {
                    grid: {
                        left: '3%',
                        top: '1%',
                        right: '10%',
                        bottom: '1%',
                        containLabel: true
                    },
                    xAxis: [{
                        show: false,
                    }],
                    yAxis: [{
                        axisTick: 'none',
                        axisLine: 'none',
                        offset: '10',
                        axisLabel: {
                            textStyle: {
                                color: '#ffffff',
                                fontSize: '12',
                            }
                        },
                        data: yData,
                    }, {
                        axisTick: 'none',
                        axisLine: 'none',
                        axisLabel: {
                            textStyle: {
                                color: '#ffffff',
                                fontSize: '0',
                            }
                        },
                        data: [10, 9, 8, 7, 6, 5, 4, 3, 2, 1]
                    }, {
                        data: [],
                    }],
                    series: [
                        {
                            name: '条',
                            type: 'bar',
                            yAxisIndex: 0,
                            data: seData,
                            label: {
                                normal: {
                                    show: true,
                                    position: 'right',
                                    formatter: '{c}',
                                    textStyle: {
                                        color: '#ffffff',
                                        fontSize: '12',
                                    }
                                }
                            },
                            barWidth: 10,
                            itemStyle: {
                                normal: {
                                    color: function (params) {
                                        var num = myColor.length;
                                        return myColor[params.dataIndex % num]
                                    },
                                }
                            },
                            z: 1
                        }
                    ]
                };
                var aevent_top10 = JSON.parse(window.localStorage.getItem('aevent_top10')) || [];
                if (aevent_top10) {
                    yData = [], seData = [];
                    for (var i in aevent_top10) {
                        if (aevent_top10[i].Name) {
                            //省市名称
                            var name = aevent_top10[i].Name.substring(0, 2);
                            if (name == '黑龙' || name == '内蒙') {
                                aevent_top10[i].Name = aevent_top10[i].Name.substring(0, 3);
                            } else {
                                aevent_top10[i].Name = name;
                            }
                            yData.push(aevent_top10[i].Name);
                            seData.push(aevent_top10[i].Value);
                        }
                    }
                    option.yAxis[0].data = yData;
                    option.series[0].data = seData.sort(function (a, b) {
                        return a - b;
                    });
                }
                obj.setOption(option, true);
                this.canvas_top10 = obj
            },
            drawCount: function () {
                var div = document.getElementById('count');
                this.setCharts(div, 'count');
                echarts.dispose(div)
                var obj = echarts.init(div);
                var colorList = [
                    '#C1232B', '#B5C334', '#FCCE10',
                    '#E87C25', '#27727B', '#FE8463',
                    '#9BCA63', '#FAD860', '#F3A43B',
                    '#60C0DD', '#D7504B', '#C6E579',
                    '#F4E001', '#F0805A', '#26C0C0'
                ];
                var option = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    // toolbox: {
                    //     show: true,
                    //     feature: {
                    //         magicType: {show: true, type: ['line']},
                    //         restore: {show: true},
                    //     }
                    // },
                    grid: {
                        left: '20px',
                        right: '5%',
                        bottom: '10%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        data: ['暴力分拣', '作业安检异常', '火灾', '传送带跨越', '爆仓'],
                        axisLabel: {
                            interval: 0,
                            rotate: 25,
                        },
                        splitLine: {
                            show: false
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#fff' //更改坐标轴颜色
                            }
                        },
                    },
                    yAxis: {
                        type: 'value',
                        name: '单位（万）',
                        splitLine: {
                            show: false
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#fff' //更改坐标轴颜色
                            }
                        },

                    },
                    series: [
                        {
                            type: 'bar',
                            barWidth: 10,
                            data: [100, 250, 150, 200, 350],
                            itemStyle: {
                                normal: {
                                    color: function (params) {
                                        return colorList[params.dataIndex];
                                    },
                                    barBorderRadius: [5, 5, 0, 0]
                                },
                            },
                        }
                    ],
                };
                var aevent_count = JSON.parse(window.localStorage.getItem('aevent_count'));
                if (aevent_count) {
                    xData = [], seData = [];
                    for (var i in aevent_count) {
                        xData.push(aevent_count[i].Name);
                        seData.push(aevent_count[i].Value);
                    }
                    option.xAxis.data = xData;
                    option.series[0].data = seData;
                    option.series[0].barWidth = 100 / seData.length;
                }
                obj.setOption(option);
                this.canvas_count = obj
            },
            drawTime: function () {
                function getDateArray(endDate, splitTime, count) {
                    if (!endDate) endDate = new Date();
                    if (!splitTime) splitTime = 10 * 60 * 1000;
                    if (!count) count = 5;
                    var endTime = endDate.getTime();
                    var mod = endTime % splitTime;
                    if (mod > 0) endTime -= mod;
                    var dateArray = [];
                    while (count-- > 0) {
                        var d = new Date();
                        d.setTime(endTime - count * splitTime);
                        var date = d.getHours() + ':' + (d.getMinutes() < 10 ? "0" + d.getMinutes() : d.getMinutes());
                        dateArray.push(date);
                    }
                    return dateArray;
                }

                var div = document.getElementById('time');
                this.setCharts(div, 'time');
                var obj = echarts.init(div);
                var xData = getDateArray();
                var xTitle = ["暴力分拣", "传送带跨越"];
                var colorList = [
                    '#C1232B', '#B5C334', '#FCCE10',
                    '#E87C25', '#27727B', '#FE8463',
                    '#9BCA63', '#FAD860', '#F3A43B',
                    '#60C0DD', '#D7504B', '#C6E579',
                    '#F4E001', '#F0805A', '#26C0C0'
                ];
                var option = {
                    color: colorList,
                    title: {
                        text: '',
                        textStyle: {
                            color: '#fff'
                        }
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'cross',
                            label: {
                                backgroundColor: '#6a7985'
                            }
                        }
                    },
                    legend: {
                        left: 0,
                        textStyle: {
                            color: '#fff'
                        },
                        data: xTitle
                    },
                    grid: {
                        top: '50',
                        left: '3%',
                        right: '4%',
                        bottom: '10%',
                        containLabel: true
                    },
                    xAxis: [
                        {
                            type: 'category',
                            boundaryGap: false,
                            axisLabel: {
                                color: "#fff"
                            },
                            splitLine: {
                                show: false
                            },
                            axisLine: {
                                lineStyle: {
                                    color: '#fff',
                                    width: 1, //这里是为了突出显示加上的
                                }
                            },
                            data: xData
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            axisLabel: {
                                color: "#fff"
                            },
                            axisLine: {
                                lineStyle: {
                                    color: '#fff',
                                    width: 1, //这里是为了突出显示加上的
                                }
                            },
                            splitLine: {
                                show: false
                            }
                        }
                    ],
                    series: [
                        {
                            name: '暴力分拣',
                            label: {
                                color: '#fff'
                            },
                            type: 'line',
                            stack: '总量',
                            symbol: 'none',  //这句就是去掉点的
                            smooth: true,  //这句就是让曲线变平滑的
                            areaStyle: {
                                color: 'rgba(159,83,29,0.5)'
                            },
                            lineStyle: {
                                color: '#d06312'
                            },
                            data: [260, 150, 200, 300, 400]
                        },
                        {
                            name: '传送带跨越',
                            type: 'line',
                            label: {
                                color: '#fff'
                            },
                            symbol: 'none',  //这句就是去掉点的
                            smooth: true,  //这句就是让曲线变平滑的
                            stack: '总量1',
                            areaStyle: {
                                color: 'rgba(6,112,96,0.5)'
                            },
                            lineStyle: {
                                color: '#04b58d'
                            },
                            data: [420, 700, 200, 100, 300]
                        }
                    ]
                };
                var aevent_time = JSON.parse(window.localStorage.getItem('aevent_time'));
                if (aevent_time) {
                    xData = [], dataList = [], seriesData = [], xTitle = [];
                    //组装数据
                    for (var i in aevent_time) {
                        xData.push(aevent_time[i]['Ctime']);
                        for (var n in aevent_time[i]['TypeCount']) {
                            if (i == 0) {
                                xTitle[n] = aevent_time[i]['TypeCount'][n]['EType'];
                                dataList[aevent_time[i]['TypeCount'][n]['EType']] = []
                            }
                            dataList[aevent_time[i]['TypeCount'][n]['EType']].push(aevent_time[i]['TypeCount'][n]['Value'])
                        }
                    }
                    for (var j in dataList) {
                        seriesData.push({
                            name: j,
                            label: {
                                color: '#fff'
                            },
                            type: 'line',
                            stack: j,
                            symbol: 'none',  //这句就是去掉点的
                            smooth: true,  //这句就是让曲线变平滑的
                            areaStyle: {
                                color: 'rgba(159,83,29,0.5)'
                            },
                            lineStyle: {
                                color: '#d06312'
                            },
                            data: dataList[j]
                        });
                    }
                    option.xAxis[0].data = xData;
                    option.legend.data = xTitle;
                    option.series = seriesData;
                }
                obj.setOption(option);
                this.canvas_time = obj
            },
            drawWeek: function () {
                function fun_date(aa) {
                    var date1 = new Date(),
                        time1 = date1.getFullYear() + "-" + (date1.getMonth() + 1) + "-" + date1.getDate();//time1表示当前时间
                    var date2 = new Date(date1);
                    date2.setDate(date1.getDate() + aa);
                    var time2 = date2.getFullYear() + "-" + (date2.getMonth() + 1) + "-" + date2.getDate();
                    return time2;
                }

                var div = document.getElementById('week');
                this.setCharts(div, 'week');
                var obj = echarts.init(div);
                var colorList = [
                    '#d06312', '#04b58d', '#FCCE10',
                    '#E87C25', '#27727B', '#FE8463',
                    '#9BCA63', '#FAD860', '#F3A43B',
                    '#60C0DD', '#D7504B', '#C6E579',
                    '#F4E001', '#F0805A', '#26C0C0'
                ];
                var option = {
                    color: colorList,
                    title: {
                        text: '',
                        textStyle: {
                            color: '#fff'
                        }
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'cross',
                            label: {
                                backgroundColor: '#6a7985'
                            }
                        }
                    },
                    legend: {
                        left: 0,
                        textStyle: {
                            color: '#fff'
                        },
                        data: ['暴力分拣', '传送带跨越']
                    },
                    grid: {
                        top: '50',
                        left: '8%',
                        right: '4%',
                        bottom: '0%',
                        containLabel: true
                    },
                    xAxis: [
                        {
                            type: 'category',
                            boundaryGap: false,
                            axisLabel: {
                                color: "#fff",
                                interval: 0,
                                rotate: 30,
                            },
                            splitLine: {
                                show: false
                            },
                            axisLine: {
                                lineStyle: {
                                    color: '#fff',
                                    width: 1, //这里是为了突出显示加上的
                                }
                            },

                            data: [fun_date(-7), fun_date(-6), fun_date(-5), fun_date(-4), fun_date(-3), fun_date(-2), fun_date(-1)]
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            axisLabel: {
                                color: "#fff"
                            },
                            axisLine: {
                                lineStyle: {
                                    color: '#fff',
                                    width: 1, //这里是为了突出显示加上的
                                }
                            },
                            splitLine: {
                                show: false
                            }
                        }
                    ],
                    series: [
                        {
                            name: '暴力分拣',
                            label: {
                                color: '#fff'
                            },
                            type: 'line',
                            stack: '暴力分拣',
                            symbol: 'none',  //这句就是去掉点的
                            smooth: true,  //这句就是让曲线变平滑的
                            areaStyle: {
                                color: 'rgba(159,83,29,0.5)'
                            },
                            lineStyle: {
                                color: colorList[0]
                            },
                            data: [260, 150, 200, 300, 250, 400, 350]
                        },
                        {
                            name: '传送带跨越',
                            type: 'line',
                            label: {
                                color: '#fff'
                            },
                            symbol: 'none',  //这句就是去掉点的
                            smooth: true,  //这句就是让曲线变平滑的
                            stack: '传送带跨越',
                            areaStyle: {
                                color: 'rgba(6,112,96,0.5)'
                            },
                            lineStyle: {
                                color: colorList[1]
                            },
                            data: [420, 500, 200, 100, 150, 50, 300]
                        }
                    ]
                };
                var aevent_week = JSON.parse(window.localStorage.getItem('aevent_week'));
                if (aevent_week) {
                    xData = [], dataList = [], seriesData = [], legendData = [];
                    var data = aevent_week;
                    //组装数据
                    for (var i in data) {
                        legendData.push(data[i]['Name']);
                        data[i]['TimeCounts'].sort(function (a, b) {
                            return b.Ctime < a.Ctime ? 1 : -1;
                        });
                        dataList[data[i]['Name']] = [];
                        for (var n in data[i]['TimeCounts']) {
                            if (i == 0) {
                                xData[n] = data[i]['TimeCounts'][n]['Ctime'];
                            }
                            dataList[data[i]['Name']].push(data[i]['TimeCounts'][n]['Value'])

                        }
                    }
                    xData.sort(function (a, b) {
                        return b < a ? 1 : -1;
                    });
                    var num = 0;
                    for (var i in dataList) {
                        seriesData.push({
                            name: i,
                            label: {
                                color: '#fff'
                            },
                            type: 'line',
                            stack: i,
                            symbol: 'none',  //这句就是去掉点的
                            smooth: true,  //这句就是让曲线变平滑的
                            areaStyle: {
                                color: '#d06312'
                            },
                            lineStyle: {
                                color: option.color[num]
                            },
                            data: dataList[i]
                        })
                        num++;
                    }
                    option.legend.data = legendData;
                    option.xAxis[0].data = xData;
                    option.series = seriesData;
                }
                obj.setOption(option);
                this.canvas_week = obj
            },
            drawMap: function () {
                if (this.govcode) this.govName = this.govcode;
                var aIMapsInfo = this.sdata.aIMapsInfo;
                var mapData = [];
                var that = this
                if (aIMapsInfo) {
                    if (this.department_id == 1) {
                        for (var i in aIMapsInfo) {
                            if (aIMapsInfo[i].Name) {
                                var pname = aIMapsInfo[i].Name.substring(0, 2);
                                if (pname == '黑龙' || pname == '内蒙') {
                                    aIMapsInfo[i].name = aIMapsInfo[i].Name.substring(0, 3);
                                } else {
                                    aIMapsInfo[i].name = pname;
                                }
                                mapData.push({
                                    name: aIMapsInfo[i].name,
                                    value: aIMapsInfo[i].Value,
                                    eventType: aIMapsInfo[i].EventType
                                });
                            }
                        }
                    } else if (this.department_id < 33 && this.department_id > 1) {
                        for (var i in aIMapsInfo) {
                            if (aIMapsInfo[i].GovName == this.govcodes) {
                                mapData.push({
                                    name: aIMapsInfo[i].GovName,
                                    value: aIMapsInfo[i].Value,
                                    eventType: aIMapsInfo[i].EventType
                                });
                            } else {
                                mapData.push({
                                    name: aIMapsInfo[i].GovName,
                                    value: aIMapsInfo[i].Value,
                                    eventType: aIMapsInfo[i].EventType
                                });
                            }
                        }
                    } else if (this.department_id > 32) {
                        for (var i in aIMapsInfo) {
                            if (aIMapsInfo[i].GovName) {
                                this.govName = aIMapsInfo[i].GovName;
                                mapData.push({
                                    name: this.govName,
                                    value: aIMapsInfo[i].Value,
                                    eventType: aIMapsInfo[i].EventType
                                });
                            } else {
                                mapData.push({
                                    name: this.govName,
                                    value: aIMapsInfo[i].Value,
                                    eventType: aIMapsInfo[i].EventType
                                });
                            }
                        }
                    }
                    window.localStorage.setItem('mapdata_aevent', JSON.stringify(mapData));
                }
                var map = []
                this.$http.post("admin/transportation/list/user", {department_id: this.department_id, type: 1}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                map = res.body.data
                            }
                            ChinaMap.loadMap('map', this.govName, true, map).on('click', function (param) {
                                $("#path").html(ChinaMap.formatPath('map', param.name));
                            });
                        }, function (res) {
                            ChinaMap.loadMap('map', this.govName, true, map).on('click', function (param) {
                                $("#path").html(ChinaMap.formatPath('map', param.name));
                            });
                        }
                    )
            },
            drawMonth: function () {
                var div = document.getElementById('month');
                this.setCharts(div, 'month');
                var obj = echarts.init(div);
                var option = {
                    color: ["#2E3530"],
                    radar: {
                        shape: 'circle',
                        name: {
                            textStyle: {
                                color: '#fff',
                            }
                        },
                        splitArea: {
                            areaStyle: {
                                color: ['#06183C', '#06183C', '#06183C', '#06183C'],
                                shadowColor: '#2E3530'
                            }
                        },
                        indicator: [
                            {
                                name: '暴力分拣',
                                max: 6500
                            },
                            {
                                name: '作业安检异常',
                                max: 16000
                            },
                            {
                                name: '传送带跨越',
                                max: 30000
                            },
                            {
                                name: '火灾',
                                max: 38000
                            },
                            {
                                name: '爆仓',
                                max: 52000
                            }
                        ]
                    },
                    series: [{
                        type: 'radar',
                        data: [{
                            value: [5000, 4000, 28000, 31000, 42000, 21000],
                            name: '数据',
                            itemStyle: {
                                normal: {
                                    color: '#755318'
                                }
                            },
                            areaStyle: {
                                normal: {
                                    color: '#27302D'
                                }
                            },
                            label: {
                                normal: {
                                    color: '#fff',
                                    show: true,
                                    formatter: (params) => {
                                        return params.value
                                    },
                                },
                            },
                        }]
                    }]
                };
                var aevent_month = JSON.parse(window.localStorage.getItem('aevent_month'));
                if (aevent_month) {
                    var CountList = aevent_month.CountList;
                    var HistoryCountList = aevent_month.HistoryCountList;
                    if (CountList && HistoryCountList) {
                        var indicatorData = [];
                        var seriesData = [];
                        for (var i in CountList) {
                            for (var j in HistoryCountList) {
                                if (CountList[i].Name == HistoryCountList[j].Name) {
                                    seriesData.push(CountList[i].Value);
                                    indicatorData.push({
                                        name: CountList[i].Name,
                                        max: HistoryCountList[j].Value
                                    });
                                }
                            }
                        }
                        option.radar.indicator = indicatorData;
                        option.series[0].data[0].value = seriesData;
                    }
                }
                obj.setOption(option);
                this.canvas_month = obj
            },
            setCharts: function (obj, id) {
                obj.setAttribute("width", $("#" + id + "").width() + 'px')
                obj.setAttribute("height", Math.round($("#" + id + "").height()) + 'px')
            },
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
            },
            open: function () {
                console.log("socket连接成功");
                this.send();
            },
            error: function () {
                console.log("连接错误")
                this.socketType = 0
            },
            getMessage: function (msg) {
                this.socketType = 1
                var sData = msg.data;
                sData = JSON.parse(sData);
                if (msg.data) {
                    // 实时数据
                    if (sData.DynamicMinEventZNs) {
                        window.localStorage.setItem('aevent_time',JSON.stringify(sData.DynamicMinEventZNs));
                        var data = sData.DynamicMinEventZNs;
                        var option = this.canvas_time.getOption();
                        var xData = [], dataList = [], seriesData = [], xTitle = [];
                        //组装数据
                        for (var i in data) {
                            xData.push(data[i]['Ctime']);
                            for (var n in data[i]['TypeCount']) {
                                if (i == 0) {
                                    xTitle[n] = data[i]['TypeCount'][n]['EType'];
                                    dataList[data[i]['TypeCount'][n]['EType']] = []
                                }
                                dataList[data[i]['TypeCount'][n]['EType']].push(data[i]['TypeCount'][n]['Value'])
                            }
                        }
                        for (var j in dataList) {
                            seriesData.push({
                                name: j,
                                label: {
                                    color: '#fff'
                                },
                                type: 'line',
                                stack: j,
                                symbol: 'none',  //这句就是去掉点的
                                smooth: true,  //这句就是让曲线变平滑的
                                areaStyle: {
                                    color: 'rgba(159,83,29,0.5)'
                                },
                                lineStyle: {
                                    color: '#d06312'
                                },
                                data: dataList[j]
                            });
                        }
                        option.xAxis[0].data = xData;
                        option.legend[0].data = xTitle;
                        option.series = seriesData;
                        this.canvas_time.setOption(option);
                    }
                    // 事件列表
                    if (sData.DynamicEventZNs) {
                        this.sdata.aEventZNs = sData.DynamicEventZNs;
                    }
                }
            },
            send: function () {
                var map = {};
                map['Action'] = "heart";
                map['Message'] = this.department_id.toString();
                map['DataType'] = 0;
                this.socket.send(JSON.stringify(map));
            },
            close: function () {
                console.log("socket已经关闭")
            },
            sData: function () {
                this.$http.post("/api/statistics/get", {
                    DataType: 0,
                    Did: this.department_id
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            if (this.department_id == 1)
                                this.top10_title = '各省事件排行TOP10';
                            if (this.department_id < 33 && this.department_id > 1)
                                this.top10_title = '各市区事件排行TOP10';
                            if (this.department_id > 32)
                                this.top10_title = '各企业事件排行TOP10';
                            var sData = JSON.parse(res.body.data);
                            // 事件top10
                            if (sData.EventTop10) {
                                window.localStorage.setItem('aevent_top10', JSON.stringify(sData.EventTop10));
                                var option = this.canvas_top10.getOption();
                                var yData = [], seData = [];
                                for (var i in sData.EventTop10) {
                                    if (sData.EventTop10[i].Name) {
                                        //省市名称
                                        var name = sData.EventTop10[i].Name.substring(0, 2);
                                        if (name == '黑龙' || name == '内蒙') {
                                            sData.EventTop10[i].Name = sData.EventTop10[i].Name.substring(0, 3);
                                        } else {
                                            sData.EventTop10[i].Name = name;
                                        }
                                        yData.push(sData.EventTop10[i].Name);
                                        seData.push(sData.EventTop10[i].Value);
                                    }
                                }
                                option.yAxis[0].data = yData;
                                option.series[0].data = seData.sort(function (a, b) {
                                    return a - b;
                                });
                                this.canvas_top10.setOption(option);
                            } else {
                                var option = this.canvas_top10.getOption();
                                var yData = [], seData = [];
                                option.yAxis[0].data = yData;
                                option.series[0].data = seData.sort(function (a, b) {
                                    return a - b;
                                });
                                this.canvas_top10.setOption(option);
                            }
                            // 数据总量
                            if (sData.EventTypes) {
                                window.localStorage.setItem('aevent_count', JSON.stringify(sData.EventTypes));
                                var option = this.canvas_count.getOption();
                                var xData = [], seData = [];
                                for (var i in sData.EventTypes) {
                                    xData.push(sData.EventTypes[i].Name);
                                    seData.push(sData.EventTypes[i].Value);
                                }
                                option.xAxis[0].data = xData;
                                option.series[0].data = seData;
                                option.series[0].barWidth = 100 / seData.length;
                                this.canvas_count.setOption(option);
                            }
                            // 地图数据
                            if (sData.IMapsInfo) {
                                this.sdata.aIMapsInfo = sData.IMapsInfo;
                                this.drawMap();
                            }
                            // 7天事件
                            if (sData.TimeETypeCount) {
                                var option = this.canvas_week.getOption();
                                var xData = [], dataList = [], seriesData = [], legendData = [];
                                if (sData.TimeETypeCount[6]) {
                                    var data = sData.TimeETypeCount[6].TimeEventTypes;
                                    window.localStorage.setItem('aevent_week', JSON.stringify(data));
                                    //组装数据
                                    for (var i in data) {
                                        legendData.push(data[i]['Name']);
                                        data[i]['TimeCounts'].sort(function (a, b) {
                                            return b.Ctime < a.Ctime ? 1 : -1;
                                        });
                                        dataList[data[i]['Name']] = [];
                                        for (var n in data[i]['TimeCounts']) {
                                            if (i == 0) {
                                                xData[n] = data[i]['TimeCounts'][n]['Ctime'];
                                            }
                                            dataList[data[i]['Name']].push(data[i]['TimeCounts'][n]['Value'])

                                        }
                                    }
                                    xData.sort(function (a, b) {
                                        return b < a ? 1 : -1;
                                    });
                                    var num = 0;
                                    for (var i in dataList) {
                                        seriesData.push({
                                            name: i,
                                            label: {
                                                color: '#fff'
                                            },
                                            type: 'line',
                                            stack: i,
                                            symbol: 'none',  //这句就是去掉点的
                                            smooth: true,  //这句就是让曲线变平滑的
                                            areaStyle: {
                                                color: '#d06312'
                                            },
                                            lineStyle: {
                                                color: option.color[num]
                                            },
                                            data: dataList[i]
                                        })
                                        num++;
                                    }
                                    option.legend[0].data = legendData;
                                    option.xAxis[0].data = xData;
                                    option.series = seriesData;
                                    this.canvas_week.setOption(option)
                                }
                            }
                            // 30天事件
                            if (sData.Days30EventCount) {
                                window.localStorage.setItem('aevent_month', JSON.stringify(sData.Days30EventCount));
                                var option = this.canvas_month.getOption();
                                var CountList = sData.Days30EventCount.CountList;
                                var HistoryCountList = sData.Days30EventCount.HistoryCountList;
                                if (CountList && HistoryCountList) {
                                    var indicatorData = [];
                                    var seriesData = [];
                                    for (var i in CountList) {
                                        for (var j in HistoryCountList) {
                                            if (CountList[i].Name == HistoryCountList[j].Name) {
                                                seriesData.push(CountList[i].Value);
                                                indicatorData.push({
                                                    name: CountList[i].Name,
                                                    max: HistoryCountList[j].Value
                                                });
                                            }
                                        }
                                    }
                                    option.radar[0].indicator = indicatorData;
                                    option.series[0].data[0].value = seriesData;
                                    this.canvas_month.setOption(option);
                                }
                            }
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '历史数据获取失败';
                        layer.msg(str);
                    })
            },
        },
        mounted: function () {
            var that = this;
            ChinaMap.VueObj = that;
            $(window).resize(function () {
                //that.canvas_map.resize();
                that.canvas_time.resize();
                that.canvas_count.resize();
                that.canvas_month.resize();
                that.canvas_week.resize();
                that.canvas_top10.resize();
            })
            // 滚动条scroll
            $(window).scroll(function () {
                if (that.oWebControl != null) {
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
                    if (this.video_model == true) {
                        that.v_width = $(".video-ma").width()
                        var o_heigth = Math.round(that.v_width * 6 / 9)
                        var p_height = $(".video-ma").height()
                        that.v_height = (o_heigth < p_height) ? o_heigth : p_height;
                        $(".event_play").css("height", that.v_height);
                    }
                    if (this.device_list == true) {
                        that.v_width = $(".video-hk").width()
                        var o_heigth = Math.round(that.v_width * 6 / 9)
                        var p_height = $(".video-hk").height()
                        that.v_height = (o_heigth < p_height) ? o_heigth : p_height;
                        $(".event_play_back").css("height", that.v_height);
                    }
                    that.oWebControl.JS_Resize(that.v_width, that.v_height);
                    that.oWebControl.JS_SetDocOffset(map)
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
                // 关闭socket连接
                if (this.socket) this.socket.close();
            });
            $("#app_new").show();
        },
        created: function () {
            var that = this;
            this.$http.post("/admin/department/govcode", {}, {emulateJSON: true})
                .then(function (res) {
                        if (res.body.code == 0) {
                            var gov = res.body.data.govcode.substring(0, 2);
                            var gov1 = res.body.data.govcode.split('0000')[0];
                            if (gov === gov1) {
                                // 省级code
                                this.govcode = gov;
                            } else {
                                // 地市级code
                                if (gov === '11' || gov === '12' || gov === '46') {
                                    this.govcode = gov;
                                    this.govcodes = res.body.data.govcode.split(',');
                                } else {
                                    this.govcode = gov1;
                                    this.govcodes = [];
                                }
                            }
                            this.$nextTick(function () {
                                if (this.path) this.socketInit();
                                this.drawMap();
                                this.sData();
                                this.drawTime();
                                this.drawWeek();
                                this.drawCount();
                                this.drawMonth();
                                this.drawTop();
                            })
                        } else {
                            var str = lea.msg(res.body.msg) || '查询失败';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '查询失败';
                        layer.msg(str);
                    }
                )
            layui.use(['element'], function () {
                that.element = layui.element
            })
        }
    })
</script>
</body>
</html>