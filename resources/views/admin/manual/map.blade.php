<html><head>
    <meta charset="utf-8">
    <title>layuiAdmin std</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
    <link id="layuicss-layer" rel="stylesheet" href="/static/layuiadmin/layui/css/modules/layer/default/layer.css?v=3.1.1" media="all">
    <link rel="stylesheet" href="/static/layuiadmin/style/common.css" media="all">
</head>
<body layadmin-themealias="default">
<style>
    .layui-input-block{
        margin-left: 130px !important;
    }
    .lay-ext-mulitsel .layui-input.multiple{
        height: 33px !important;
        min-height: 33px;
        max-height: 33px;
        margin-top: -30px;
    }
    .lay-ext-mulitsel .layui-input.multiple a{
        line-height: 16px !important;
        height: 16px !important;
    }.lay-ext-mulitsel .tips {
             top: 5px !important;
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
        height: 100%;
    }

    .dialog_detail {
        overflow: hidden;
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        z-index: 19891019;
        top: 0px;
        width: 80%;
        height: 100%;
        background: #fff;
        max-height: 560px;
        max-width: 1000px;
    }

    .dv_detail {
        height: calc(100% - 102px) !important;
        height: -moz-calc(100% - 102px) !important;
        height: -webkit-calc(100% - 102px) !important;
        padding-left: 20px;
        font-size: 12px;
        overflow-y: auto;
    }

    .dv_detail > li {
        padding-left: 5px;
    }

    .main-new {
        height: calc(100% - 91px) !important;
        height: -moz-calc(100% - 91px) !important;
        height: -webkit-calc(100% - 91px) !important;
    }

    .model-right {
        width: 100%;
        height: 30px;
    }

    .model-right > button {
        float: right;
    }

    .out-div {
        color: #FFFFFF;
        font-size: 14px;
        line-height: 30px;
        display: inline-block;
        height: 30px;
        width: 90%;
        text-align: center;
        border-radius: 5px;
        margin-left: 10px;
        vertical-align: top;
        background-color: #d5d5d5;
        float: left;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .out-div > span {
        padding-left: 5px;
        padding-right: 5px;
    }

    .arrow {
        width: 0px;
        height: 0px;
        border-top: 10px solid transparent;
        border-right: 10px solid;
        border-bottom: 10px solid transparent;
        position: absolute;
        margin-left: -8px;
        margin-top: 5px;
        border-right-color: #d5d5d5;
    }

    .out_hover, .out_list {
        height: 30px;
        padding: 5px;
        border-left: 2px solid #d5d5d5;
        position: relative;
    }

    .circle {
        width: 10px;
        height: 10px;
        border-radius: 5px;
        background: #d5d5d5;
        position: absolute;
        margin-left: -21px;
        margin-top: 9px;
    }

    .out_hover .out-div {
        background: #3c97fb;
    }

    .out_hover .out-div .circle {
        background: #3c97fb;
    }

    .out_hover .out-div .arrow {
        border-right-color: #3c97fb;
    }

    .dv_detail > div:hover > .out-div {
        background: #3c97fb;
    }

    .dv_detail > div:hover > .out-div > .circle {
        background: #3c97fb;
    }

    .dv_detail > div:hover > .out-div > .arrow {
        border-right-color: #3c97fb;
    }
    #map{
        height: calc(100% - 78px);
        height: -moz-calc(100% - 78px);
        height: -webkit-calc(100% - 78px);
        width:100%;
    }
</style>
<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/layer.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>
<script src="http://api.map.baidu.com/api?v=2.0&ak=5pS3S1fY7A7zySU2M8viHy5mbvVKSbug"></script>
<script src="/static/jsencrypt.min.js"></script>
<script src="/static/jsWebControl-1.0.0.min.js"></script>
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <fieldset v-show="map_list" >
            <div class="layui-row" style="">
                <form class="layui-form">
                    <div class="layui-inline layui-form-serch">
                        <label class="layui-form-label-search">对象名称</label>
                        <div class="layui-input-inline" id="tag_ids2">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <button  type="button" class="layui-btn layui-btn-normal layui-btn-sm"
                                     @click="getList()" >
                                <i class="layui-icon">&#xe615;</i>搜索</button>
                        </div>
                    </div>
                </form>
            </div>
    </fieldset>
    <fieldset v-show="map_list">
        <div id="map">
        </div>
    </fieldset>
    <div class="info-detail" v-if="device_list">
        <div class="layui-row top">
            <div class="layui-col-md6" v-text="dv_title">
            </div>
            <div class="layui-col-md6 top-right">
                <a @click="goBack(1)">返回>
                </a>
            </div>
        </div>
        <div class="layui-row main main-new">
            <div class="layui-col-md2" style="height: 100%;top:5px;background: #eeeeee;">
                <div class="model-right">
                    <button class="layui-btn layui-btn-normal layui-btn-sm" @click="changeVideoMdel()"
                            v-text="video_title"></button>
                </div>
                <div class="dv_top" style="padding-left: 20px;height: 34px;font-size: 14px;font-weight: 400;">资源列表
                </div>
                <div class="dv_detail" v-show="dv_detail">
                    <div class="out_list" v-for="vo in dvList" @click="queryDvConfig(vo.cameraid)" :title="vo.name">
                        <div class="out-div">
                            <div class="circle"></div>
                            <div class="arrow"></div>
                            <span>@{{ maxShow(vo.name) }}</span>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12" style="position: absolute;bottom: 0;width: 100%;left: 0px;">
                    <button type="button"
                            :class="btn_lunbo"
                            style="padding: 0 -1px;width: 100%;border-radius: 0px" @click="stopInterFunc()">
                        @{{stopBtnVal}}
                    </button>
                </div>
            </div>
            <div class="layui-col-md10 video-hk">
                <div id="playWnd" class="playWnd" style="">
                    <p style="text-align: center;color: #fff;">加载中....</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="layui-layer-shade" id="layui-layer-shade4" times="4" style="display: none;z-index: 19891017; background-color: rgb(0, 0, 0); opacity: 0.3;"></div>
