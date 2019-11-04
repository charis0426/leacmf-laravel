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
    <link rel="stylesheet" href="/static/admin/plugins/font/iconfont.css" media="all">
</head>
<style>
    .top {
        padding: 0px 20px;
        background: #fff;
        height: 50px;
        line-height: 50px;
        color: #505050;
        font-size: 16px;
        border-bottom: 1px solid #dcdcdc;
    }

    .top-right {
        text-align: right;
    }

    .top-right a {
        color: #1e9fff;
        cursor: pointer;
    }

    .layui-layer-title {
        text-align: center;
        color: #666;
        padding: 0;
    }

    .layui-layer-content {
        text-align: center;
    }

    .layui-layer-btn {
        text-align: center;
    }

    .layui-treeSelect .ztree li {
        line-height: 20px !important;
        padding: 2px 0;
    }

    .layui-treeSelect .ztree * {
        font-size: 12px !important;
    }
</style>
<body layadmin-themealias="default">
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    @if( asset('admin/log') == url()->current() )
        <form class="layui-form" method="post" action="/admin/log/export">
            <div class="layui-row">
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">组织机构</label>
                    <div class="layui-input-inline">
                        <input type="text" name="department" id="department" lay-filter="tree"
                               class="layui-input layui-input-search">
                    </div>
                </div>
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">操作人员</label>
                    <div class="layui-input-inline">
                        <select lay-filter="user" lay-search class="layui-input layui-input-search">
                            <option value="" selected>请选择操作人员</option>
                            <option v-for="(vo,id) in region" :value="vo['nickname']">@{{ vo['nickname'] }}</option>
                        </select>
                        <input type="hidden" name="name" :value="name">
                    </div>
                </div>
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">日志时间</label>
                    <div class="layui-input-inline">
                        <input type="text" placeholder="请输入起止时间" autocomplete="off"
                               class="layui-input layui-input-search" id="ste">
                        <input type="hidden" name="start_time" :value="start_time">
                        <input type="hidden" name="end_time" :value="end_time">
                    </div>
                </div>
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">日志类型</label>
                    <div class="layui-input-inline">
                        <input type="text" id="logtype" lay-filter="tree" class="layui-input layui-input-search">
                        <input type="hidden" name="type" :value="type">
                    </div>
                </div>
                <div class="layui-input-inline">
                    <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" @click="getList(1)">
                        <i class="layui-icon">&#xe615;</i>搜索
                    </button>
                </div>
            </div>
            <div class="layui-row m-lr20">
                <input type="hidden" name="ids" :value="ids">
                <button type="button" @click="exportLog()" class="layui-btn layui-btn-sm">
                    <span class="icon iconfont">&#xe61c;</span>
                    导出
                </button>
                <button type="button" @click="logFile()" class="layui-btn layui-btn-sm">
                    <span class="icon iconfont">&#xe88b;</span>
                    归档
                </button>
                <div style="clear: both"></div>
            </div>
        </form>
        <div class="layui-row m-lr20" style="margin-top: 20px">
            <div class="layui-col-md12">
                <table class="layui-table  text-center layui-form" lay-filter="demo" lay-size="sm">
                    <colgroup>
                        <col width="50">
                        <col width="140">
                        <col width="200">
                        <col width="200">
                        <col width="200">
                        <col width="200">
                        <col>
                    </colgroup>
                    <thead>
                    <tr>
                        <th style="width: 48px;">#</th>
                        <th>
                            <div class="text-left">日志类型</div>
                        </th>
                        <th>
                            <div class="text-left">操作时间</div>
                        </th>
                        <th>
                            <div class="text-left">IP地址</div>
                        </th>
                        <th>
                            <div class="text-left">操作者</div>
                        </th>
                        <th>
                            <div class="text-left">组织机构</div>
                        </th>
                        <th>
                            <div class="text-left">日志内容</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="vo,id in formData">
                        <td>
                            <div class="text-left" v-text="id+1+size"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['type']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['created_at']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['ip']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['nick_name']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['department']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['content']"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="layui-col-md12">
                <div id="demoa"></div>
            </div>
        </div>
    @elseif( asset('admin/log/operation') == url()->current() )
        <div v-show="operation_list">
            <form class="layui-form" method="post" action="/admin/log/export">
                <div class="layui-row">
                    <div class="layui-inline layui-form-serch">
                        <label class="layui-form-label-search">日志日期</label>
                        <div class="layui-input-inline">
                            <input type="text" placeholder="请输入起止时间" autocomplete="off"
                                   class="layui-input layui-input-search"
                                   id="endtime">
                        </div>
                    </div>
                    <div class="layui-input-inline">
                        <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" @click="getList(1)">
                            <i class="layui-icon">&#xe615;</i>搜索
                        </button>
                    </div>
                </div>
            </form>
            <div class="layui-row m-lr20">
                <div class="layui-col-md12">
                    <table class="layui-table text-center layui-form" lay-filter="demo" lay-size="sm">
                        <colgroup>
                            <col width="50">
                            <col width="140">
                            <col width="200">
                            <col width="200">
                            <col>
                        </colgroup>
                        <thead>
                        <tr>
                            <th style="width: 48px;">#</th>
                            <th>
                                <div class="text-left">日志名称</div>
                            </th>
                            <th>
                                <div class="text-left">时间</div>
                            </th>
                            <th>
                                <div class="text-left">操作</div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="vo,id in formData">
                            <td>
                                <div class="text-left" v-text="id+1+size"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo.substring(4,14)"></div>
                            </td>
                            <td>
                                <button type="button" @click="queryDetail(vo, 1)" class="layui-btn layui-btn-xs">详情
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
        <div v-show="operation_content">
            <div class="layui-row top">
                <div class="layui-col-md6" v-text="name ? name : '日志详情'"></div>
                <div class="layui-col-md6 top-right">
                    <a @click="goBack">返回</a>
                </div>
            </div>
            <div class="layui-row" style="margin: 20px 20px 0px 20px">
                <div class="layui-col-md12">
                    <table class="layui-table text-center layui-form" lay-filter="demo" lay-size="sm">
                        <colgroup>
                            <col>
                        </colgroup>
                        <thead>
                        <th style="text-align: center">日志内容</th>
                        </thead>
                        <tbody>
                        <tr v-for="item in operation_show">
                            <td>
                                <div class="text-left" v-text="item"></div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="layui-col-md12">
                    <div id="operation_content"></div>
                </div>
            </div>
        </div>
    @endif
