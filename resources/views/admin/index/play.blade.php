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
        background: url(/static/admin/img/spxj.png);
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
        background-image: url(/static/admin/img/spxj.png);
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
.playWnd {
        height: 100%;
        max-height: 100%;
        border: 1px solid red;
        background: black;
        margin: 5px;
    }

    .info-detail .main > div > ul > li:hover {
        color: #1e9fff;
    }

    .video-hk {
        width:1800px;heigh：900px;
    }.xiala_li > ul > li > a {
        color: #fff !important;
    }

    .xiala_li > ul > li > a:hover {
        color: #07d8e8 !important;
    }
    #app_new{
        display: none;
    }
</style>
<body layadmin-themealias="default">
<div id="app_new" class="layui-fluid">
    <div class="head_top">
        <div class="xiala_top" @click="menu_click(0)">
            <span>视频巡检</span>
        </div>
        <div class="xiala_li" v-show="menu_choose" @mouseleave="menu_click(1)">
            <ul>
                <li><a href="/">监管对象</a></li>
                <li><a href="/aevent">智能分析</a></li>
                <li><a href="/play">视频巡检</a></li>
                <li><a href="/admin/index">系统管理</a></li>
            </ul>
        </div>
    </div>
    
   
    <div class="layui-col-md10 video-hk">
                 <div id="playWnd" style="width:1000px;height:900px;" class="playWnd"></div>
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


