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
    <link rel="stylesheet" href="/static/layuiadmin/style/common.css" media="all">
</head>
<body layadmin-themealias="default">
<style>
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
        /*min-height: 560px;*/
        max-height: 560px;
        max-width: 1000px;
        overflow-y: auto;
    }
    .dv_detail {
        height: calc(100% - 64px) !important;
        height: -moz-calc(100% - 64px) !important;
        height: -webkit-calc(100% - 64px) !important;
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
</style>
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div v-show="info_main">
        <div class="layui-row layui-form">
            <div class="layui-inline layui-form-serch">
                <label class="layui-form-label-search">企业名称</label>
                <div class="layui-input-inline">
                    <select name="modules"  id="selectData" lay-filter="selectData" placeholder="请输入企业名称" lay-verify="" lay-search>
                        <option value="">请输入企业名称</option>
                        <option :value="id" v-for="va,id  in companyList">@{{ va }}</option>
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-normal layui-btn-sm" @click="getList(1,department_id,id)">
                        <i class="layui-icon">&#xe615;</i>搜索
                    </button>
                </div>
            </div>
        </div>
        <div class="layui-row m-lr20">
            <div class="layui-col-md2 c-left">
                <div class="grid-demo grid-demo-bg1" style="text-align: center">组织机构</div>
                <ul id="demop"></ul>
            </div>
            <div class="layui-col-md10">
                <div class="layui-col-md12">
                    <table class="layui-table  text-center" lay-size="sm">
                        <thead>
                        <tr>
                            <th style="width: 48px">#</th>
                            <th>
                                <div class="text-left">转运中心名称</div>
                            </th>
                            <th>
                                <div class="text-left">所在地区</div>
                            </th>
                            <th>
                                <div class="text-left">负责人</div>
                            </th>
                            <th class="text-left">
                                联系电话
                            </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(vo,id) in formData">
                            <td v-text="id+1+size">
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['name']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['position']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['head']"></div>
                            </td>
                            <td v-text="vo['phone']"></td>
                            <td>
                                <button class="layui-btn layui-btn-xs layui-btn-normal" title=""
                                        @click="DvDetail(0,vo['id'],vo['name'])">资源
                                </button>
                                <a href="javascript:;" class="layui-btn layui-btn-xs ajax-form"
                                   @click="queryDetail(vo['id'])" title="">详情</a>
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
    <div class="info-detail" v-if="detail_info">
        <div class="layui-row top">
            <div class="layui-col-md6">
                详情
            </div>
            <div class="layui-col-md6 top-right">
                <a @click="goBack(0)">返回</a>
            </div>
        </div>
        <div class="layui-row main">
            <div class="layui-col-md8">
                <div class="layui-form-item">
                    <label class="layui-form-label">企业名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.name" lay-verify="title" autocomplete="off"
                               readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">企业注册地</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.position" lay-verify="title" autocomplete="off"
                               readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">企业许可号码</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.licenses" lay-verify="title" autocomplete="off"
                               readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">许可证有效期</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.last_time" lay-verify="title" autocomplete="off"
                               readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">企业品牌</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.brands" lay-verify="title" autocomplete="off"
                               placeholder="请输入标题" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">企业法人</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.head" lay-verify="title" autocomplete="off"
                               readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">统一社会信用代码</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.code" lay-verify="title" autocomplete="off"
                               readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">区域范围</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.position" lay-verify="title" autocomplete="off"
                               readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" @click="goBack(0)">返回
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    <button class="layui-btn layui-btn-normal layui-btn-sm"
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
            </div>
            <div class="layui-col-md10 video-hk">
                <div id="playWnd" class="playWnd" style="">
                    <p style="text-align: center;color: #fff;">加载中....</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="layui-layer-shade" id="layui-layer-shade4" times="4"
     style="display: none;z-index: 19891017; background-color: rgb(0, 0, 0); opacity: 0.3;"></div>


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
        el: '#app',
        data: function () {
            return {
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
                v_width: 900,
                v_height: 600,
                marginLeft: 220,
                marginTop: 90,
                maxLen: 14

            }
        },
        methods: {
            getPage:function(){
                var limit = window.localStorage.getItem('page_size');
                if(limit != null){
                    return limit
                }
                return 10
            },
            setPage:function(num){
                var limit = window.localStorage.getItem('page_size');
                if(limit != num) {
                    window.localStorage.setItem('page_size', num);
                }
            },
            maxShow: function (string) {
                var haystack = string.toString();
                return haystack.length > this.maxLen
                    ? haystack.slice(0, this.maxLen) + "..."
                    : haystack;
            },
            DvDetail: function (type, id,name) {
                if (type == 1) {
                    this.device_list = false;
                    this.info_main = true;
                    this.detail_info = false;
                } else {
                    this.dv_title = name
                    this.$http.post('/admin/transportation/device/' + id, {}, {emulateJSON: true})
                        .then(function (res) {
                                if (res.body.code == 0) {
                                    this.dvList = res.body.data;
                                } else {
                                    var str = lea.msg(res.body.msg) || '服务器异常';
                                    layer.msg(str);
                                }
                            }, function (res) {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        )
                    this.device_list = true;
                    this.$nextTick(function () {
                        //设置播放器高度
                        this.initPlugin()
                        //var t;
                        // clearTimeout(t)
                        // var that = this
                        // t = setTimeout(function () {
                        //     that.init()
                        // }, 1000);
                    })
                }
            },
            getList: function (page, department_id, id) {
                var num = this.getPage()
                this.$http.post('{{ url()->current() }}', {
                    "page": page,
                    'page_size': num,
                    "department_id": department_id,
                    "id": id
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.formData = res.body.data.data;
                            var that = this;
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
                                            that.setPage(obj.limit)
                                            that.getList(curr, department_id, id);
                                        }
                                    }
                                })
                            });
                            layui.use(['form'], function () {
                                form = layui.form;
                                form.render();
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
            queryDetail: function (id) {
                this.$http.get('/admin/transportation/show/' + id, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.info = res.body.data;
                                this.detail_info = true;
                                this.info_main = false;
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
            goBack: function (type) {
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
            getAllCompany: function () {
                this.$http.get('/admin/company/list', {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.companyList = res.body.data
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
                        }
                    )
            }

        },
        mounted: function () {
            this.$http.post('/admin/department', {}, {emulateJSON: true})
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
                });
            this.getList(1, this.department_id, this.id);
            this.getAllCompany();
            $("#load_gif").hide();
            $("#app").show();
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
    $("body").on("mousedown", ".dv_detail li", function () {
        $(this).css('color', '#1E9FFF').siblings().css('color', '#787878');
    });
    $("body").on("mousedown", ".dv_detail>div", function () {
        $(this).attr('class', 'out_hover').siblings().attr('class', 'out_list');
    });
</script>
</body>
</html>