</div>

<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/layer.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>
<script src="/static/hls.js"></script>
<script src="/static/layuiadmin/echarts.js"></script>
<script src="/static/admin/plugins/font/iconfont.js"></script>

<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                size: 0,
                formData: {},
                region: {},
                type: "",
                start_time: "",
                end_time: "",
                department_id: "",
                name: "",
                ids:'',
                count: 0,
                operation_list: true,
                operation_content: false,
                operation_show: {},
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
            getList: function (page) {
                var num = this.getPage();
                        @if( asset('admin/log') == url()->current() )
                var data = {
                        "page": page,
                        'page_size': num
                    };
                this.department_id ? data.department_id = this.department_id : '';
                this.type ? data.type = this.type : '';
                this.start_time ? data.start_time = this.start_time : '';
                this.end_time ? data.end_time = this.end_time : '';
                this.name ? data.name = this.name : '';

                this.$http.post('{{ url()->current() }}', data, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.formData = res.body.data.data;
                            this.count = res.body.data.count;
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
                        @elseif( asset('admin/log/operation') == url()->current() )
                var data = {
                        "page": page,
                        'page_size': num
                    };
                this.start_time ? data.start_time = this.start_time : '';
                this.end_time ? data.end_time = this.end_time : '';
                this.$http.post('{{ url()->current() }}', data, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.formData = res.body.data.data;
                            this.count = res.body.data.count;
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
                @endif
            },
            queryDetail: function (str, page) {
                var num = this.getPage();
                this.operation_list = false;
                this.operation_content = true;
                this.name = str ? str : this.name;
                this.$http.post('/admin/log/operation/content', {
                    "name": str,
                    "page": page,
                    "page_size": num
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.operation_show = res.body.data.data;
                            this.count = res.body.data.total;
                            var that = this;
                            that.count = page > 1 ? (page - 1) * num : 0;
                            layui.use('laypage', function () {
                                var laypage = layui.laypage;
                                //执行一个laypage实例
                                laypage.render({
                                    elem: 'operation_content'
                                    , count: res.body.data.total
                                    , curr: res.body.data.current_page
                                    , limit: num
                                    , layout: ['limit', 'prev', 'page', 'next', 'count', 'skip']
                                    , jump: function (obj, first) {
                                        if (!first) {
                                            //当前点击页面
                                            var curr = obj.curr;
                                            that.setPage(obj.limit)
                                            that.queryDetail(that.name, curr);
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
            logFile: function () {
                var that = this;
                layer.open({
                    type: 1,
                    title: '是否将日志归档',
                    closeBtn: 1,
                    area: ['400px', '200px'],
                    shadeClose: true,
                    shade: 0.3,
                    btn: ['确定', '取消'],
                    content: ' <div class="layui-inline layui-form-serch">\n' +
                        '           <label>归档截止日期</label>\n' +
                        '           <div class="layui-input-inline">\n' +
                        '                <input type="text" placeholder="请选择截止时间" autocomplete="off" class="layui-input layui-input-search" id="test1">\n' +
                        '           </div>\n' +
                        '           <span style="color: #c3c3c3;font-size: 12px;display: inline-block;">归档开始时间默认上次归档截止时间</span>' +
                        '       </div>',
                    yes: function (index) {
                        layer.close(index);
                        layer.load(2, {content: '归档中', shade: [0.3, '#393D49']});
                        that.$http.post('/admin/log/file', {
                            "time": that.end_time
                        }, {emulateJSON: true})
                            .then(function (res) {
                                layer.closeAll('loading');
                                if (res.body.code == 0) {
                                    var str = lea.msg(res.body.msg) || '归档成功';
                                    layer.msg(str);
                                    that.getList(1);
                                } else {
                                    var str = lea.msg(res.body.msg) || '服务器异常';
                                    layer.msg(str);
                                }
                            }, function (res) {
                                layer.closeAll('loading');
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            });
                    }
                });
                layui.use('laydate', function () {
                    var laydate = layui.laydate;
                    var now = new Date();
                    var maxDate = now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + now.getDate();
                    //执行一个laydate实例
                    laydate.render({
                        elem: '#test1',
                        max: maxDate,
                        done: function (value) {
                            that.end_time = value;
                        }
                    });
                });
            },
            exportLog: function () {
                layer.confirm("是否导出日志数据？", {title: "导出日志"}, function () {
                    layer.closeAll();
                    $("form").submit();

                })
            },
            logUser: function () {
                var data = {};
                this.department_id ? data.department_id = this.department_id : '';
                this.name ? data.name = this.name : '';
                this.$http.post('/admin/log/user', data, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.region = res.body.data;
                            var that = this;
                            that.$nextTick(function () {
                                layui.use('form', function () {
                                    var form = layui.form;
                                    form.on('select(user)', function (data) {
                                        that.name = data.value;
                                    });
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
            goBack: function () {
                this.operation_list = true;
                this.operation_content = false;
            },
        },
        mounted: function () {
            this.getList(1);
            this.logUser();
            $("#load_gif").hide();
            $("#app").show();
        },

        created: function () {
            var that = this;

            layui.use('laydate', function () {
                var laydate = layui.laydate;
                laydate.render({
                    elem: '#ste'
                    , type: 'date'
                    , range: '~'
                    , format: 'yyyy-MM-dd'
                    , done: function (value) {
                        var time = value.split(' ~ ');
                        that.start_time = time[0];
                        that.end_time = time[1];
                    }
                });
                laydate.render({
                    elem: '#endtime'
                    , type: 'date'
                    , range: '~'
                    , format: 'yyyy-MM-dd'
                    , done: function (value) {
                        var time = value.split(' ~ ');
                        that.start_time = time[0];
                        that.end_time = time[1];
                    }
                });
            });
            @if( asset('admin/log') == url()->current() )
            layui.use('treeSelect', function () {
                var treeSelect = layui.treeSelect;
                var form = layui.form;
                var search = true;
                if (!!window.ActiveXObject || "ActiveXObject" in window) {// IE下不开启搜索功能
                    search = false;
                }
                treeSelect.render({
                    // 选择器
                    elem: '#department',
                    // 数据
                    data: '/admin/log/department',
                    // 异步加载方式：get/post，默认get
                    type: 'get',
                    // 占位符
                    placeholder: '请选择组织机构',
                    // 是否开启搜索功能：true/false，默认false
                    search: search,
                    // 点击回调
                    click: function (d) {
                        that.department_id = d.current.id;
                        that.logUser();
                    }
                });
                treeSelect.render({
                    // 选择器
                    elem: '#logtype',
                    // 数据
                    data: '/admin/log/type',
                    // 异步加载方式：get/post，默认get
                    type: 'get',
                    // 占位符
                    placeholder: '请选择日志类型',
                    // 是否开启搜索功能：true/false，默认false
                    search: search,
                    // 点击回调
                    click: function (d) {
                        that.type = d.current.name;
                    }
                });
            });
            @endif
        }
    })
    ;
</script>
</body>
</html>