<script>
    new Vue({
        el: '#app_new',
        data: function () {
            return {
                setTask:null,
                menu_choose: false,
                formData: {},
                form:null,
                companyList:{},
                size: 0,
                info: {},
                dv_title:'',
                info_main: true,
                detail_info: false,
                department_id: "",
                id: "",
                video_title:'资源预览',
                dv_detail: true,
                device_list: false,
                iconName: "&#xe625;",
                dvList: [],
                oWebControl: null,// 插件对象
                bIE: null,// 是否为IE浏览器
                pubKey: '',
                iLastCoverLeft: 0,
                iLastCoverTop: 0,
                iLastCoverRight: 0,
                iLastCoverBottom: 0,
                initCount: 0,
                v_width: 1800,
                v_height: 900,
                marginLeft: 220,
                marginTop: 90,
                maxLen: 14,
                count: 0,
                num: 0,
                index: 0
            }
        },
        methods: {
            menu_click: function (type) {
                if (type == 0) {
                    this.menu_choose = this.menu_choose == false ? true : false;
                } else {
                    this.menu_choose = false;
                }
            },
           getTimeStamp:function(isostr) {
                var parts = isostr.match(/\d+/g);
                return new Date(parts[0] + '-' + parts[1] + '-' + parts[2] + ' ' + parts[3] + ':' + parts[4] + ':' + parts[5]).getTime();
            },
            // 视‘
            getTime: function () {     	//获取时间
                var date = new Date();

                var year = date.getFullYear();
                var month = date.getMonth();
                var day = date.getDate();

                var hour = date.getHours();
                var minute = date.getMinutes();
                var second = date.getSeconds();
                if (month < 10) {
                    month = '0' + month;
                }
                if (day < 10) {
                    day = '0' + day;
                }
                if (hour < 10) {
                    hour = '0' + hour;
                }
                if (minute < 10) {
                    minute = '0' + minute;
                }
                if (second < 10) {
                    second = '0' + second;
                }
                var time = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second
                return time;
            }, 
           

            getList: function () {
                this.$http.post('/ievent/pdvlist', {
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.dvList = res.body.data;
                            this.count = this.dvList.length;
                            this.$nextTick(function () {
                                this.initPlugin();
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
           
           
            //反初始化
            uninit:function () {
                this.oWebControl.JS_RequestInterface({
                    funcName: "uninit"
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
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
                            that.v_width = $(".video-hk").width() - 10
                            var o_heigth = Math.round(that.v_width * 6 / 9)
                            var p_height = $(".video-hk").height()
                            that.v_height = (o_heigth < p_height) ? o_heigth : p_height;
                            var height = that.v_height;
                            $("#playWnd").css("height", height);
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
             SetInterFunc: function () {
                var that = this
                //停止所有预览再进行新的布局和渲染
                this.oWebControl.JS_RequestInterface({
                    funcName: "stopAllPreview"
                }).then(function (oData) {
                    if (oData.responseMsg.code == 0) {
                        // if (that.count >= 16) {
                        //     that.SetLayout('4x4');
                        //     for (var n = 0; n < 16; n++) {
                        //         that.queryDvConfig(that.dvList[that.index + n]['cameraid'],n+1)
                        //         console.log(that.dvList[that.index + n]['cameraid'])
                        //     }
                        //     that.index += 16
                        //     that.count -= 16
                        // } else if (that.count >= 9 && that.count < 16) {
                        //     that.SetLayout('3x3');
                        //     for (var n = 0; n < 9; n++) {
                        //         that.queryDvConfig(that.dvList[that.index + n]['cameraid'],n+1)
                        //         console.log(that.dvList[that.index + n]['cameraid'])
                        //     }
                        //     that.index += 9
                        //     that.count -= 9
                        // } else
                        if (that.count >= 4) {
                            that.SetLayout('2x2');
                            for (var n = 0; n < 4; n++) {
                                that.queryDvConfig(that.dvList[that.index + n]['cameraid'], n + 1)
                            }
                            that.index += 4
                            that.count -= 4
                        } else if (that.count == 3) {
                            this.SetLayout('2x2');
                            for (var n = 0; n < 3; n++) {
                                that.queryDvConfig(that.dvList[that.index + n]['cameraid'], n + 1)
                            }
                            that.index += 3
                            that.count -= 3
                        } else if (that.count >= 1 && that.count <= 2) {
                            that.SetLayout('1x1');
                            that.queryDvConfig(that.dvList[that.index + 0]['cameraid'], 1)
                            that.index += 1
                            that.count -= 1
                        }
                        if (that.count == 0) {
                            that.count = that.dvList.length;
                            that.num = 0;
                            that.index = 0;
                        }
                        that.num += 1;
                    }
                })
                return that.SetInterFunc;
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

            // 初始化
            init: function () {
                var that = this
                this.getPubKey(function () {
                    var snapDir = '{{Session::get('sys_hk_video')['snapDir']}}'
                    var videoDir = '{{Session::get('sys_hk_video')['videoDir']}}'
                   var layout = "3x3";    
                    var encryptedFields = '{{Session::get('sys_hk_video')['encryptedFields']}}'
                    encryptedFields = encryptedFields.split(',');
                    var btIds = '{{Session::get('sys_hk_video')['btIds']}}'
                    var showToolbar = '{{Session::get('sys_hk_video')['showToolbar']}}';
                    var showSmart = '{{Session::get('sys_hk_video')['showSmart']}}';
                    showSmart = parseInt(showSmart)
                    showToolbar = parseInt(showToolbar)
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
                        that.oWebControl.JS_Resize(that.v_width, that.v_height);
                        that.setTask = setInterval(that.SetInterFunc(), 30 * 1000);
                    });
                })
            },

            //设置当前布局
            SetLayout: function (layout) {
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
              queryDvConfig: function (id, num) {
                var cameraIndexCode = id;
                if (!cameraIndexCode) {
                    layer.msg("监控点编号不能为空！");
                    return
                }
                var dvConfig = {};
                this.$http.post('/admin/device/vdconfig', {
                    cameraid: cameraIndexCode
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            dvConfig = res.body.data;
                            this.$http.post('/admin/device/encoding', {cameraid: cameraIndexCode}, {emulateJSON: true})
                                .then(function (res) {
                                    if (res.body.code == 0) {
                                        var params = res.body.data;
                                        if(num != undefined) {
                                            dvConfig.wndId = parseInt(num, 10);
                                        }
                                        this.startPreview(dvConfig,params['CameraIndexCode'])
                                        //预览
                                        /*if(this.video_model == 0){
                                            if(num != undefined) {
                                                dvConfig.wndId = parseInt(num, 10);
                                            }
                                            this.startPreview(dvConfig,params['CameraIndexCode'])
                                        }
                                        //回看
                                        else{
                                            var map = {}
                                            map.indexCode = params['CameraIndexCode']
                                            var time = this.getTime()
                                            map.startTime = new Date(time.replace('-', '/').replace('-', '/')).getTime() - this.playback_time;
                                            map.endTime = new Date(time.replace('-', '/').replace('-', '/')).getTime();
                                            this.startPlayback(map,dvConfig)
                                        }*/
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
           

        },
        mounted: function () {
          
            this.getList();
           
            $("#load_gif").hide();
            $("#app_new").show();
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
                    var o_heigth = Math.round(that.v_width * 6 / 9)
                    var p_height = $(".video-hk").height()
                    that.v_height = (o_heigth < p_height) ? o_heigth : p_height;
                    var height = that.v_height;
                    $("#playWnd").css("height", height);
                    that.oWebControl.JS_Resize(that.v_width - 10, height);
                    that.setWndCover();
                }
            })
            $(window).unload(function () {
                // 此处请勿调反初始化
                if(this.setTask != null) {
                    clearTimeout(this.setTask);
                }
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
            layui.use(['form'], function () {
                that.form = layui.form;
                that.form.on('select(selectData)', function(data){
                    that.id = data.value
                });
                that.form.render();
            })
        }
    });
    
</script>
</body>
</html>