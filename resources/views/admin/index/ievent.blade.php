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
        background: url(/static/admin/img/spxj.png);
        background-position: center;
        background-repeat: no-repeat;


    }

    .search {

        height: 35px;
        width: 289px;
        background: url(/static/admin/img/search_bg.png) no-repeat #061537;
        color: #07d8e8;
        position: absolute;
        right: 140px;
        top: 15px;
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
        font-size: 20px;
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
        /* margin-left: 52px; */
        margin-right: 20px;
        float: right;
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

    .playWnd {
        width: 1800px;
        height: 900px;

        border: 1px solid #119fff;
        background: black;
        margin: 5px;
    }

    .info-detail .main > div > ul > li:hover {
        color: #1e9fff;
    }

    .video-hk {
        width: 1800px;
        height: 900px;
    }
    #app_new{
        display: none;
    }
</style>
<body layadmin-themealias="default">
<div id="app_new" class="layui-fluid">
    <div class="head_top">


        <!--<div class="search layui-inline">
           
            <div class="layui-input-inline layui-form">
                <select name="modules"  id="selectData" lay-filter="selectData" placeholder="请输入转运中心名称"  lay-search=""  >
                    <option value="">请选择或搜索选择转运中心</option>
                    <option :value="id" v-for="va,id  in companyList">@{{ va }}</option>
                    
                </select>
              
            </div>
            
        </div>-->

        <div class="xiala_top" @click="menu_click(0)">
            <span>视频巡检</span>
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
    <div id="playWnd" class="playWnd" style="">
        <p style="text-align: center;color: #fff;">加载中....</p>
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
                formData: {},
                menu_choose: false,
                form: null,
                companyList: {},
                size: 0,
                info: {},
                dv_title: '',
                info_main: true,
                detail_info: false,
                department_id: "",
                id: "",
                video_title: '资源预览',
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
                v_width: 900,
                v_height: 600,
                marginLeft: 220,
                marginTop: 90,
                maxLen: 14

            }
        },
        methods: {

            //反初始化
            uninit: function () {
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
                    szClassId: "23BF3B0A-2C56-4D97-9C03-0CB103AA8F11",   // 用于IE10使用ActiveX的clsid

                    cbConnectSuccess: function () {                     // 创建WebControl实例成功											
                        that.oWebControl.JS_StartService("window", {         // WebControl实例创建成功后需要启动服务
                            dllPath: "./VideoPluginConnect.dll"         // 值"./VideoPluginConnect.dll"写死
                        }).then(function () {                           // 启动插件服务成功
                            that.oWebControl.JS_SetWindowControlCallback({   // 设置消息回调
                                cbIntegrationCallBack: cbIntegrationCallBack
                            });

                            that.oWebControl.JS_CreateWnd("playWnd", 1000, 600).then(function () { //JS_CreateWnd创建视频播放窗口，宽高可设定
                                that.init();  // 创建播放实例成功后初始化
                            });
                        }, function () { // 启动插件服务失败
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

            // 初始化
            init: function () {
                var that = this
                this.getPubKey(function () {
                    var snapDir = '{{Session::get('sys_hk_video')['snapDir']}}'
                    var videoDir = '{{Session::get('sys_hk_video')['videoDir']}}'
                    var layout = '3x3'
                    var encryptedFields = '{{Session::get('sys_hk_video')['encryptedFields']}}'
                    encryptedFields = encryptedFields.split(',');
                    var btIds = '{{Session::get('sys_hk_video')['btIds']}}'
                    var showToolbar = '{{Session::get('sys_hk_video')['showToolbar']}}';
                    var showSmart = '{{Session::get('sys_hk_video')['showSmart']}}';
                    showSmart = parseInt(showSmart)
                    showToolbar = parseInt(showToolbar)
                    encryptedFields.forEach((value) => {
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
            startPreview: function (config, cameraid) {
                var appkey = config.appkey;
                var secret = this.setEncrypt(config.appsecret);
                var ip = config.artemisip;
                var szPort = config.artemisport;
                var cameraIndexCode = cameraid;
                var szPermisionType = config.privilege;
                var streamMode = +config.streamMode;
                var transMode = +config.transMode;
                var gpuMode = +config.gpuMode;
                var wndId = config.wndId;
                var encryptedFields = config.encryptedFieldsPLay;
                encryptedFields = encryptedFields.split(',');
                encryptedFields.forEach((item) => {
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
                var PermisionType = parseInt(szPermisionType);
                var enableHttps = parseInt(config.enableHTTPS);
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
                        cameraIndexCode: cameraIndexCode,
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


        },
        mounted: function () {
            /* this.$http.post('/admin/department', {}, {emulateJSON: true})
                 .then(function (res) {
                     var str = lea.msg(res.body.msg) || '服务器异常';
                     var th = this
                     var data = res.body.data
                     data[0]['spread'] = true;
                     layui.use('tree', function () {
                         layui.tree({
                             elem: '#demop' //传入元素选择器
                             , nodes: data,
                             shin: "ssss",
                             click: function (node) {
                                 //  console.log(node) //node即为当前点击的节点数据
                                 th.department_id = node.id;
                                 th.getList(1, th.department_id, th.id);
                             }
                         });
                     });
                     $(document).on("mouseover", "#demop li a", function (e) {
                         e.currentTarget.setAttribute("title", e.currentTarget.children[1].innerText)
                     })
                 }, function (res) {
                     var str = lea.msg(res.body.msg) || '服务器异常';
                     layer.msg(str);
                 });*/
            //this.getList(1, this.department_id, this.id);
            //this.getAllCompany();
            //$("#load_gif").hide();
            //$("#app").show();
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
            this.initPlugin();


            layui.use(['element', 'form'], function () {
                that.form = layui.form;
                that.form.on('select(selectData)', function (data) {
                    that.DvDetail(0, data.value)

                    console.log(data.value); //得到被选中的值

                });
                that.form.render();
                that.element = layui.element;


            })
        }
    });

</script>

</body>
</html>