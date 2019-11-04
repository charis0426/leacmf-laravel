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
        /*min-height: 800px;*/
        background: url(/static/admin/img/bg.png) no-repeat #061537;
        background-size: cover;
        overflow-y: hidden;
        position: absolute;
    }

    .head_top {
        height: 56px;
        position: relative;
        background: url(/static/admin/img/jgsj.png);
        background-position: center;
        background-repeat: no-repeat;


    }

    .xiala_top {

        height: 35px;
        width: 120px;
        background: url(/static/admin/img/xiala.png) no-repeat #061537;
        color: #07d8e8;
        position: absolute;
        right: 0px;
        top: 15px;
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
        width: 25%;
        float: left;
        min-width: 330px;

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
        height: calc(100% - 177px) !important;
        height: -moz-calc(100% - 177px) !important;
        height: -webkit-calc(100% - 177px) !important;
    }

    .event_all > div {
        height: 100%;
    }

    .event_left:nth-child(1) {
        background-image: url(/static/admin/img/zuoye_event.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
        margin-top: -10px;
        margin-bottom: 10px;
    }

    .event_left:nth-child(2) {
        background-image: url(/static/admin/img/video_event.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
    }

    #map {
        height: 100%;
        width: 100%;
    }

    .event_top {
        color: #fff;
        height: 40%;
        background-image: url(/static/admin/img/jianguan.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;

        margin-bottom: 10px;
        padding: 20px 20px 0px 20px;
    }

    #zuoye, #count {
        margin-top: 5px;
    }

    .zuoye_count, .video_count {
        height: 30%;
        padding: 20px 20px 0px 20px;
        background-image: url(/static/admin/img/jianguan_count.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
    }

    .event_left {
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
        height: calc(100% - 45px) !important;
        height: -moz-calc(100% - 45px) !important;
        height: -webkit-calc(100% - 45px) !important;
        padding: 10px;
        overflow-y: auto;
    }

    .event_left .event_body > img {
        width: 100%;
        height: calc(100% - 170px) !important;
        height: -moz-calc(100% - 170px) !important;
        height: -webkit-calc(100% - 170px) !important;
        min-height: 50px;
    }

    .event_left .event_body::-webkit-scrollbar { /*滚动条整体样式*/
        width: 2px; /*高宽分别对应横竖滚动条的尺寸*/
        height: 1px;
    }

    .event_left .event_body::-webkit-scrollbar-thumb { /*滚动条里面小方块*/
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 5px rgba(4, 22, 57, 1);
        background: #535353;
    }

    .event_left .event_body::-webkit-scrollbar-track { /*滚动条里面轨道*/
        -webkit-box-shadow: inset 0 0 5px rgba(4, 22, 57, 1);
        border-radius: 10px;
        background: #EDEDED;
    }

    .eventv_body .event-info::-webkit-scrollbar { /*滚动条整体样式*/
        width: 2px; /*高宽分别对应横竖滚动条的尺寸*/
        height: 1px;
    }

    .eventv_body .event-info::-webkit-scrollbar-thumb { /*滚动条里面小方块*/
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 5px rgba(4, 22, 57, 1);
        background: #535353;
    }

    .eventv_body .event-info::-webkit-scrollbar-track { /*滚动条里面轨道*/
        -webkit-box-shadow: inset 0 0 5px rgba(4, 22, 57, 1);
        border-radius: 10px;
        background: #EDEDED;
    }

    .event_txt {
        padding: 10px 10px 0px 10px;
    }

    .event_txt p {
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
        height: 22px;
    }

    .eventv_body .event-info {
        overflow-y: auto;
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

    .enent_right {

        height: calc(100% - 80px) !important;
        height: -moz-calc(100% - 80px) !important;
        height: -webkit-calc(100% - 80px) !important;
    }

    .top_title {
        color: #fff;
        line-height: 20px;
    }

    .top_title > div {
        float: left;
    }

    .jindu {
        padding-left: 7px;
    }

    .jindu .layui-form-item .layui-input-block {
        margin-left: 45px;
        margin-right: 45px;
        min-height: 20px !important;
        max-height: 20px !important;
        height: 20px !important;
        /*padding-top: 7px;*/
    }

    .jindu .layui-form-item .layui-form-label {
        width: 45px !important;
        height: 20px !important;
        color: #fff;
        padding: 0px !important;
    }

    .jindu .layui-form-item .bl {
        float: right;
    }

    .bar-color {
        background-color: #07d8e8;
    }

    .jindu .layui-form-item {
        margin-bottom: 0px !important;
        margin-top: 1.1%;
    }

    .layui-progress {
        height: 8px !important;
        top: 5px;
        background-color: rgba(7, 216, 232, 0.1);
    }

    .layui-progress-bar {
        height: 8px !important;
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

    .xiala_li > ul > li > a {
        color: #fff !important;
    }

    .xiala_li > ul > li > a:hover {
        color: #07d8e8 !important;
    }
    .layui-input{

        background: transparent;
        border: 0px;
        color: #00fefe;
        width: 289px;
    }
    .layui-input:hover{

        background: transparent;
        border: 0px;
        color: #00fefe;
        width: 289px;
    }
    .layui-form-select dl{
        background-color: #061537;
    }
    .layui-form-select dl dd.layui-this{

        background-color: rgba(1,158,255,0.6)
    }
    .layui-form-select dl dd:hover{
        background-color: rgba(1,158,255,0.7)
    }
    .info-detail{
        color:#119fff;
        height: 501px;
        width:1118px;
        background: url(/static/admin/img/playback.png) no-repeat;
        position: absolute;
        top:50%;
        left:50%;
        margin-top:-250px;
        margin-left:-560px;



    }
    .w350{
        width: 350px;
        background: #001c4d;
        height: 360px;
        margin-top: 20px;
        margin-left: 64px;
        float: left;
    }
    .w350 .name{
        width: 330px;
        background: #002564;
        height: 40px;
        line-height: 40px;
        font-size: 16px;

        padding-left: 20px;
    }
    .w640{
        width:640px;
        height: 360px;
        float: left;
        margin-top: 20px;
        margin-left: 10px;
    }
    .Sname{
        height: 45px;
        line-height: 45px;
        width: 1104px;
        text-align: center;
        font-size: 16px;
        color: #07d8e8;
        padding-left: 16px;
    }
    .Sclose{
        height: 10px;
        width: 1064px;
        text-align: right;
        font-size: 16px;
        color: #07d8e8;
        padding-left: 16px;
        padding-right: 50px;
    }
    .Sclose a {padding:5px;color: #07d8e8;}
    .dv_detail {
        height: 320px;

        overflow-y: auto;
    }

    .out_list,.out_hover{
        height: 40px;
        line-height: 40px;
        padding-left: 35px;
        font-size: 15px;
        color: #119fff;

    }
    .out_list:hover,.out_hover{
        background: url(/static/admin/img/hover.png) no-repeat;
        cursor:pointer;
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
    #playWnd>img{
        display: none;
    }
    .search {

        height: 35px;
        width: 289px;
        background: url(/static/admin/img/search_bg.png) no-repeat #061537;
        color: #07d8e8;
        position: absolute;
        right: 130px;
        top: 15px;
    }
    #app_new{
        display: none;
    }
</style>
<body layadmin-themealias="default">
<div id="app_new" class="layui-fluid">
    <div class="head_top">
        <div class="search layui-inline">
            <div class="layui-input-inline layui-form">
                <select name="modules"  id="selectData" lay-filter="selectData" placeholder="请输入转运中心名称"  lay-search=""  >
                    <option value="">请选择或搜索选择监管对象</option>
                    <option :value="backObjectData(va)" v-for="va  in objectList">@{{ va.name }}</option>
                </select>
            </div>
        </div>
        <div class="xiala_top" @click="menu_click(0)">
            <span>监管对象</span>
        </div>
        <div class="xiala_li" v-show="menu_choose" v-on:mouseleave="menu_click(1)">
            <ul>
                <li><a href="/">监管对象</a></li>
                <li><a href="/aevent">智能分析</a></li>
                <li><a href="/ievent">视频巡检</a></li>
                <li><a href="/admin/index">系统管理</a></li>
            </ul>
        </div>
    </div>
    <div class="count_li">
        <div class="layui-row layui-col-space20 x-body">
            <div class="layui-col-md2-5">
                <div class="count_list">
                    <div class="count_title">
                        <img src="/static/admin/img/sjbk_1.png" alt="">
                        <span>转运中心接入数量</span>
                    </div>
                    <div class="count_num" v-html="transitNum">
                    </div>
                </div>
            </div>
            <div class="layui-col-md2-5">
                <div class="count_list">
                    <div class="count_title">
                        <img src="/static/admin/img/sjbk_2.png" alt="">
                        <span>点位接入数量</span>
                    </div>
                    <div class="count_num" v-html="dotNum">
                    </div>
                </div>
            </div>
            {{--<div class="layui-col-md2-5">--}}
                {{--<div class="count_list">--}}
                    {{--<div class="count_title">--}}
                        {{--<img src="/static/admin/img/sjbk_3.png" alt="">--}}
                        {{--<span>平台接入数量</span>--}}
                    {{--</div>--}}
                    {{--<div class="count_num" v-html="platFormAccessNum">--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="layui-col-md2-5">
                <div class="count_list">
                    <div class="count_title">
                        <img src="/static/admin/img/sjbk_4.png" alt="">
                        <span>视频巡检总数</span>
                    </div>
                    <div class="count_num" v-html="vdNum">
                    </div>
                </div>
            </div>
            <div class="layui-col-md2-5">
                <div class="count_list">
                    <div class="count_title">
                        <img src="/static/admin/img/sjbk_5.png" alt="">
                        <span>作业监管总数</span>
                    </div>
                    <div class="count_num" v-html="zyNum">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="event_all layui-row">
        <div class="layui-col-md3" style="padding-top: 10px">
            <div class="layui-row event_left">
                <div class="top_title">
                    <div class="event_icon"></div>
                    <div>作业违规监管最新事件</div>
                </div>
                <div class="event_body" v-show="zuoyeShow"
                     @click="playVideo(DynamicEventZNs.Img)">
                    <img :src="DynamicEventZNs.Img" alt="">
                    <div class="event_txt">
                        <p>组织结构名称: @{{ DynamicEventZNs.DepartmentName}}</p>
                        <p>监管对象名称: @{{ DynamicEventZNs.SupervisionName }}</p>
                        <p>监管对象类型: @{{ DynamicEventZNs.SupervisionType }}</p>
                        <p>事件上报设备: @{{ DynamicEventZNs.CameraName }}</p>
                        <p>事&nbsp;&nbsp;件&nbsp;&nbsp;类&nbsp;&nbsp;型: @{{ DynamicEventZNs.EventName }}</p>
                        <p>事件上报时间: @{{ DynamicEventZNs.CreatedTime }}</p>
                    </div>
                </div>
            </div>
            <div class="layui-row event_left">
                <div class="top_title">
                    <div class="event_icon"></div>
                    <div>视频巡检监管最新事件</div>
                </div>
                <div class="eventv_body">
                    <div class="event-info" v-for="vo in DynamicEventXJs">
                        <p>组织结构名称: @{{ vo.DepartmentName}}</p>
                        <p>监管对象名称: @{{ vo.SupervisionName }}</p>
                        <p>监管对象类型: @{{ vo.SupervisionType }}</p>
                        <p>事件上报设备: @{{ vo.CameraName }}</p>
                        <p>事&nbsp;&nbsp;件&nbsp;&nbsp;类&nbsp;&nbsp;型: @{{ vo.EventType }}</p>
                        <p>事件上报时间: @{{ vo.CreatedTime }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div id="path" style="height:30px; text-align:center;color:#fff">全国</div>
            <div id="map"></div>
        </div>
        <div class="layui-col-md3 enent_right">
            <div class="layui-row event_top">
                <div class="top_title">
                    <div class="event_icon"></div>
                    <div v-text="top10_title"></div>
                </div>
                <div class="count_map" id="top10"></div>
            </div>
            <div class="layui-row zuoye_count" style="margin-bottom: 10px">
                <div class="top_title">
                    <div class="event_icon"></div>
                    <div>作业监控事件统计</div>
                </div>
                <div class="count_map" id="zuoye"></div>
            </div>
            <div class="layui-row video_count">
                <div class="top_title">
                    <div class="event_icon"></div>
                    <div>视频巡检事件统计</div>
                </div>
                <div class="count_map" id="count"></div>
            </div>
        </div>
    </div>
    <div class="info-detail" v-if="device_list">

        <div class="main-new">
            <div class="Sname" v-text="gName"></div>
            <div class="Sclose" @click="goBack(1)" > <a @click="goBack(1)"> <i class="layui-icon  layui-icon-close"  ></i> </a> </div>

            <div class="w350" >
                <div class="name" v-text="dv_title"></div>
                <div class="dv_detail" v-show="dv_detail">
                    <div class="out_list" v-for="vo in dvList" @click="queryDvConfig(vo.cameraid)" :title="vo.name">
                        <span>@{{vo.name}}</span>
                    </div>
                </div>
            </div>
            <div class="w640 video-hk">
                {{--<img src="/static/admin/img/123456.png"  />--}}
                <div id="playWnd" class="playWnd" style="">
                    <p style="text-align: center;color: #fff;">加载中....</p>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-layer-shade" id="layui-layer-shade" times="4" v-if="video_model"
         style="z-index: 19891017;background-color: rgba(15,7,1,0.64)">
        <div class="video-ma">
            <div style="height: 20px;width: 100%;color:#fff;margin-bottom: 10px;">
                <span>视频播放</span>
                <img src="/static/admin/img/gb.png" alt="" @click="goBack(0)" class="video_cancle">
                {{--  <div id="playWnd" class="playWnd"></div> --}}
                <video id="my-video" class="video-js" controls preload="auto" autoplay="autoplay" style="width:600px;height:400px;"
                       data-setup="{}" :src="BannerVideo" type="video/mp4">
                </video>
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
<script src="/static/china_map.js?v={{ rand(0,1000) }}"></script>
<script src="/static/jsencrypt.min.js"></script>
<script src="/static/jsWebControl-1.0.0.min.js"></script>
<script>
    new Vue({
        el: '#app_new',
        data: function () {
            return {
                gName:'',
                top10_title:"各省事件排行TOP10",
                BannerVideo:'',
                objectList:[],
                video_model:false,
                device_list:false,
                dv_detail:true,
                dv_title:'',
                dvList:[],
                element: null,
                zuoyeShow: false,
                canvas_map: null,
                menu_choose: false,
                canvas_zuoye: false,
                canvas_count: false,
                canvas_top10: false,
                path: "{{Session::get('socket_adr')}}",
                sdata: {
                    aIMapsInfo: [],
                },
                department_id: '{{$id}}',
                govcode: "",
                gov_code: "",
                govcodes: [],
                govName: "china",
                transitNum: '',
                dotNum: '',
                platFormAccessNum: '',
                vdNum: '',
                zyNum: '',
                DynamicEventZNs: {
                    "DepartmentName": "",
                    "CameraId":"",
                    "EventType":"",
                    "Img": "",
                    "CameraName": "",
                    "EventName": "",
                    "CreatedTime": "",
                    "SupervisionType": "",
                    "SupervisionName": ""
                },
                DynamicEventXJs: [],
                DynamicMinEventXJs: [],
                DynamicMinEventZNs: [],
                colorList: {
                    '1': '#d06312', '2': '#04b58d', '3': '#FCCE10',
                    '4': '#E87C25', '5': '#27727B', '6': '#FE8463',
                    '7': '#9BCA63', '8': '#FAD860', '9': '#F3A43B',
                    '10': '#60C0DD', '11': '#D7504B', '12': '#C6E579',
                    '13': '#F4E001', '14': '#F0805A', '15': '#26C0C0'
                },
                socketType: 0,
                isReconnect: 0,
                pageKey:2,
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
                v_type:0,
                eventPlayList:{},
                gdEventType:['断网','无信号','遮挡','场景变更','视频丢帧']
            }
        },
        methods: {
            backObjectData:function(va){
                return va.id+","+va.type+','+va.dname+","+va.name
            },
            //查询设备配置
            queryDvConfig: function (cameraid) {
                var dvConfig = {};
                this.$http.post('/admin/device/vdconfig', {
                    cameraid: cameraid
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            dvConfig = res.body.data;
                            this.$http.post('/admin/device/encoding', {cameraid: cameraid}, {emulateJSON: true})
                                .then(function (res) {
                                    if (res.body.code == 0) {
                                        var params = res.body.data;
                                        this.startPreview(dvConfig,params['CameraIndexCode'])
                                    } else {
                                        layer.msg("查询失败");
                                        return;
                                    }
                                }, function () {
                                    layer.msg("查询失败");
                                    return;
                                })
                        } else{
                            layer.msg("查询失败");
                            return;
                        }
                    }, function () {
                        layer.msg("查询失败");
                        return;
                    })

            },
            queryDvList:function(id,type){
                this.initPlugin()
                this.$http.post('/index/dvlist', {id:id,type:type}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.dvList = res.body.data;
                            } else {
                                var str = lea.msg(res.body.msg) || '查询失败';
                                layer.msg(str);
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '查询失败';
                            layer.msg(str);
                        }
                    )

            },
            // 视频预览
            startPreview:function(config,cameraid){
                var appkey = config.appkey;
                var secret = this.setEncrypt(config.appsecret);
                var ip = config.artemisip;
                var szPort = config.artemisport;
                var cameraIndexCode  = cameraid;
                var szPermisionType = config.privilege;
                var streamMode = +config.streamMode;
                var transMode = +config.transMode;
                var gpuMode = +config.gpuMode;
                var wndId = config.wndId;
                var encryptedFields = config.encryptedFieldsPLay;
                encryptedFields = encryptedFields.split(',');
                encryptedFields.forEach((item)=> {
                    // secret固定加密，其它根据配置加密
                    if (item == 'ip') {
                        ip = this.setEncrypt(ip)
                    }
                    if (item == 'appkey') {
                        appkey = this.setEncrypt(appkey)
                    }
                })
                encryptedFields = encryptedFields.join(",");
                var port = parseInt(szPort);
                var PermisionType=parseInt(szPermisionType);
                var enableHttps = parseInt(config.enableHTTPS);
                if (wndId>=1)//指定窗口回放
                {
                    wndId = parseInt(wndId, 10);
                }
                else if (0 == wndId) //空闲窗口回放
                {
                    wndId = 0;
                }

                if (!cameraIndexCode ) {
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

                if(!PermisionType){
                    layer.msg("PermisionType不能为空！");
                    return
                }

                if (!port) {
                    layer.msg("端口不能为空！", 'error');
                    return
                } else if (!/^([0-9]|[1-9]\d{1,3}|[1-5]\d{4}|6[0-5]{2}[0-3][0-5])$/.test(port)) {
                    layer.msg("端口填写有误！", 'error');
                    return
                }
                this.oWebControl.JS_RequestInterface({
                    funcName: "startPreview",
                    argument: JSON.stringify({
                        cameraIndexCode : cameraIndexCode ,
                        appkey: appkey,
                        secret: secret,
                        ip: ip,
                        port: port,
                        enableHTTPS: enableHttps,
                        streamMode: streamMode,
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
                            playMode: parseInt(that.v_type),
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
                        console.log("启动成功")
                        if(that.v_type == 1){
                            that.queryEventDetail()
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
                            that.oWebControl.JS_SetDocOffset(map)

                            if (that.video_model == true) {
                                that.v_width = $(".video-ma").width()
                                var o_heigth = Math.round(that.v_width * 6 / 9)
                                var p_height = $(".video-ma").height()
                                that.v_height = (o_heigth < p_height) ? o_heigth : p_height;
                                $(".playWnd").css("height", that.v_height);
                            }
                            if (that.device_list == true) {
                                that.v_width = $(".video-hk").width()
                                var o_heigth = Math.round(that.v_width * 6 / 9)
                                var p_height = $(".video-hk").height()
                                that.v_height = (o_heigth < p_height) ? o_heigth : p_height;
                            }
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
                                        this.device_list = false
                                    }
                                }, function () {
                                    this.video_model = false
                                    this.device_list = false
                                    that.downLoadExe();
                                    layer.close(index);
                                },
                                function () {
                                    this.video_model = false
                                    this.device_list = false
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
            playVideo: function (obj) {
                var url1 = obj.replace(/.gif/g,".mp4");
                var url = url1.replace(/C_/g,"");
                this.BannerVideo = url;
                this.video_model = true
            },
            queryEventDetail:function(){
                var params = [];
                this.$http.post('/api/eventrecord/find', this.eventPlayList, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.ErrCode == 0) {
                            var rsp = JSON.parse(res.body.Rsp);
                            if (rsp.code == 0) {
                                params = rsp.data[0];
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
            goBack: function (type) {
                if (this.oWebControl != null) {
                    this.oWebControl.JS_HideWnd();
                    var that = this
                    if (!!window.ActiveXObject || "ActiveXObject" in window) {// IE
                        if(type == 0){
                            that.video_model = false
                        }else{
                            that.device_list = false
                        }
                    } else {
                        this.oWebControl.JS_Disconnect().then(function () {
                            //关闭成功后再关闭窗口不然会延迟
                            if(type == 0){
                                that.video_model = false
                            }else{
                                that.device_list = false
                            }
                        }, function () {
                        });
                    }
                } else {
                    //插件未安装或启动直接关闭弹出层
                    if(type == 0){
                        this.video_model = false
                    }else{
                        this.device_list = false
                    }

                }
            },
            splitBackData: function (str) {
                str = str + "";
                var data = str.split("");
                var string = '';
                var num = 0;
                for (var i = data.length - 1; i >= 0; i--) {
                    num++;
                    if (num == 3 && i < data.length - 1) {
                        if (i == 0) {
                            string = "<div class='count_num_int'>" + data[i] + "</div>" + string;
                        } else {
                            string = "<div class='count_num_fg'>,</div><div class='count_num_int'>" + data[i] + "</div>" + string;
                        }
                        num = 0;
                    } else {
                        string = "<div class='count_num_int'>" + data[i] + "</div>" + string;
                    }
                }
                return string;
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
                obj.setOption(option, true);
                this.canvas_top10 = obj
            },
            drawCount: function (name, obj_name) {
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

                var div = document.getElementById(name);
                this.setCharts(div, name);
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
                obj.setOption(option);
                if (obj_name == 'canvas_zuoye') {
                    this.canvas_zuoye = obj
                } else if (obj_name == 'canvas_count') {
                    this.canvas_count = obj
                }

            },
            drawMap: function () {
                if (this.govcode) this.govName = this.govcode;
                var aIMapsInfo = this.sdata.aIMapsInfo;
                var mapData = [];
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
                                    xj:aIMapsInfo[i].DynamicNumsXJ,
                                    zy:aIMapsInfo[i].DynamicNumsZN,
                                    eventType: aIMapsInfo[i].EventType,
                                    trans:aIMapsInfo[i].TransCenterAccess
                                });
                            }
                        }
                    } else if (this.department_id < 33) {
                        for (var i in aIMapsInfo) {
                            if (aIMapsInfo[i].GovName) {
                                mapData.push({
                                    name: aIMapsInfo[i].GovName,
                                    value: aIMapsInfo[i].Value,
                                    xj:aIMapsInfo[i].DynamicNumsXJ,
                                    zy:aIMapsInfo[i].DynamicNumsZN,
                                    eventType: aIMapsInfo[i].EventType,
                                    trans:aIMapsInfo[i].TransCenterAccess
                                });
                            }
                        }
                    } else if (this.department_id > 32) {
                        for (var i in aIMapsInfo) {
                            if (aIMapsInfo[i].GovName) {
                                this.govName = aIMapsInfo[i].GovName;
                                mapData.push({
                                    name: aIMapsInfo[i].GovName,
                                    value: aIMapsInfo[i].Value,
                                    xj:aIMapsInfo[i].DynamicNumsXJ,
                                    zy:aIMapsInfo[i].DynamicNumsZN,
                                    eventType: aIMapsInfo[i].EventType,
                                    trans:aIMapsInfo[i].TransCenterAccess
                                });
                            } else {
                                mapData.push({
                                    name: this.govName,
                                    value: aIMapsInfo[i].Value,
                                    xj:aIMapsInfo[i].DynamicNumsXJ,
                                    zy:aIMapsInfo[i].DynamicNumsZN,
                                    eventType: aIMapsInfo[i].EventType,
                                    trans:aIMapsInfo[i].TransCenterAccess
                                });
                            }
                        }
                    }
                    window.localStorage.setItem('mapData_index', JSON.stringify(mapData));
                }
                var map = []
                this.$http.post("/admin/transportation/list/user", {department_id: this.department_id}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                map = res.body.data
                                this.objectList = res.body.data
                                var that = this
                                this.$nextTick(function () {
                                    that.form.render();
                                })
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
                }
            },
            open: function () {
                this.socketType = 1
                console.log("socket连接成功");
                this.send();
            },
            error: function () {
                this.socketType = 0
                console.log("连接错误")
                this.drawMap()
                var zuoyeData = JSON.parse(window.localStorage.getItem('DynamicEventZNs')) || [];
                if (zuoyeData.length >= 1) {
                    this.zuoyeShow = true
                    this.DynamicEventZNs = zuoyeData[0]
                }
                this.$nextTick(function () {
                    var width =$(".event_body").width();
                    var height = width*9/16;
                    $(".event_left .event_body > img").css("min-height", height);
                })
                var videoData = JSON.parse(window.localStorage.getItem('DynamicEventXJs')) || [];
                var videoDataLen = videoData.length
                if (videoData.length >= 1) {
                    this.DynamicEventXJs = videoData.slice(videoDataLen > 2 ? -2 : -videoDataLen)
                }
                var TransitCenterNums = window.localStorage.getItem('TransitCenterNums')|| 0;
                this.transitNum = this.splitBackData(TransitCenterNums);
                var dotNum = window.localStorage.getItem('CamraAccess')|| 0;
                this.dotNum = this.splitBackData(dotNum);
                var XJNums = window.localStorage.getItem('XJNums')|| 0;
                this.vdNum = this.splitBackData(XJNums);
                var ZNNums = window.localStorage.getItem('ZNNums')|| 0;
                this.zyNum = this.splitBackData(ZNNums);
            },
            send: function () {
                var map = {};
                map['Action'] = "heart";
                map['Message'] = this.department_id.toString();
                map['DataType'] = 2;
                this.socket.send(JSON.stringify(map))
            },
            close: function () {
                this.socketType = 0
                console.log("socket已经关闭")
            },
            getMessage: function (msg) {
                var sData = msg.data;
                if (msg.data) sData = JSON.parse(sData);
                console.log(sData)
                if (sData.DynamicEventZNs) {
                    window.localStorage.setItem('DynamicEventZNs', JSON.stringify(sData.DynamicEventZNs));
                    var zuoyeData = sData.DynamicEventZNs
                } else {
                    var zuoyeData = JSON.parse(window.localStorage.getItem('DynamicEventZNs')) || [];
                }
                var zuoyeDataLen = zuoyeData.length
                if (zuoyeDataLen >= 1) {
                    this.zuoyeShow = true
                    this.DynamicEventZNs = zuoyeData[zuoyeDataLen-1]
                }
                this.$nextTick(function () {
                    var width =$(".event_body").width();
                    var height = width*9/16;
                    $(".event_left .event_body > img").css("min-height", height);
                })
                if (sData.DynamicEventXJs) {
                    window.localStorage.setItem('DynamicEventXJs', JSON.stringify(sData.DynamicEventXJs));
                    var videoData = sData.DynamicEventXJs
                } else {
                    var videoData = JSON.parse(window.localStorage.getItem('DynamicEventXJs')) || [];
                }
                var videoDataLen = videoData.length
                if (videoDataLen >= 1) {
                    var map =  videoData.slice( videoDataLen > 2 ? -2 : -videoDataLen)
                    if(this.DynamicEventXJs.length == 2){
                        for (var i=0;i<map.length; i++){
                            this.DynamicEventXJs[i] = map[i]
                        }
                    }else {
                        this.DynamicEventXJs =  map
                    }
                }
                //作业监管事件统计
                this.DynamicMinEventZNs = sData.DynamicMinEventZNs || []
                if (this.DynamicMinEventZNs.length != 0) {
                    window.localStorage.setItem('DynamicMinEventZNs_11', JSON.stringify(this.DynamicMinEventZNs));
                } else {
                    this.DynamicMinEventZNs = JSON.parse(window.localStorage.getItem('DynamicMinEventZNs_11')) || [];
                }
                if (this.DynamicMinEventZNs.length != 0) {
                    var data = this.DynamicMinEventZNs;
                    var option = this.canvas_zuoye.getOption();
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
                    this.canvas_zuoye.setOption(option);
                }
                //视频巡检事件统计
                this.DynamicMinEventXJs = sData.DynamicMinEventXJs || []
                if (this.DynamicMinEventXJs.length != 0) {
                    window.localStorage.setItem('DynamicMinEventXJs_11', JSON.stringify(this.DynamicMinEventXJs));
                } else {
                    this.DynamicMinEventXJs = JSON.parse(window.localStorage.getItem('DynamicMinEventXJs_11')) || [];
                }
                if (this.DynamicMinEventXJs.length != 0) {
                    var data = this.DynamicMinEventXJs;
                    var option = this.canvas_count.getOption();
                    var xData = [], dataList = [], seriesData = [], xTitle = [];
                    //组装数据
                    for (var i in data) {
                        xData.push(data[i]['Ctime']);
                        var x_num = 0
                        for (var n in data[i]['TypeCount']) {
                            if (i == 0) {
                                if(this.gdEventType.indexOf(data[i]['TypeCount'][n]['EType']) > -1) {
                                    dataList[data[i]['TypeCount'][n]['EType']] = []
                                    xTitle[x_num] = data[i]['TypeCount'][n]['EType'];
                                    x_num++;
                                }
                            }
                            if(this.gdEventType.indexOf(data[i]['TypeCount'][n]['EType']) > -1) {
                                dataList[data[i]['TypeCount'][n]['EType']].push(data[i]['TypeCount'][n]['Value'])
                            }
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
                    this.canvas_count.setOption(option);
                }
                if(sData.TransitCenterNums || sData.TransitCenterNums == 0) {
                    window.localStorage.setItem('TransitCenterNums', JSON.stringify(sData.TransitCenterNums));
                    this.transitNum = this.splitBackData(sData.TransitCenterNums);
                }
                if(sData.CamraAccess || sData.CamraAccess == 0) {
                    window.localStorage.setItem('CamraAccess', JSON.stringify(sData.CamraAccess));
                    this.dotNum = this.splitBackData(sData.CamraAccess);
                }
                if(sData.XJNums || sData.XJNums == 0) {
                    window.localStorage.setItem('XJNums', JSON.stringify(sData.XJNums));
                    this.vdNum = this.splitBackData(sData.XJNums);
                }
                if(sData.ZNNums || sData.ZNNums == 0) {
                    window.localStorage.setItem('ZNNums', JSON.stringify(sData.ZNNums));
                    this.zyNum = this.splitBackData(sData.ZNNums);
                }
            },
            sData: function () {
                this.$http.post("/api/statistics/get", {
                    DataType: 2,
                    Did: this.department_id
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            var sData = JSON.parse(res.body.data);
                            if (this.department_id == 1)
                                this.top10_title = '各省事件排行TOP10';
                            if (this.department_id < 33 && this.department_id > 1)
                                this.top10_title = '各市区事件排行TOP10';
                            if (this.department_id > 32)
                                this.top10_title = '各企业事件排行TOP10';
                            // 事件top10
                            if (sData.EventTop10) {
                                window.localStorage.setItem('aEventTop10', JSON.stringify(sData.EventTop10));
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
                            }else{
                                var option = this.canvas_top10.getOption();
                                var yData = [], seData = [];
                                option.yAxis[0].data = yData;
                                option.series[0].data = seData.sort(function (a, b) {
                                    return a - b;
                                });
                                this.canvas_top10.setOption(option);
                            }
                            // 地图数据
                            if (sData.IMapsInfo) {
                                this.sdata.aIMapsInfo = sData.IMapsInfo;
                                this.$nextTick(function () {
                                    this.drawMap();
                                })
                            }else{
                                this.drawMap();
                            }
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '查询失败';
                        layer.msg(str);
                    })
            }
        },
        mounted: function () {
            var that = this;
            ChinaMap.VueObj = that;
            $(window).resize(function () {
                //that.canvas_map.resize();
                that.canvas_zuoye.resize();
                that.canvas_count.resize();
                that.canvas_top10.resize();
            })
            var that = this
            // 滚动条scroll
            $(window).scroll(function () {
                if (that.oWebControl != null) {
                    that.v_width = $(".video-hk").width()
                    var o_heigth = Math.round(that.v_width * 6 / 9)
                    var p_height = $(".video-hk").height()
                    that.v_height = (o_heigth < p_height) ? o_heigth : p_height;
                    var height = that.v_height;
                    $("#playWnd").css("height", height);
                    that.oWebControl.JS_Resize(that.v_width - 10, height);
                    that.setWndCover();
                }
            });

            // 窗口resize
            $(window).resize(function(){
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
                    //var bili = that.detectZoom()
                    //map.left = Math.round(map.left * (bili / 100))
                    //map.top = Math.round(map.top * (bili / 100))
                    that.oWebControl.JS_SetDocOffset(map)
                    that.v_width = $(".video-hk").width()
                    var o_heigth = Math.round(that.v_width * 6 / 9)
                    var p_height = $(".video-hk").height()
                    that.v_height = (o_heigth < p_height) ? o_heigth : p_height;
                    var height = that.v_height;
                    $("#playWnd").css("height", height);
                    that.oWebControl.JS_Resize(that.v_width - 10, height);
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
            $("#app_new").show();
        },
        created: function () {
            var that = this
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
                                this.sData();
                                this.drawCount("zuoye", "canvas_zuoye")
                                this.drawCount("count", "canvas_count")
                                this.drawTop()
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
            layui.use(['element','form'], function () {
                that.form = layui.form;
                that.form.on('select(selectData)', function(data){
                   if(data.value != "") {
                       var map = data.value.split(",")
                       that.gName = map[2]
                       that.dv_title = map[3]
                       //通过id和type查询下属的点位列表
                       that.device_list = true;
                       that.v_type = 0
                       that.queryDvList(map[0], map[1])
                   }
                });
                that.form.render();
                that.element = layui.element;
            })
        }
    })
</script>
</body>
</html>