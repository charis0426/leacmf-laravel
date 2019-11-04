<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin std</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
    <link id="layuicss-layer" rel="stylesheet"
          href="/static/layuiadmin/layui/css/modules/layer/default/layer.css?v=3.1.1" media="all">
    <link rel="stylesheet" href="/static/layuiadmin/style/common.css?{{ rand(000000, 999999) }}" media="all">
</head>
<body layadmin-themealias="default">
<style>
    .table-info table {
        text-align: center;
        background-color: #D9D9D9;
    }

    .block-box {
        cursor: pointer;
        border: 1px solid dodgerblue;
        color: dodgerblue;
        width: 25%;
        height: 30px;
        margin-right: 10px;
        margin-bottom: 5px;
        float: left;
    }

    .block-box-left {
        float: left;
        line-height: 30px;
        margin-left: 10px;
    }

    .block-box-right {
        float: right;
        line-height: 30px;
        margin-right: 10px;
        font-size: 16px;
    }

    .layui-form-item {
        margin-bottom: 0px !important;
    }

    .bgColor {
        background-color: lightskyblue;
        color: #FFFFFF;
    }

    .playWnd {
        height: 100%;
        max-height: 500px;
        background: black;
        margin: 5px;
    }

    .video-hk {
        min-width: 500px;
        max-width: 900px;
        max-height: 520px;
    }

    .source-list {
        background-color: #2e93ee;
        text-align: center;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 800;
        color: #EDEDED;
    }
