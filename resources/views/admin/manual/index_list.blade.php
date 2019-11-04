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
</style>
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div v-show="info_main">
        <div class="layui-row layui-form">
            <div class="layui-inline layui-form-serch">
                @if(asset('admin/manual/company') == url()->current())
                    <label class="layui-form-label-search">企业名称</label>
                @elseif(asset('admin/manual/transportation') == url()->current())
                    <label class="layui-form-label">转运中心名称</label>
                @elseif(asset('admin/manual/dot') == url()->current())
                    <label class="layui-form-label-search">网点名称</label>
                @endif
                <div class="layui-input-inline">
                    <input type="text" v-model="name" placeholder="输入名称" autocomplete="off"
                           class="layui-input layui-input-search" maxlength="80">
                </div>
            </div>
            @if(asset('admin/manual/company') != url()->current())
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">所属企业</label>
                    <div class="layui-input-inline">
                        <select name="company" v-model="pid" lay-filter="company" lay-search>
                            <option value="">请选择企业</option>
                            <option :value="vo['id']" v-for="vo in company" v-text="vo['name']"
                                    :seleced="pid==vo['id']?true:false"></option>
                        </select>
                    </div>
                </div>
            @endif
            <div class="layui-input-inline">
                <button class="layui-btn layui-btn-normal layui-btn-sm"
                        @click="getList(1,department_id,name)">
                    <i class="layui-icon">&#xe615;</i>搜索
                </button>
            </div>
        </div>
        <div class="layui-row m-lr20">
            <div class="layui-col-md2 c-left">
                <div class="grid-demo grid-demo-bg1">组织机构</div>
                <ul id="demop" class=""></ul>
            </div>
            <div class="layui-col-md10">
                <div class="layui-col-md12">
                    <table class="layui-table text-center" lay-size="sm">
                        <thead>
                        <tr>
                            <th style="width: 48px">#</th>
                            @if(asset('admin/manual/company') == url()->current())
                                <th>
                                    <div class="text-left">企业名称</div>
                                </th>
                                <th>
                                    <div class="text-left">转运中心数量</div>
                                </th>
                                <th>
                                    <div class="text-left">网点数量</div>
                                </th>
                            @elseif(asset('admin/manual/transportation') == url()->current())
                                <th>
                                    <div class="text-left">转运中心名称</div>
                                </th>
                                <th>
                                    <div class="text-left">所属企业</div>
                                </th>
                                <th>
                                    <div class="text-left">经营品牌</div>
                                </th>
                                <th>
                                    <div class="text-left">点位数量</div>
                                </th>
                            @elseif(asset('admin/manual/dot') == url()->current())
                                <th>
                                    <div class="text-left">网点名称</div>
                                </th>
                                <th>
                                    <div class="text-left">所属企业</div>
                                </th>
                                <th>
                                    <div class="text-left">经营品牌</div>
                                </th>
                                <th>
                                    <div class="text-left">点位数量</div>
                                </th>
                            @endif
                            <th>
                                <div class="text-left">负责人</div>
                            </th>
                            <th>
                                <div class="text-left">联系电话</div>
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
                            @if(asset('admin/manual/company') == url()->current())
                                <td>
                                    <div class="text-left" v-text="vo['transportation_count']"></div>
                                </td>
                                <td>
                                    <div class="text-left" v-text="vo['dot_count']"></div>
                                </td>
                            @elseif(asset('admin/manual/transportation') == url()->current())
                                <td>
                                    <div class="text-left" v-text="vo['company']"></div>
                                </td>
                                <td>
                                    <div class="text-left" v-text="vo['bname']"></div>
                                </td>
                                <td>
                                    <div class="text-left" v-text="vo['device_count']"></div>
                                </td>
                            @elseif(asset('admin/manual/dot') == url()->current())
                                <td>
                                    <div class="text-left" v-text="vo['company']"></div>
                                </td>
                                <td>
                                    <div class="text-left" v-text="vo['bname']"></div>
                                </td>
                                <td>
                                    <div class="text-left" v-text="vo['device_count']"></div>
                                </td>
                            @endif
                            <td>
                                <div class="text-left" v-text="vo['head']"></div>
                            </td>
                            <td v-text="vo['phone']"></td>
                            <td>
                                @if(asset('admin/manual/company') == url()->current())
                                    <a :href="'/admin/manual/transportation?pid=' + vo['id'] + '&department_id=' + department_id"
                                       class="layui-btn layui-btn-warm layui-btn-xs"
                                       v-if="vo['transportation_count'] > 0">转运中心</a>
                                    <a href="javascript:;"
                                       class="layui-btn layui-btn-warm layui-btn-xs layui-btn-disabled" v-else>转运中心</a>
                                    <a :href="'/admin/manual/dot?pid=' + vo['id'] + '&department_id=' + department_id"
                                       class="layui-btn layui-btn-danger layui-btn-xs" v-if="vo['dot_count'] > 0">网点</a>
                                    <a href="javascript:;"
                                       class="layui-btn layui-btn-danger layui-btn-xs layui-btn-disabled" v-else>网点</a>
                                    <button type="button" @click="queryDetail(2, vo['id'])"
                                            class="layui-btn layui-btn-xs" style="padding: 0 -1px;">详情
                                    </button>
                                @elseif(asset('admin/manual/transportation') == url()->current())
                                    <button type="button" @click="DvDetail(2,vo['id'],vo['name'])"
                                            class="layui-btn layui-btn-normal layui-btn-xs">资源
                                    </button>
                                    <button type="button" @click="queryDetail(0, vo['id'])"
                                            class="layui-btn layui-btn-xs" style="padding: 0 -1px;">详情
                                    </button>
                                @elseif(asset('admin/manual/dot') == url()->current())
                                    <button type="button" @click="DvDetail(3, vo['id'],vo['name'])"
                                            class="layui-btn layui-btn-normal layui-btn-xs">资源
                                    </button>
                                    <button type="button" @click="queryDetail(1, vo['id'])"
                                            class="layui-btn layui-btn-xs" style="padding: 0 -1px;">详情
                                    </button>
                                @endif

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
                <a @click="goBack(0)"><
                    <返回
                </a>
            </div>
        </div>
        <div class="layui-row main">
            <div class="layui-col-md8">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.name" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">所属企业</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.pname" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">注册地</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.position" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">许可号码</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.licenses" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">许可证有效期</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.last_time" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">品牌</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.brands" autocomplete="off" placeholder="请输入标题"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">法人</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.head" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">统一社会信用代码</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.code" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">区域范围</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.position" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn layui-btn-primary" @click="goBack(0)">返回</button>
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
                size: 0,
                department_id: "",
                pid: '',
                detail_info: false,
                name: "",
                company: {},
                info_main: true,
                height: "full-80",
                info: {},
                dv_detail: true,
                device_list: false,
                video_title: '回看模式',
                video_model: 0,
                iconName: "&#xe625;",
                dvList: [],
                oWebControl: null,// 插件对象
                bIE: (!!window.ActiveXObject || 'ActiveXObject' in window),// 是否为IE浏览器
                pubKey: '',
                iLastCoverLeft: 0,
                iLastCoverTop: 0,
                iLastCoverRight: 0,
                iLastCoverBottom: 0,
                initCount: 0,
                v_width: 900,
                v_height: 600,
                marginLeft: 220,
                dv_title: '',
                marginTop: 90,
                maxLen: 14,
                setTask: null,
                count: 0,
                num: 0,
                index: 0,
                pollTime: '{{ isset($time) ? $time : '30' }}',
                stopBtnVal: '开始轮播',
                isStop: true,
                btn_lunbo: "layui-btn layui-btn-disabled",
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
            changeActive: function ($event) {
                $event.currentTarget.className = "out_hover";
            },
            removeActive: function ($event) {
                $event.currentTarget.className = "out_list";
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
            stopInterFunc: function () {
                if (this.btn_lunbo == 'layui-btn layui-btn-disabled') {
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
            maxShow: function (string) {
                var haystack = string.toString();
                return haystack.length > this.maxLen
                    ? haystack.slice(0, this.maxLen) + "..."
                    : haystack;
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
            getList: function (page, department_id, name) {
                var num = this.getPage()
                var data = {
                    "page": page,
                    'page_size': num,
                    "department_id": department_id,
                    "name": name
                };
                if (this.pid) data.pid = this.pid;
                this.$http.post('{{ url()->current() }}', data, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.formData = res.body.data.data;
                            this.company = res.body.data.com;
                            var that = this;
                            this.$nextTick(function () {
                                layui.use('form', function () {
                                    var form = layui.form;
                                    form.on('select(company)', function (data) {
                                        that.pid = data.value;
                                    })
                                    form.render();
                                });
                            });
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
                                            var num = obj.limit;
                                            that.setPage(obj.limit)
                                            that.getList(curr, department_id, name);
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
            changeNav: function () {
                var str = window.location.search ? window.location.search : window.localStorage.getItem('manual_params');
                if (str) {
                    var obj = {};
                    window.localStorage.setItem('manual_params', str);
                    var arr = decodeURI(str).substring(1).split('&');
                    for (var i = 0; i < arr.length; i++) {
                        obj[arr[i].split('=')[0]] = arr[i].split('=')[1];
                    }
                    this.pid = obj.pid;
                    this.department_id = obj.department_id;
                    //顶部导航栏
                    var nav = $("#LAY_app_tabsheader", parent.document);
                    //侧边菜单栏
                    var mnav = $("#LAY-system-side-menu", parent.document);
                    //当前路由地址
                    var url = '{{ url()->current() }}';
                    //当前菜单ID
                    var tabId = mnav.find("a[lay-href='" + url + "']").attr('lay-id');
                    //当前菜单名称
                    var con = mnav.find("a[lay-href='" + url + "']").text();
                    if (nav.find("li[lay-id=" + tabId + "]").length == 0) {//是否有该导航栏 0没有
                        var html = '<li lay-id="' + tabId + '" lay-attr="' + url + '" class="layui-this">' + con +
                            '<i class="layui-icon layui-unselect layui-tab-close" onclick="deleteTab(' + tabId + ')">ဆ</i></li>';
                        //取消导航栏选中状态
                        nav.find('li').removeClass('layui-this');
                        //添加导航栏并选中
                        nav.append(html);
                        parent.lis.push(tabId);
                    } else { //有该导航栏
                        //取消导航栏选中状态
                        nav.find('li').removeClass('layui-this');
                        //选中该导航栏
                        nav.find("li[lay-id='" + tabId + "']").addClass('layui-this')
                    }
                    mnav.find("a[lay-href='" + url + "']").parent().addClass('layui-this')
                    mnav.find("a[lay-href='" + url + "']").parent().siblings().removeClass('layui-this')
                }
            },
            queryDetail: function (type, id) {
                if (type == 2) {
                    this.$http.get('/admin/company/show/' + id, {emulateJSON: true})
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
                    this.device_list = false;
                    this.info_main = false;
                    this.detail_info = true;
                } else if (type == 0) {
                    this.$http.get('/admin/transportation/show/' + id, {emulateJSON: true})
                        .then(function (res) {
                                if (res.body.code == 0) {
                                    this.info = res.body.data;

                                } else {
                                    var str = lea.msg(res.body.msg) || '服务器异常';
                                    layer.msg(str);
                                }
                            }, function (res) {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        );

                    this.device_list = false;
                    this.info_main = false;
                    this.detail_info = true;
                } else if (type == 1) {
                    this.$http.get('/admin/dot/show/' + id, {emulateJSON: true})
                        .then(function (res) {
                                if (res.body.code == 0) {
                                    this.info = res.body.data;
                                } else {
                                    var str = lea.msg(res.body.msg) || '服务器异常';
                                    layer.msg(str);
                                }
                            }, function (res) {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        );

                    this.device_list = false;
                    this.info_main = false;
                    this.detail_info = true;
                } else {
                    this.device_list = false;
                    this.info_main = true;
                    this.detail_info = false;
                }
            },
            DvDetail: function (type, id, name) {
                if (type == 1) {
                    this.device_list = false;
                    this.info_main = true;
                    this.detail_info = false;
                    return;
                } else if (type == 2) {
                    this.$http.post('/admin/manual/device/0/' + id, {}, {emulateJSON: true})
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
                } else if (type == 3) {
                    this.$http.post('/admin/manual/device/1/' + id, {}, {emulateJSON: true})
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
                }
                this.dv_title = name;
                this.device_list = true;
                this.info_main = false;
                this.detail_info = false;
                this.$nextTick(function () {
                    //初始化播放器
                    this.initPlugin()
                    //var t;
                    // clearTimeout(t)
                    // var that = this
                    // t = setTimeout(function () {
                    //     that.init()
                    // }, 1000);
                })
            },
            chooseDevice: function ($event) {
                $event.currentTarget.classList.toggle('bg-color');
            },
            goBack: function (type) {
                if (type == 1) {
                    if (this.oWebControl != null) {
                        var that = this;
                        if (this.video_model == 0) {
                            //this.stopAllPreview()
                        } else {
                            this.video_model = 0
                            this.video_title = "回看模式"
                            //this.stopAllPlayback()
                        }
                        // this.uninit()
                        this.oWebControl.JS_HideWnd();
                        if (!!window.ActiveXObject || "ActiveXObject" in window) {// IE
                            that.device_list = false;
                            that.detail_info = false;
                            that.info_main = true;
                        } else {
                            this.oWebControl.JS_Disconnect().then(function () {
                                //关闭成功后再关闭窗口不然会延迟
                                that.device_list = false;
                                that.detail_info = false;
                                that.info_main = true;
                            }, function () {
                            });
                        }
                    } else {
                        //插件未安装或启动直接关闭弹出层
                        this.device_list = false;
                        this.detail_info = false;
                        this.info_main = true;
                    }
                    this.stopBtnVal = '开始轮播'
                    this.isStop = true
                    clearTimeout(this.setTask);
                } else {
                    this.detail_info = false;
                    this.device_list = false;
                    this.info_main = true;
                }
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
                    szClassId: "23BF3B0A-2C56-4D97-9C03-0CB103AA8F11",
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
                                that.device_list = false;
                                clearTimeout(that.setTask);
                                that.downLoadExe();
                                layer.close(index);
                            })
                        }
                    },
                    cbConnectClose: function (bNormalClose) {
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
            uninit: function () {
                this.oWebControl.JS_RequestInterface({
                    funcName: "uninit"
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
                                th.department_id = node.id;
                                th.pid = '';
                                th.getList(1, th.department_id, th.name);
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
            this.changeNav();
            this.getList(1, this.department_id, this.name);
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