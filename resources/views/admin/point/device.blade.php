<html>
<head>
    <meta charset="utf-8">
    <title>重点对象监管</title>
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

    .c-left-new {
        height: calc(100% - 121px) !important;
        height: -moz-calc(100% - 121px) !important;
        height: -webkit-calc(100% - 121px) !important;
    }

    .m-lr20 .layui-col-md10 {
        height: calc(100% - 121px) !important;
        height: -moz-calc(100% - 121px) !important;
        height: -webkit-calc(100% - 121px) !important;
    }
</style>
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid" style="display: none;">
    <div v-show="info_main">
        <div class="layui-row">
            <form class="layui-form">
               <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">对象名称</label>
                    <div class="layui-input-inline">
                        <select name="modules"  id="selectData" lay-filter="selectData" placeholder="请输入对象名称" lay-verify="" lay-search>
                            <option value="">请输入对象名称</option>
                            <option :value="id" v-for="va,id  in objectList">@{{ va }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <button type="button" class="layui-btn layui-btn-normal layui-btn-sm"
                                @click="getList(1,department_id,id)"><i class="layui-icon">&#xe615;</i>搜索
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="layui-row" style="margin:10px 0 10px 20px; ">
            <div class="layui-col-md12">
                <button class="layui-btn layui-btn-sm" @click="batchDel()" title="删除"><i class="layui-icon">&#x1006;</i>删除
                </button>
                <button class="layui-btn layui-btn-sm" @click="addPoint()" title="添加"><i class="layui-icon">&#xe61f;</i>
                    添加
                </button>
            </div>
        </div>
        <div class="layui-row m-lr20">
            <div class="layui-col-md2 c-left c-left-new">
                <div class="grid-demo grid-demo-bg1" style="text-align: center">组织机构</div>
                <ul id="demop"></ul>
            </div>
            <div class="layui-col-md10">
                <div class="layui-col-md12">
                    <table class="layui-table  text-center layui-form" lay-filter="demo" lay-size="sm">
                        <thead>
                        <tr>
                            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                            <th style="width: 48px">#</th>
                            <th>
                                <div class="text-left">点位名称</div>
                            </th>
                            <th>
                                <div class="text-left">所属重点对象</div>
                            </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(vo,id) in formData">
                            <td><input type="checkbox" name="onlyBox" lay-skin="primary" lay-filter="onlyChoose"
                                       :value="vo['id']"></td>
                            <td v-text="id+1+size">
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['name']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['pname']"></div>
                            </td>

                            <td>
                                <button class="layui-btn layui-btn-xs" title=""
                                        @click="DvDetail(vo['cameraid'],vo['name'])">详情
                                </button>
                                <button title="" class="layui-btn layui-btn-xs layui-btn-danger"
                                        @click="delData(vo['id'])">删除
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
    <div class="info-detail" v-if="detail_info">
        <div class="layui-row top">
            <div class="layui-col-md6" v-text=map[detail_id]+"详情">
            </div>
            <div class="layui-col-md6 top-right">
                <a @click="goBack(0)">返回</a>
            </div>
        </div>
        <div class="layui-row main">
            <div class="layui-col-md8">
                <div class="layui-form-item">
                    <label class="layui-form-label" v-text=map[detail_id]+"名称"></label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.name" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">经营品牌</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.brands" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">负责人</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.head" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">工作时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" autocomplete="off" readonly class="layui-input">
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

            <div class="layui-col-md12 video-hk">
                <div id="playWnd" class="playWnd" style="">
                    <p style="text-align: center;color: #fff;">加载中....</p>
                </div>
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
                form:null,
                objectList:{},
                map: {1: "企业", 2: "转运中心", 3: "网点"},
                size: 0,
                iconName: "&#xe625;",
                formData: [],
                dv_title:'',
                video_title:'资源预览',
                info_main: true,
                info: {},
                department_id: "",
                detail_info: false,
                dv_detail: true,
                detail_id: "",
                name: "",
                id:"",
                device_list: false,
                add_point: false,
                pTypeId: '2',
                dvList: [],
                pointList: [],
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
            DvDetail: function ( cid, name) {

                this.dv_title = name;

                this.device_list = true;
                this.$nextTick(function () {
                    //设置播放器高度
                    this.initPlugin()
                    this.queryDvConfig(cid)
                })
            },
            showDev: function () {
                if (this.iconName == "&#xe625;") {
                    this.iconName = "&#xe623;";
                    this.dv_detail = false;
                } else {
                    this.iconName = "&#xe625;";
                    this.dv_detail = true;
                }
            },
            getList: function (page, department_id, id) {
                var num = this.getPage()
                this.$http.post('/admin/point/device', {
                    "page": page,
                    'page_size': num,
                    "department_id": department_id,
                    "id": this.id,
                    "type": $("#p_type").val()
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
                            this.$nextTick(function () {
                                layui.use(['form'], function () {
                                    form = layui.form;
                                    //清空选择项
                                    var myCheckbox = $("input[name='onlyBox']");
                                    myCheckbox.prop('checked', false);
                                    //渲染样式
                                    form.render('checkbox');
                                });
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
            goBack: function (type) {
                if (type == 0) {
                    this.detail_info = false;
                    this.add_point = false;
                    this.device_list = false;
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
            delData: function (id) {
                var that = this;
                layer.confirm("确认要删除吗，删除后不能恢复", {title: "删除确认"}, function (index) {
                    //删除单个数据
                    that.$http.get('/admin/point/device/delete/' + id, {emulateJSON: true})
                        .then(function (res) {
                                if (res.body.code == 0) {
                                    layer.msg("删除成功");
                                    that.getList(1, that.department_id, that.id)
                                } else {
                                    var str = lea.msg(res.body.msg) || '服务器异常';
                                    layer.msg(str);
                                }
                            }, function (res) {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        )
                })
            },
            batchDel: function () {
                var noList = new Array();
                $("input:checkbox[name='onlyBox']:checked").each(function () {
                    noList.push($(this).attr('value'));
                });
                if (noList.length == 0) {
                    layer.msg("请选择删除数据!");
                    return false;
                }
                var that = this;
                layer.confirm("确认要删除吗，删除后不能恢复", {title: "删除确认"}, function () {
                    that.$http.post('/admin/point/device/batchdelete', {"ids": noList}, {emulateJSON: true})
                        .then(function (res) {
                            if (res.body.code == 0) {
                                layer.msg("成功删除" + res.body.data.count + "条数据");
                                that.getList(1, that.department_id, that.id)
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        });
                })

            },
            queryObject: function (type) {
                this.$http.post('/admin/point/object/list', {"type": type}, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.pointList = res.body.data
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                        this.$nextTick(function () {
                            layui.use(['form'], function () {
                                form = layui.form;
                                form.render('select', 'ob_choose');
                            });
                        });
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            addPoint: function () {
                this.detail_info = false;
                this.info_main = false;
                this.add_point = true;
                this.queryObject(2);
                this.$nextTick(function () {
                    layui.use(['form'], function () {
                        form = layui.form;
                        form.render('select', 'ob_choose');
                        form.render('radio');
                    });
                })
            },
            subAddPoint: function () {
                var cause = $("#cause").val();
                if (cause.length < 5 || cause.length > 200) {
                    layer.msg("事由文本长度限制为5～200");
                    return;
                }
                var reg = /[\u4e00-\u9fa5]/;
                if (!reg.test(cause)) {
                    layer.msg("事由必须包含中文字符");
                    return;
                }
                this.$http.post('/admin/point/object/add', {
                    "cause": cause,
                    "type": this.pTypeId,
                    "id": $("#ob_type").attr('value')
                }, {emulateJSON: true})
                    .then(function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str,{time:2000});
                        if (res.body.code == 0) {
                            //页面刷新
                            this.getList(1, this.department_id, this.id);
                            var that = this
                            setTimeout(function () {
                                that.add_point = false
                                that.info_main = true;
                            }, 2000)

                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
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
                } else if (0 == v) //选中窗口抓图
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
            getAllPoint: function (type) {
                this.$http.post('/admin/point/object/query',{"type":type}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.objectList = res.body.data
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
                            click: function (node) {
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
            this.getAllPoint(0);
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
            var that = this
            layui.use(['form'], function () {
                form = layui.form;
                form.on('select(p_type)', function (data) {
                    $("#p_type").attr('value', data.value)
                    that.getAllPoint(data.value);
                })
                form.on('checkbox(allChoose)', function (data) {
                    var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
                    child.each(function (index, item) {
                        item.checked = data.elem.checked;
                    })
                    form.render('checkbox')
                })
                form.on('checkbox(onlyChoose)', function (data) {
                    var sib = $(data.elem).parents('table').find('tbody input[type="checkbox"]:checked').length;
                    var total = $(data.elem).parents('table').find('tbody input[type="checkbox"]').length;
                    if (sib == total) {
                        $(data.elem).parents('table').find('thead input[type="checkbox"]').prop("checked", true);
                    } else {
                        $(data.elem).parents('table').find('thead input[type="checkbox"]').prop("checked", false);
                    }
                    form.render('checkbox')
                });
                form.on('radio(add_type)', function (data) {
                    that.pTypeId = data.value;
                    //查询选择类型的对象列表
                    that.queryObject(data.value);
                })
                form.on('select(ob_type)', function (data) {
                    $("#ob_type").attr('value', data.value)
                })
                that.form = form
                that.form.on('select(selectData)', function(data){
                    that.id = data.value
                });
                that.form.render();

            });
        }
    });
</script>
</body>
</html>