</style>
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div v-show="info_main">
        <div class="layui-row layui-form">
            <div class="layui-inline layui-form-serch">
                <label class="layui-form-label-search" v-if="type == 1">网点名称</label>
                <label class="layui-form-label" v-else>转运中心名称</label>
                <div class="layui-input-inline">
                    <select name="modules"  v-if="type == 1" id="selectData" lay-filter="selectData" placeholder="请输入网点名称" lay-verify="" lay-search>
                        <option value="">请输入网点名称</option>
                        <option :value="id" v-for="va,id  in queryList">@{{ va }}</option>
                    </select>
                    <select name="modules"  v-else id="selectData" lay-filter="selectData" placeholder="请输入转运中心名称" lay-verify="" lay-search>
                        <option value="">请输入转运中心名称</option>
                        <option :value="id" v-for="va,id  in queryList">@{{ va }}</option>
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-normal layui-btn-sm" @click="getList(1)">
                        <i class="layui-icon">&#xe615;</i>搜索
                    </button>
                </div>
            </div>
        </div>
        <div class="layui-row m-lr20">
            <div class="layui-col-md12">
                <table class="layui-table  text-center" lay-size="sm">
                    <colgroup>
                        <col width="50">
                        <col width="320">
                        <col width="320">
                        <col width="200">
                        <col>
                        <col width="200">
                    </colgroup>
                    <thead>
                    <tr>
                        <th style="width: 48px;">
                            <div class="text-left">#</div>
                        </th>
                        <th>
                            <div class="text-left" v-if="type ==1">网点名称</div>
                            <div class="text-left" v-else>转运中心名称</div>
                        </th>
                        <th>
                            <div class="text-left">所属企业</div>
                        </th>
                        <th>
                            <div class="text-left">点位数量</div>
                        </th>
                        <th>
                            <div class="text-left">工作时间</div>
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(vo,id) in transList">
                        <td>
                            <div class="text-left" v-text="id+1+size"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['name']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['bname']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['device_count']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['work_time']?vo['work_time']:time"></div>
                        </td>
                        <td>
                            <button type="button" class="layui-btn layui-btn-xs layui-btn-disabled" disabled title="配置"
                                    v-if="vo['device_count'] == 0">配置
                            </button>
                            <button type="button" class="layui-btn layui-btn-xs"
                                    @click="showDetail(vo['id'], vo['name'])" title="配置" v-else>配置
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
    <div class="info-detail" v-show="detail_info">
        <div class="layui-row top">
            <div class="layui-col-md6" v-text="info_name?info_name:'资源配置'"></div>
            <div class="layui-col-md6 top-right">
                <a @click="goBack(0)">返回</a>
            </div>
        </div>
        <div class="layui-row main">
            <div class="layui-row" style="height: 760px;">
                <div class="layui-col-md2">
                    <div class="source-list">资源列表</div>
                    <ul style="text-align: center;background: #dcdcdc;height: 465px;overflow: auto">
                        <li v-for="(vo,index) in deviceList" @click="queryDvConfig(vo.cameraid, vo.id, index)"
                            :title="vo.name" :class="{ bgColor:index==current }"
                            style="cursor: pointer;height: 40px;line-height: 40px">
                            @{{vo.name}}
                        </li>
                    </ul>
                </div>
                <div class="layui-col-md5 video-hk">
                    <div id="playWnd" class="playWnd" style=""></div>
                </div>
                <div class="layui-col-md5">
                    <div v-if="type == 1">
                        <form class="layui-form" method="post">
                            <div class="top" style="border-bottom: 0px !important;">
                                <div class="layui-col-md6">
                                    网点配置
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" style="width: 100px;line-height: 20px;">监管优先级</label>
                                <div class="layui-input-block" style="margin-left: 120px;width: 25%;">
                                    <select name="level" lay-verify="required" class="layui-select layui-input-search">
                                        <option value=""></option>
                                        <option value="0" :selected="dot_data.level == 0">高级</option>
                                        <option value="1" :selected="dot_data.level == 1">中级</option>
                                        <option value="2" :selected="dot_data.level == 2">低级</option>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" style="width: 100px;line-height: 20px;">工作时间</label>
                                <div class="layui-input-block" style="width: 25%;margin-left: 120px">
                                    <input type="text" class="layui-input layui-input-search" id="work_time"
                                           autocomplete=“off”>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" style="width: 100px;line-height: 20px;"></label>
                                <div class="layui-input-block" style="width: 100%;margin-left: 120px" id="time_item">
                                    <div class="layui-input-inline block-box" v-if="dot_data.work_time"
                                         v-for="(vo,id) in dot_data.work_time"
                                         style="width: 25%;">
                                        <p class="block-box-left" v-text="vo"></p>
                                        <p class="block-box-right" @click='removeTime($event)'>X</p>
                                        <input type="hidden" name="work_time" class="layui-input layui-input-search"
                                               :value="vo">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block" style="margin-left: 120px">
                                    <button type="button" class="layui-btn layui-btn-sm" lay-submit
                                            lay-filter="formDemo"
                                            @click="updateDot(dot_data.id)">保存
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form class="layui-form" method="post">
                        <div class="top" style="border-bottom: 0px !important;">
                            <div class="layui-col-md6">
                                资源配置
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 100px;line-height: 20px;">作业区</label>
                            <div class="layui-input-block" style="width: 25%;margin-left: 120px">
                                <select name="region" lay-verify="required" class="layui-select" lay-filter="region">
                                    <option value=""></option>
                                    <option v-for="vo,id in region" :value="vo">@{{vo}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline" style="margin-bottom: -5px;">
                                <label class="layui-form-label" style="width: 100px;line-height: 20px;">名称</label>
                                <div class="layui-input-inline" style="width: 20%;margin-left: 20px">
                                    <input type="text" name="name" placeholder="省-市-快递企业" autocomplete="off"
                                           class="layui-input layui-input-search" lay-verify="required"
                                           :value="deviceInfo.name">
                                </div>
                                <div class="layui-form-mid" style="line-height: 30px;padding: 0px !important;">—</div>
                                <div class="layui-input-inline" style="width: 20%">
                                    <input type="text" name="work" lay-verify="required" placeholder="区域"
                                           autocomplete="off" class="layui-input layui-input-search" disabled
                                           :value="deviceInfo.region">
                                </div>
                                <div class="layui-form-mid" style="line-height: 30px;padding: 0px !important;">—</div>
                                <div class="layui-input-inline" style="width: 15%">
                                    <input type="text" name="number" placeholder="标号" autocomplete="off"
                                           class="layui-input layui-input-search" lay-verify="required|number"
                                           :value="deviceInfo.number">
                                </div>
                                <div class="layui-input-block"
                                     style="display: inline-block;margin-left: 120px;line-height: 30px;">
                                    <small>名称规则：省简称-市局简称-快递企业简称 - 摄像头位置区域 - 标号</small>
                                </div>

                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 100px;line-height: 20px;">朝向</label>
                            <div class="layui-input-block" style="width: 25%;margin-left: 120px">
                                <input type="text" name="direction" required lay-verify="required" placeholder="朝向"
                                       autocomplete="off" class="layui-input layui-input-search"
                                       :value="deviceInfo.direction">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 100px;">智能分析模型</label>
                            <div class="layui-input-block" style="margin-left: 120px">
                                <input type="checkbox" name="models" v-for="vo,id in modelList" :title="vo['models']"
                                       :value="vo['id']" class="layui-input layui-input-search">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 100px;">采样分析频度</label>
                            <div class="layui-input-block" style="width: 60%;margin-left: 120px">
                                <input type="radio" name="frequency" value="0" title="单次"
                                       :checked="deviceInfo.frequency !=1"
                                       class="layui-input layui-input-search">
                                <input type="radio" name="frequency" value="1" title="轮询"
                                       :checked="deviceInfo.frequency ==1"
                                       class="layui-input layui-input-search">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 100px;line-height: 20px;">分析时间段</label>
                            <div class="layui-input-block" style="width: 25%;margin-left: 120px">
                                <input type="text" class="layui-input layui-input-search" id="time"
                                       :value="deviceInfo.time" autocomplete="off">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 100px;line-height: 20px;"></label>
                            <div class="layui-input-block" style="width: 100%;margin-left: 120px" id="block-time">
                                <div class="layui-input-inline block-box" v-if="deviceInfo.time"
                                     v-for="(vo,id) in times"
                                     style="width: 25%;">
                                    <p class="block-box-left" v-text="vo"></p>
                                    <p class="block-box-right" @click='removeTime($event)'>X</p>
                                    <input type="hidden" name="time" class="layui-input layui-input-search" :value="vo">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block" style="margin-left: 120px">
                                <button type="button" class="layui-btn layui-btn-sm" lay-submit lay-filter="formDemo"
                                        @click="updateDevice(deviceInfo.id)">保存
                                </button>
                                <button type="button" class="layui-btn layui-btn-sm layui-btn-primary"
                                        @click="goBack()">返回
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="/static/layuiadmin/layer.js"></script> -->
<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>
<script src="/static/jsencrypt.min.js"></script>
<script src="/static/jsWebControl-1.0.0.min.js"></script>
<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                queryList:{},
                queryId:'',
                form:null,
                size: 0,
                current: -1,
                type: '',
                pid: '',
                id: '',
                transList: {},
                time: '',
                deviceList: {},
                deviceInfo: {},
                modelList: {},
                region: {},
                times: '',
                info_main: true,
                detail_info: false,
                name: "",
                info_name: '',
                dot_data: {},
                oWebControl: null,// 插件对象
                bIE: null,// 是否为IE浏览器
                pubKey: '',
                iLastCoverLeft: 0,
                iLastCoverTop: 0,
                iLastCoverRight: 0,
                iLastCoverBottom: 0,
                initCount: 0,
                v_width: 900,
                v_height: 600,
                marginLeft: 220,
                marginTop: 90,
                maxLen: 14
            }
        },
        methods: {
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
            // 设置窗口遮挡
            setWndCover: function () {
                var iWidth = $(window).width();
                var iHeight = $(window).height();
                var oDivRect = $("#playWnd").get(0).getBoundingClientRect();
                console.log(oDivRect)
                var iCoverLeft = (oDivRect.left < 0) ? Math.abs(oDivRect.left) : 0;
                var iCoverTop = (oDivRect.top < 0) ? Math.abs(oDivRect.top) : 0;
                var iCoverRight = (oDivRect.right - iWidth > 0) ? Math.round(oDivRect.right - iWidth) : 0;
                var iCoverBottom = (oDivRect.bottom - iHeight > 0) ? Math.round(oDivRect.bottom - iHeight) : 0;

                iCoverLeft = (iCoverLeft > this.v_width) ? this.v_width : iCoverLeft;
                iCoverTop = (iCoverTop > this.v_height) ? this.v_height : iCoverTop;
                iCoverRight = (iCoverRight > this.v_width) ? this.v_width : iCoverRight;
                iCoverBottom = (iCoverBottom > this.v_height) ? this.v_height : iCoverBottom;
                console.log(this.v_height)
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

            // 初始化插件
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
                            that.v_width = $(".video-hk").width() - 10
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
                                that.device_list = false;
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
                    if (oData.responseMsg.data) {
                        that.pubKey = oData.responseMsg.data
                        callback()
                    }
                })
            },

            // 设置窗口控制回调
            setCallbacks: function () {
                var that = this
                this.oWebControl.JS_SetWindowControlCallback({
                    cbIntegrationCallBack: that.cbIntegrationCallBack
                });
            },

            // 推送消息
            cbIntegrationCallBack: function (oData) {
                console.log(JSON.stringify(oData.responseMsg));
            },

            // RSA加密
            setEncrypt: function (value) {
                var encrypt = new JSEncrypt();
                encrypt.setPublicKey(this.pubKey);
                return encrypt.encrypt(value);
            },
            //反初始化
            uninit:function () {
                this.oWebControl.JS_RequestInterface({
                    funcName: "uninit"
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
            },
            // 初始化
            init: function () {
                var that = this
                this.getPubKey(function () {
                    var snapDir = '{{Session::get('sys_hk_video')['snapDir']}}'
                    var videoDir = '{{Session::get('sys_hk_video')['videoDir']}}'
                    var layout = '{{Session::get('sys_hk_video')['layout']}}'
                    var encryptedFields = '{{Session::get('sys_hk_video')['encryptedFields']}}'
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
                    encryptedFields.forEach((value)=> {
                        if (value == 'snapDir') {
                            snapDir = that.setEncrypt(snapDir)
                        }
                        if (value == 'videoDir') {
                            videoDir = that.setEncrypt(videoDir)
                        }
                        if (value == 'layout') {
                            layout = that.setEncrypt(layout)
                        }
                    })
                    encryptedFields = encryptedFields.join(",");
                    that.oWebControl.JS_RequestInterface({
                        funcName: "init",
                        argument: JSON.stringify({
                            playMode: 0, // 预览
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
                        that.oWebControl.JS_Resize(that.v_width, that.v_height);  //
                    });
                })
            },

            //设置当前布局
            SetLayout: function () {
                var layout = $("#setlayout").val();

                this.oWebControl.JS_RequestInterface({
                    funcName: "setLayout",
                    argument: JSON.stringify({
                        layout: layout
                    })
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
            },

            //获取当前布局
            GetLayout: function () {
                this.oWebControl.JS_RequestInterface({
                    funcName: "getLayout"
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
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
                    layer.msg("端口不能为空！");
                    return
                } else if (!/^([0-9]|[1-9]\d{1,3}|[1-5]\d{4}|6[0-5]{2}[0-3][0-5])$/.test(port)) {
                    layer.msg("端口填写有误！");
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
            //查询设备配置
            queryDvConfig: function (cameraid, id, index) {
                this.deviceShow(id, index)
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
                                            layer.msg("服务异常");
                                            return;
                                        }
                                    }, function () {
                                        layer.msg("服务异常");
                                        return;
                                    })
                            } else{
                            layer.msg("服务异常");
                            return;
                        }
                    }, function () {
                        layer.msg("服务异常");
                        return;
                    })

            },
            // 停止预览
            stopAllPreview: function () {
                this.oWebControl.JS_RequestInterface({
                    funcName: "stopAllPreview"
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
            },
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
            },
            getList: function (page) {
                var num = this.getPage();
                var url = '/admin/supervise/transportation';
                if (this.type == 1) {
                    url = '/admin/supervise/dot';
                }
                this.$http.post(url, {
                    'page': page,
                    'page_size': num,
                    'id': this.queryId
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.transList = res.body.data.data;
                            this.time = res.body.data.time;
                            var that = this;
                            that.size = page > 1 ? (page - 1) * num : 0;
                            $("#load_gif").hide()
                            $("#app").show();
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
                                            that.setPage(obj.limit)
                                            that.getList(curr);
                                        }
                                    }
                                })
                            });
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            showDetail: function (id, name) {
                this.detail_info = true;
                this.info_main = false;
                this.info_name = name;
                this.deviceInfo = {};
                var that = this;
                if (this.type == 1) {
                    var arr = this.transList;
                    for (i = 0; i < arr.length; i++) {
                        if (arr[i].id == id) {
                            that.dot_data.id = arr[i].id;
                            that.dot_data.level = arr[i].level;
                            that.dot_data.work_time = arr[i].work_time ? arr[i].work_time.split(',') : '';
                        }
                    }
                }
                this.$nextTick(function () {
                    layui.use('form', function () {
                        var form = layui.form;
                        form.render();
                    })
                    this.v_width = $(".video-hk").width()
                    this.v_height = Math.round(this.v_width * 6 / 9)
                    var height = (this.v_height < 500) ? this.v_height : 500;
                    $(".video-hk").css("height", height);
                    //设置播放器高度
                    this.initPlugin()
                    $("#layui-layer-shade4").show()
                    // var t;
                    // clearTimeout(t)
                    // var that = this
                    // t = setTimeout(function () {
                    //     that.init()
                    // }, 1000);
                })
                this.pid = id;
                this.devicesList(id, this.type);
            },
            devicesList: function (id, type) {// type 0转运中心 1网点
                this.$http.post('/admin/supervise/device', {id, type}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.deviceList = res.body.data;
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
            updateDot: function (id) {
                var work_time = $('input:hidden[name="work_time"]');
                var times = [];
                $.each(work_time, function (i, e) {
                    times.push(work_time[i].value);
                })
                work_time = times.join(',');
                var level = $("select[name='level']").val();
                this.$http.post('/admin/supervise/dot/update/' + id, {work_time, level}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                var str = lea.msg(res.body.msg) || '操作成功';
                                layer.msg(str);
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
            getRegion: function () {
                this.$http.get('/admin/supervise/region', {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.region = res.body.data;
                                this.$nextTick(function () {
                                    layui.use('form', function () {
                                        var form = layui.form;
                                        form.render();
                                    })
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
            deviceShow: function (id, index) {
                this.current = index;
                this.id = id;
                this.times = [];
                this.deviceInfo['time'] = '';
                $("div.block-box[data-type='append']").remove();
                this.$http.post('/admin/supervise/device/show/' + id, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.deviceInfo = res.body.data.record;
                                var arr = this.deviceInfo['name'].split('-')
                                // 名称
                                this.deviceInfo['name'] = [arr[0], arr[1], arr[2]].join('-');
                                // 作业区
                                var region = this.deviceInfo['region'] = arr[3];
                                // 标号
                                this.deviceInfo['number'] = arr[4];
                                // 分析模型
                                var models = this.deviceInfo['models'].split(',');
                                // 分析时间段
                                var timeArr = this.deviceInfo['time'].split(',');
                                var that = this;
                                this.$nextTick(function () {
                                    layui.use(['form'], function () {
                                        $ = layui.jquery;
                                        $("select[name='region'] option[value='" + region + "']").prop("selected", "selected");
                                        $("select[name='region'] option[value='" + region + "']").siblings().removeAttr("selected");
                                        $("li[title='" + that.deviceInfo['name'] + '-' + that.deviceInfo['region'] + '-' + that.deviceInfo['number'] + "']").addClass('bgColor');
                                        $("li[title='" + that.deviceInfo['name'] + '-' + that.deviceInfo['region'] + '-' + that.deviceInfo['number'] + "']").siblings().removeClass('bgColor');
                                        that.times = timeArr;
                                        that.deviceInfo['time'] = timeArr[0];
                                        $("input[name='models']").each(function () {
                                            // 取消选中
                                            $(this).removeAttr('checked');
                                            if ($.inArray($(this).val(), models) >= 0) {
                                                // 添加选中
                                                $(this).prop('checked', 'checked');
                                            } else {
                                                // 取消选中
                                                $(this).removeAttr('checked');
                                            }
                                        })
                                        var form = layui.form;
                                        form.render();
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
            modelsList: function () {
                this.$http.post('/admin/supervise/model', {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.modelList = res.body.data;
                            this.$nextTick(function () {
                                layui.use('form', function () {
                                    var form = layui.form;
                                    form.render();
                                })
                            })
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            updateDevice: function (id) {
                if (!id) {
                    layer.msg("当前没有可配置资源");
                    return false;
                }
                var that = this;
                layui.use('form', function () {
                    var form = layui.form;
                    // 数据提交事件
                    form.render();
                    form.on('submit(formDemo)', function (data) {
                        var boxs = $('input[name="models"]');
                        var models = [];
                        for (var x in boxs) {
                            if (boxs[x].checked) models.push(boxs[x].value);
                        }
                        data.field.models = models.join(',');
                        var time_boxs = $('input:hidden[name="time"]');
                        var times = [];
                        $.each(time_boxs, function (i, e) {
                            times.push(time_boxs[i].value);
                        })
                        data.field.time = times.length > 0 ? times.join(',') : '00:00 ~ 23:59';
                        var field = data.field;
                        if (!/^[\u4e00-\u9fa5]{1,1}-[\u4e00-\u9fa5]{1,4}-[\u4e00-\u9fa5]{1,4}$/.test(field.name)) {
                            layer.msg("名称规则输入有误");
                            return false;
                        }
                        if (!/^[1-9][0-9]*$/.test(field.number)) {
                            layer.msg("标号规则大于0的整数");
                            return false;
                        }
                        that.$http.post('/admin/supervise/device/update/' + id, {
                            work: field.work,
                            name: field.name,
                            number: field.number,
                            direction: field.direction,
                            frequency: field.frequency,
                            models: field.models,
                            time: field.time,
                        }, {emulateJSON: true})
                            .then(function (res) {
                                if (res.body.code == 0) {
                                    var str = lea.msg(res.body.msg) || '更新成功';
                                    layer.msg(str);
                                    this.deviceShow(this.id, this.index);
                                    this.devicesList(this.pid, this.type);
                                } else {
                                    var str = lea.msg(res.body.msg) || '服务器异常';
                                    layer.msg(str);
                                }
                            }, function (res) {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            });
                    });
                });

            },
            removeTime: function ($event) {
                $event.currentTarget.parentElement.remove();
            },
            goBack: function () {
                if (this.oWebControl != null) {
                    // this.stopAllPreview()
                    // this.uninit()
                    this.oWebControl.JS_HideWnd();
                    var that = this
                    if (!!window.ActiveXObject || "ActiveXObject" in window) {// IE
                        $("#layui-layer-shade4").hide();
                        that.detail_info = false;
                        that.info_main = true;
                        that.getList(1);
                    } else {
                        this.oWebControl.JS_Disconnect().then(function () {
                            //关闭成功后再关闭窗口不然会延迟
                            $("#layui-layer-shade4").hide();
                            that.detail_info = false;
                            that.info_main = true;
                            that.getList(1);
                        }, function () {
                        });
                    }

                } else {
                    //插件未安装或启动直接关闭弹出层
                    $("#layui-layer-shade4").hide();
                    this.detail_info = false;
                    this.info_main = true;
                    this.getList(1);
                }
            },
            queryDataList:function (type) {
                if (type === 1) {
                    this.$http.post('/admin/supervise/dot/list', {emulateJSON: true})
                        .then(function (res) {
                            if (res.body.code == 0) {
                                this.queryList = res.body.data;
                                this.$nextTick(function () {
                                    this.form.render();
                                })
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        });
                } else{
                    this.$http.post('/admin/supervise/transportation/list', {emulateJSON: true})
                        .then(function (res) {
                            if (res.body.code == 0) {
                                this.queryList = res.body.data;
                                this.$nextTick(function () {
                                    this.form.render();
                                })
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        });
                }

            }
        },
        mounted: function () {
            @if( asset('admin/supervise/transportation') == url()->current() )
                this.type = 0;
                this.queryDataList(0)
            @elseif( asset('admin/supervise/dot') == url()->current() )
                this.type = 1;
                this.queryDataList(1)
            @else
                this.type = 0;
                this.queryDataList(0)
            @endif
            // 获取转运中心列表
            this.getList(1);
            // 获取作业区
            this.getRegion();
            // 获取分析模型列表
            this.modelsList();
            var that = this
            // 滚动条scroll
            $(window).scroll(function () {
                if (that.oWebControl != null) {
                    that.v_width = $(".video-hk").width()
                    that.v_height = Math.round(that.v_width * 6 / 9)
                    var height = (that.v_height < 500) ? that.v_height : 500;
                    $(".video-hk").css("height", height);
                    that.oWebControl.JS_Resize(that.v_width - 10, height);
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
                    that.v_width = $(".video-hk").width()
                    that.v_height = Math.round(that.v_width * 6 / 9)
                    var height = (that.v_height < 500) ? that.v_height : 500;
                    $(".video-hk").css("height", height);
                    that.oWebControl.JS_Resize(that.v_width - 10, height);
                    that.setWndCover();
                }
            })
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
            var that = this
            layui.use(['form', 'layer'], function () {
                var form = layui.form;
                that.layer = layui.layer;
                that.layer.config({
                    offset: 't'
                })
                // 作业区选中事件
                form.on('select(region)', function (data) {
                    $("input[name='work']").val(data.value);
                });
                that.form = form
                that.form.on('select(selectData)', function(data){
                    that.queryId = data.value
                });
                that.form.render();
            });
            //分析时间段
            layui.use('laydate', function () {
                var laydate = layui.laydate;

                //执行一个laydate实例
                laydate.render({
                    elem: '#time'
                    , type: 'time'
                    , range: '~'
                    , format: 'HH:mm'
                    , trigger: 'click'
                    , done: function (value, e, h) {
                        if (e.hours >= h.hours) {
                            layer.msg("开始时间不能大于或等于结束时间");
                            return false;
                        }
                        var MyComponent = Vue.extend({
                            template: `<div class="block-box" data-type="append" style="width: 25%;">
                                    <p class="block-box-left">` + value + `</p>
                                    <p class="block-box-right" @click="removeTime($event)" >X</p>
                                    <input type="hidden" name="time" class="layui-input" value="` + value + `">
                                </div>`,
                            methods: {
                                removeTime: function ($event) {
                                    $event.currentTarget.parentElement.remove();
                                },
                            }
                        });
                        if (value) {
                            var component = new MyComponent().$mount();
                            $("#block-time").append(component.$el);
                        }
                    }
                });
            });
            //网点工作时间
            layui.use('laydate', function () {
                var laydate = layui.laydate;

                //执行一个laydate实例
                laydate.render({
                    elem: '#work_time'
                    , type: 'time'
                    , range: '~'
                    , format: 'HH:mm'
                    , trigger: 'click'
                    , done: function (value, e, h) {
                        if (e.hours > h.hours - 1) {
                            layer.msg("开始时间不能大于结束时间且不能低于1小时");
                            return false;
                        }
                        var MyComponent = Vue.extend({
                            template: '<div class="block-box" data-type="append" style="width: 25%;">\n' +
                                '           <p class="block-box-left">' + value + '</p>\n' +
                                '           <p class="block-box-right" @click="removeTime($event)" >X</p>\n' +
                                '           <input type="hidden" name="work_time" class="layui-input" value="' + value + '">\n' +
                                '      </div>',
                            methods: {
                                removeTime: function ($event) {
                                    $event.currentTarget.parentElement.remove();
                                },
                            }
                        });
                        if (value) {
                            var component = new MyComponent().$mount();
                            $("#time_item").append(component.$el);
                        }
                    }
                });
            });
        }
    });
</script>

</body>
</html>