<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                tagIns2: null,
                map:null,//Map实例
                markerArr:[],
                mark_title:'',
                iconName:{
                    "1":"comp.png",
                    "2":"trans.png",
                    "3":"pot.png"},
                currentLat:116.379835,
                currentLon:39.912721,
                device_list:false,
                dvList:[],
                map_list:true,
                dv_detail:false,
                icons:"&#xe625;",
                oWebControl: null,// 插件对象
                bIE: null,// 是否为IE浏览器
                pubKey: '',
                iLastCoverLeft: 0,
                iLastCoverTop: 0,
                iLastCoverRight: 0,
                iLastCoverBottom: 0,
                initCount: 0,
                v_width:900,
                v_height:600,
                maxLen:14,
                marginLeft:220,
                marginTop:90,
                setTask:null,
                count:0,
                num:0,
                index:0,
                video_title: '回看模式',
                video_model: 0,
                pollTime: '{{ isset($time) ? $time : '' }}',
                stopBtnVal: '开始轮播',
                isStop: true,
                btn_lunbo:"layui-btn layui-btn-disabled",
                playback_time: '{{isset($playback_time) ? $playback_time : '10'}}'
            }
        },
        methods: {
            changeVideoMdel: function () {
                if (this.video_model == 0) {
                    //切换成回看模式
                    this.stopAllPreview()
                    this.video_model = 1
                    this.video_title = "预览模式"
                    this.uninit()
                    this.$nextTick(function () {
                        var t;
                        var that = this;
                        clearTimeout(t)
                        t = setTimeout(function () {
                            that.init()
                        }, 1000);
                    })

                } else {
                    //切换成预览模式
                    this.stopAllPlayback()
                    this.video_model = 0
                    this.video_title = "回看模式"
                    this.uninit()
                    this.$nextTick(function () {
                        var t;
                        var that = this;
                        clearTimeout(t)
                        t = setTimeout(function () {
                            that.init()
                        }, 1000);
                    })
                }
            },
            stopInterFunc: function () {
                if(this.btn_lunbo == 'layui-btn layui-btn-disabled'){
                    return;
                }
                if (this.isStop == false) {
                    clearTimeout(this.setTask);
                    this.stopBtnVal = '开始轮播'
                    this.isStop = true
                } else {
                    this.setTask = setInterval(this.SetInterFunc(), this.pollTime * 1000);
                    this.stopBtnVal = '暂停轮播'
                    this.isStop = false
                }
            },
            maxShow:function(string) {
                var haystack = string.toString();
                return haystack.length > this.maxLen
                    ? haystack.slice(0, this.maxLen) + "..."
                    : haystack;
            },
            goBack: function () {
                if (this.oWebControl != null) {
                    // this.stopAllPreview()
                    // this.uninit()
                    this.oWebControl.JS_HideWnd();
                    var that = this;
                    if (!!window.ActiveXObject || "ActiveXObject" in window) {// IE
                        that.device_list = false;
                        that.map_list = true;
                    } else {
                        this.oWebControl.JS_Disconnect().then(function () {
                            //关闭成功后再关闭窗口不然会延迟
                            that.device_list = false;
                            that.map_list = true;
                        }, function () {
                        });
                    }
                } else {
                    //插件未安装或启动直接关闭弹出层
                    this.device_list = false;
                    this.map_list = true;
                }

                this.stopBtnVal = '开始轮播'
                this.isStop = true
                clearTimeout(this.setTask);

            },
            getList:function(){
                this.markerArr = []
                var that = this
                $.post('{{ url()->current() }}',{type:this.tagIns2.values},function(res){
                    if (res.code == 0) {
                        for(var i in res.data){
                            that.markerArr[i] = { id:res.data[i].id,type:res.data[i].type,title: res.data[i].name, point: res.data[i].lnt+","+res.data[i].lat,img:"/static/img/"+that.iconName[res.data[i].type]}
                        }
                        that.map_init();
                        $("#load_gif").hide();
                        $("#app").show();
                    }else{
                        var str = lea.msg(res.msg) || '服务器异常';
                        layer.msg(str);
                    }
                },"json");
            },
            addMarker:function (point, index, img) {
                var myIcon = new BMap.Icon(img,
                new BMap.Size(23, 25), {
                // offset: new BMap.Size(10, 25),
                // imageOffset: new BMap.Size(0, 0 -  index * 25)
                });
                var marker = new BMap.Marker(point, { icon: myIcon });
                map.addOverlay(marker);
                return marker;
            },
            openInfoWinFun:function(info,poi) {
                layer.open({
                    title:poi.title+':视频预览',
                    area:['80%','80%'],
                    content: 'sadsa' //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
                });
             },
            map_init:function() {
                map = new BMap.Map("map");
                //第1步：设置地图中心点，当前城市
                var point = new BMap.Point(this.currentLat,this.currentLon);
                //第2步：初始化地图,设置中心点坐标和地图级别。
                map.centerAndZoom(point, 11);
                var geolocation = new BMap.Geolocation();
                geolocation.getCurrentPosition(function(r) {
                    map.centerAndZoom(r.point, 11);
                })
                //第3步：启用滚轮放大缩小
                map.enableScrollWheelZoom(true);
                //第4步：向地图中添加缩放控件
                var ctrlNav = new window.BMap.NavigationControl({
                    anchor: BMAP_ANCHOR_TOP_LEFT,
                    type: BMAP_NAVIGATION_CONTROL_LARGE
                });
                map.addControl(ctrlNav);
                //第5步：向地图中添加缩略图控件
                var ctrlOve = new window.BMap.OverviewMapControl({
                    anchor: BMAP_ANCHOR_BOTTOM_RIGHT,
                    isOpen: 1
                });
                map.addControl(ctrlOve);

                //第6步：向地图中添加比例尺控件
                var ctrlSca = new window.BMap.ScaleControl({
                    anchor: BMAP_ANCHOR_BOTTOM_LEFT
                });
                map.addControl(ctrlSca);


                //第7步：绘制点
                for (var i = 0; i < this.markerArr.length; i++) {
                    var p0 = this.markerArr[i].point.split(",")[0];
                    var p1 = this.markerArr[i].point.split(",")[1];
                    var maker = this.addMarker(new window.BMap.Point(p0, p1), i, this.markerArr[i].img);
                    this.addInfoWindow(maker, this.markerArr[i]);
                }

             },
            // 添加信息窗口
            addInfoWindow:function(marker, poi) {
                this.dv_title = poi.title
                var that = this
                marker.addEventListener("click", function (e) {
                    that.mark_title = poi.title
                    if(poi.type == 1) {
                        return false;
                    }
                    var url = "";
                    if (poi.type == 2) {
                        url = '/admin/transportation/device/' + poi.id;
                    } else if (poi.type == 3) {
                        url = '/admin/dot/device/' + poi.id
                    }
                    $.post(url,{},function(res){
                        if (res.code == 0) {
                            that.dvList = res.data
                            that.v_width = $(".video-hk").width();
                            that.v_height = Math.round(that.v_width*6/9)
                            var height = (that.v_height<500) ? that.v_height : 500;
                            $(".video-hk").css("height", height);
                            //设置播放器高度
                            that.initPlugin(that)
                            // var t;
                            // clearTimeout(t)
                            // t = setTimeout(function () {
                            //     that.init(that)
                            // }, 1000);
                            that.map_list = false
                            that.device_list = true
                            that.dv_detail = true
                            //that.openInfoWinFun(info, poi);
                        } else {
                            var str = lea.msg(res.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    },"json");
                });
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

            // 初始化插件
            initPlugin: function () {
                var that = this
                that.oWebControl = new WebControl({
                    szPluginContainer: "playWnd",
                    iServicePortStart: 15900,
                    iServicePortEnd: 15909,
                    szClassId:"23BF3B0A-2C56-4D97-9C03-0CB103AA8F11",
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
                            that.v_height = $(".video-hk").height() -10
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
                                clearTimeout(that.setTask);
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
            init: function (that) {
                var that =  this
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
                            playMode: parseInt(that.video_model), // 预览和回看切换
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
                        //初始化完成，开始自动轮训播放，计算当前设备数量，设置播放面板布局
                        if (that.video_model == 0) {
                            that.count = that.dvList.length;
                            clearTimeout(that.setTask);
                            if (that.count > 4) {
                                that.btn_lunbo = "layui-btn layui-btn-normal"
                            }
                        }
                    });
                })
            },
            SetInterFunc : function(){
                console.log("count:"+this.count);
                var that = this
                //停止所有预览再进行新的布局和渲染
                this.oWebControl.JS_RequestInterface({
                    funcName: "stopAllPreview"
                }).then(function (oData) {
                    if(oData.responseMsg.code == 0){
                        // if (that.count >= 16) {
                        //     that.SetLayout('4x4');
                        //     for (var n = 0; n < 16; n++) {
                        //         that.queryDvConfig(that.dvList[that.index + n]['cameraid'])
                        //         console.log(that.dvList[that.index + n]['cameraid'])
                        //     }
                        //     that.index += 16
                        //     that.count -= 16
                        // } else if (that.count >= 9 && that.count < 16) {
                        //     that.SetLayout('3x3');
                        //     for (var n = 0; n < 9; n++) {
                        //         that.queryDvConfig(that.dvList[that.index + n]['cameraid'])
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

            //抓图
            SnapPic: function () {
                var snapName = $("#snapName").val();
                var wndId = 0; //选中窗口抓图

                snapName = snapName.replace(/(^\s*)/g, "");
                snapName = snapName.replace(/(\s*$)/g, "");

                var sel = document.getElementById("SnapType");
                var selectedId = sel.selectedIndex;
                var v = sel.options[selectedId].value;
                if (1 == v)//指定窗口抓图
                {
                    wndId = parseInt($("#SnapWndId option:selected").val(), 10);
                }
                else if (0 == v) //选中窗口抓图
                {
                    wndId = 0;
                }

                this.oWebControl.JS_RequestInterface({
                    funcName: "snapShot",
                    argument: JSON.stringify({
                        name: snapName,
                        wndId: wndId
                    })
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
            },
            startPlayback:function(params,dvConfig){
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
                encryptedFields.forEach((item)=> {
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
                var PermisionType=parseInt(szPermisionType);
                var enableHttps = parseInt(dvConfig.enableHTTPS);
                if (wndId>=1)//指定窗口回放
                {
                    wndId = parseInt(wndId, 10);
                }
                else if (0 == wndId) //空闲窗口回放
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
                    Number.isNaN = function(n) {
                        return (
                            typeof n === "number" &&
                            window.isNaN( n )
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
            getTimeStamp:function(isostr) {
                var parts = isostr.match(/\d+/g);
                return new Date(parts[0] + '-' + parts[1] + '-' + parts[2] + ' ' + parts[3] + ':' + parts[4] + ':' + parts[5]).getTime();
            },
            // 视频预览和回看逻辑切换
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
                                        //预览
                                        if(this.video_model == 0){
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
                                        }
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
            // 停止预览
            stopAllPreview: function () {
                this.oWebControl.JS_RequestInterface({
                    funcName: "stopAllPreview"
                }).then(function (oData) {
                    console.log(JSON.stringify(oData ? oData.responseMsg : ''));
                });
            },
            stopAllPlayback: function () {
                this.oWebControl.JS_RequestInterface({
                    funcName: "stopAllPlayback"
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
            }
        },
        mounted: function () {
            var that = this
            layui.config({
                base : '/static/layuiadmin/'
            }).extend({
                selectN: 'layui_extends/selectN',
                selectM: 'layui_extends/selectM',
            }).use(['layer','form','jquery','selectN','selectM'],function() {
                $ = layui.jquery;
                var form = layui.form
                    , selectM = layui.selectM;
                //多选标签-所有配置
                that.tagIns2 = selectM({
                    //元素容器【必填】
                    elem: '#tag_ids2'
                    ,
                    tips: "请选择对象类型"
                    //候选数据【必填】
                    , data: [{"id": 1, "name": "企业"}, {"id": 2, "name": "转运中心"}, {"id": 3, "name": "网点"}]
                    //默认值
                    , selected: [1, 2, 3]
                    //input的name 不设置与选择器相同(去#.)
                    , name: 'tag2'
                    //值的分隔符
                    , delimiter: ','
                    //候选项数据的键名
                    , field: {idName: 'id', titleName: 'name'}

                });
                that.$nextTick(function () {
                    that.getList();
                })
                form.render();
            })
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
            $(window).resize(function(){
                        if (that.oWebControl != null) {
                            var map = {}
                            //如果点击缩放菜单引起的窗口变化
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
        }
    })
    $("body").on("mousedown", ".dv_detail li", function () {
        $(this).css('color', '#1e9fff').siblings().css('color', '#787878');
    });
</script>
</body>
</html>