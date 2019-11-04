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
    .source-list {
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 800;
        text-align: center;
        background-color: #2e93ee;
        color: #EDEDED;
    }

    .video-style {
        height: calc(60%);
        height: -moz-calc(60%);
        height: -webkit-calc(60%);
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
            <div class="layui-row">
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">业务类型</label>
                    <div class="layui-input-inline">
                        <select class="search" v-model="type" lay-filter="p_type" lay-verify="required" id="type">
                            <option value="0">作业违规监管</option>
                            <option value="1">视频巡检监管</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">事件类型</label>
                    <div class="layui-input-inline">
                        <select class="search" v-model="event_type" lay-filter="o_type" lay-verify="required"
                                id="event_type">
                            <option value="">全部</option>
                            <option v-for="vo,id in region" :value="id">@{{vo}}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-input-inline">
                    <button type="button" class="layui-btn layui-btn-normal layui-btn-sm"
                            @click="getList(1)">
                        <i class="layui-icon">&#xe615;</i>搜索
                    </button>
                </div>
            </div>
        </form>
        <div class="layui-row m-lr20">
            <div class="layui-col-md2 c-left" v-if="department_pid==1||!department_pid">
                <div class="grid-demo grid-demo-bg1" style="text-align: center">组织机构</div>
                <ul id="demop"></ul>
            </div>
            <div :class="department_pid==1||!department_pid?'layui-col-md10':''">
                <div class="layui-col-md12">
                    <table class="layui-table text-center" lay-size="sm">
                        <thead>
                        <tr>
                            <th style="width: 48px">编号</th>
                            <th>
                                <div class="text-left">监管对象名称</div>
                            </th>
                            <th>
                                <div class="text-left">对象类型</div>
                            </th>
                            <th>
                                <div class="text-left">上报人员</div>
                            </th>
                            <th>
                                <div class="text-left">上报时间</div>
                            </th>
                            <th>
                                <div class="text-left">状态</div>
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
                            <td>
                                <div class="text-left" v-text="vo['nickname']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['report_time']"></div>
                            </td>
                            <td v-if="vo['is_verify'] == 1" style="color: #00FF00">已审核</td>
                            <td v-else style="color: #CF1900;">待审核</td>
                            <td>
                                <button type="button" @click="queryDetail(vo['id'])"
                                        class="layui-btn layui-btn-xs" v-if="vo['is_verify'] == 1">详情
                                </button>
                                <button type="button" @click="queryDetail(vo['id'])"
                                        class="layui-btn layui-btn-warm layui-btn-xs" v-else>审核
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
    <div class="info-detail1" v-if="detail_info">
        <div class="layui-row top">
            <div class="layui-col-md6">
                事件审核
            </div>
            <div class="layui-col-md6 top-right">
                <a @click="goBack(0)">返回</a>
            </div>
        </div>
        <div class="layui-row main">
            <div class="layui-col-md2">
                <div class="source-list">事件列表</div>
                <div class="video-style" id="dvList" @scroll="onScroll">
                    <div class="layui-form-item" v-for="item,id in dvList"
                         @click="queryDvConfig(item)" style="margin: 10px">
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
                <div style="width:100%;height:30%;">
                    <img id="PicShow" src="/static/img/timg.jpg" style="width:100%;height:100%"/>
                </div>
                <div class="layui-form-item" style="margin-bottom: 0px">
                    <label class="layui-form-label">监管对象</label>
                    <div class="layui-input-block" style="line-height: 30px;min-height: 30px;"
                         v-text="info.object"></div>
                </div>
                <div class="layui-form-item" style="margin-bottom: 0px">
                    <label class="layui-form-label">设备编号</label>
                    <div class="layui-input-block" style="line-height: 30px;min-height: 30px;"
                         v-text="info.cameraid"></div>
                </div>
                <div class="layui-form-item" style="margin-bottom: 0px">
                    <label class="layui-form-label">设备名称</label>
                    <div class="layui-input-block" style="line-height: 30px;min-height: 30px;"
                         v-text="info.cameraname"></div>
                </div>
                <div class="layui-form-item" style="margin-bottom: 0px">
                    <label class="layui-form-label">事件类型</label>
                    <div class="layui-input-block" style="line-height: 30px;min-height: 30px;"
                         v-for="item,index in region"
                         v-if="index == info.event_type" v-text="item" v-bind="typeName"></div>
                </div>
                <div class="layui-form-item" style="margin-bottom: 0px">
                    <label class="layui-form-label">发生时间</label>
                    <div class="layui-input-block" style="line-height: 30px;min-height: 30px;"
                         v-text="info.created_time"></div>
                </div>
                <div class="layui-form-item" style="margin-bottom: 0px">
                    <label class="layui-form-label">上报时间</label>
                    <div class="layui-input-block" style="line-height: 30px;min-height: 30px;"
                         v-text="info.report_time"></div>
                </div>
                <div class="layui-form-item" style="margin-bottom: 0px">
                    <label class="layui-form-label">上报人员</label>
                    <div class="layui-input-block" style="line-height: 30px;min-height: 30px;"
                         v-text="info.nickname"></div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">预警说明</label>
                    <div class="layui-input-block">
                    <textarea name="city_bm_explain" class="layui-textarea" v-model="info.city_bm_explain"
                              v-text="info.city_bm_explain" readonly></textarea>
                    </div>
                </div>
                <div class="layui-form-item" style="margin-bottom: 0px" v-if="typeof info.city_bm_desc !== 'undefined'">
                    <label class="layui-form-label">备注</label>
                    <div class="layui-input-block">
                    <textarea name="description" class="layui-textarea" v-model="info.city_bm_desc"
                              v-text="info.city_bm_desc"></textarea>
                    </div>
                </div>
                <div class="layui-form-item" style="margin-bottom: 0px" v-if="info.is_verify != 1">
                    <label class="layui-form-label" v-if="info.sid">是否审核</label>
                    <label class="layui-form-label" v-else>是否上报</label>
                    <div class="layui-input-block" style="line-height: 30px;min-height: 30px;">
                        <label>
                            <input type="radio" name="city_bm_report" value="1" title="是" v-model="info.city_bm_report">是&nbsp;&nbsp;&nbsp;
                        </label>
                        <label>
                            <input type="radio" name="city_bm_report" value="0" title="否" v-model="info.city_bm_report">否
                        </label>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
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
        el: '#app',
        data: function () {
            return {
                size: 0,
                formData: {},
                region: {},
                type: 1,
                event_type: "",
                department_id: "",
                department_pid: "",
                city_bm_report: 0,
                detail_info: false,
                info_main: true,
                info: {},
                dvList: [],
                typeName: '',
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
                playBackTime: '{{$time}}'
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
            getDepartment: function () {
                this.$http.post('/admin/department', {}, {emulateJSON: true})
                    .then(function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
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
                                        th.getList(1);
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
            getList: function (page) {
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
                }
                this.event_type ? data.object_type = this.event_type : '';

                this.$http.post('{{ url()->current() }}', data, {emulateJSON: true})
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
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            getRegion: function () {
                this.$http.post("/admin/alarm/region", {type: this.type}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.region = res.body.data;
                                var that = this;
                                this.$nextTick(function () {
                                    layui.use('form', function () {
                                        var form = layui.form;
                                        form.on('select(p_type)', function (data) {
                                            $("#p_type").attr('value', data.value)
                                            that.type = data.value;
                                            that.event_type = "";
                                            that.getRegion();
                                            that.getList(1);
                                        })
                                        form.on('select(o_type)', function (data) {
                                            $("#p_type").attr('value', data.value)
                                            that.event_type = data.value;
                                        })
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
            queryDetail: function (id, bool) {
                this.$http.post('/admin/alarm/show/', {id: id, type: this.type}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.info = res.body.data;
                                this.event_type = this.info.event_type;
                                this.department_id = this.info.department_id;
                                this.city_bm_report = res.body.data.is_verify;
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
                    "department_id": this.department_id,
                    "object_type": this.event_type,
                    "type": this.type
                };
                this.$http.post('/admin/alarm', data, {emulateJSON: true})
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
                var data = {
                    "id": id,
                    "type": this.type,
                    'object': this.info.object ? this.info.object : '',
                    "report": this.info.city_bm_report,
                    "explain": this.info.city_bm_explain,
                    "description": this.info.city_bm_desc ? this.info.city_bm_desc : ''
                };
                this.$http.post("/admin/alarm/report", data, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                var str = lea.msg(res.body.msg) || '上报成功';
                                layer.msg(str);
                                var that = this;
                                this.city_bm_report = 1;
                                this.dvList = [];
                                this.getNavList(1, 4);
                                // setTimeout(function () {
                                //     that.goBack();
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
            goBack: function () {
                this.dvList = [];
                var that = this;
                this.getList(1);
                if (this.oWebControl != null) {
                    // this.stopAllPlayback();
                    // this.uninit();
                    this.oWebControl.JS_HideWnd();
                    if (!!window.ActiveXObject || "ActiveXObject" in window) {// IE
                        $("#layui-layer-shade4").hide();
                        that.detail_info = false;
                        that.info_main = true;
                    } else {
                        this.oWebControl.JS_Disconnect().then(function () {
                            //关闭成功后再关闭窗口不然会延迟
                            $("#layui-layer-shade4").hide();
                            that.detail_info = false;
                            that.info_main = true;
                        }, function () {
                        });
                    }
                } else {
                    //插件未安装或启动直接关闭弹出层
                    $("#layui-layer-shade4").hide();
                    that.detail_info = false;
                    that.info_main = true;
                }
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
                                        layer.msg("没有权限");
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
            this.getRegion();
            this.getDepartment();
            this.getList(1);
            $("#load_gif").hide();
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
                    console.log(bili)
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
            var that = this;
            layui.use('form', function () {
                var form = layui.form;
                form.render();
                form.on('select(p_type)', function (data) {
                    $("#p_type").attr('value', data.value)
                    that.type = data.value;
                    that.event_type = "";
                    that.getRegion();
                    that.getList(1);
                })
                form.on('select(o_type)', function (data) {
                    $("#p_type").attr('value', data.value)
                    that.event_type = data.value;
                })
            })
        }
    });
</script>
</body>
</html>