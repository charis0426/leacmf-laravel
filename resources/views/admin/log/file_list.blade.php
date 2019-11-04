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
<style>
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
    <div v-show="info_main">
        <form class="layui-form">
            <div class="layui-row">
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">日志日期</label>
                    <div class="layui-input-inline">
                        <input type="text" placeholder="请输入起止时间" autocomplete="off"
                               class="layui-input layui-input-search" id="ste">
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
                <table class="layui-table  text-center layui-form" lay-filter="demo" lay-size="sm">
                    <thead>
                    <tr>
                        <th style="width: 48px;">#</th>
                        <th>
                            <div class="text-left">归档名称</div>
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
                            <div class="text-left" v-text="vo['name']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['created_at']"></div>
                        </td>
                        <td>
                            <button class="layui-btn layui-btn-xs" v-if="vo['status'] == 1"
                                    @click="contentLog(1,vo['id'])">查看
                            </button>
                            <button class="layui-btn layui-btn-warm layui-btn-xs" v-else-if="vo['status'] == 0"
                                    @click="activation(vo['id'])">激活
                            </button>
                            <button class="layui-btn layui-btn-danger layui-btn-xs" v-if="vo['status'] == 1"
                                    @click="delLog(vo['id'])">删除
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
    <div v-show="list_main">
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
                        <select v-model="name" lay-filter="user" lay-search
                                class="layui-input layui-input-search">
                            <option value="" selected>请选择操作者</option>
                            <option v-for="(vo,id) in region" :value="vo['nickname']">@{{ vo['nickname'] }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">日志时间</label>
                    <div class="layui-input-inline">
                        <input type="text" placeholder="请输入起止时间" autocomplete="off"
                               class="layui-input layui-input-search" id="time">
                        <input type="hidden" name="start_time" :value="start_time">
                        <input type="hidden" name="end_time" :value="end_time">
                    </div>
                </div>
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">日志类型</label>
                    <div class="layui-input-inline">
                        <input type="text" name="type" id="logtype" lay-filter="tree"
                               class="layui-input layui-input-search">
                    </div>
                </div>
                <div class="layui-input-inline">
                    <button type="button" class="layui-btn layui-btn-normal layui-btn-sm"
                            @click="contentLog(1,id)">
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
                            <div class="text-left">时间</div>
                        </th>
                        <th>
                            <div class="text-left">登录IP</div>
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
                <div id="demob"></div>
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
<script src="/static/hls.js"></script>
<script src="/static/layuiadmin/echarts.js"></script>

<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                size: 0,
                formData: {},
                start_time: "",
                end_time: "",
                info_main: true,
                list_main: false,
                name: '',
                count: 0,
                type: '',
                region: {},
                id: ""
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
                            var str = lea.msg(res.body.msg) || '参数异常';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '数据丢失';
                        layer.msg(str);
                    });
            },
            exportLog: function () {
                layer.confirm("是否确认导出日志数据吗？", {title: "导出日志"}, function () {
                    layer.closeAll();
                    $("form").submit();

                })
            },
            contentLog: function (page, id) {
                var num = this.getPage();
                var data = {
                    "page": page,
                    'page_size': num
                };
                id ? data.id = this.id = id : data.id = this.id;
                this.department_id ? data.department_id = this.department_id : '';
                this.name ? data.name = this.name : '';
                this.type ? data.type = this.type : '';
                this.start_time ? data.start_time = this.start_time : '';
                this.end_time ? data.end_time = this.end_time : '';

                this.$http.post('/admin/log/activation/content', data, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.info_main = false;
                            this.list_main = true;
                            this.formData = res.body.data.data;
                            var that = this;
                            that.size = page > 1 ? (page - 1) * num : 0;
                            layui.use('laypage', function () {
                                var laypage = layui.laypage;
                                //执行一个laypage实例
                                laypage.render({
                                    elem: 'demob'
                                    , count: res.body.data.count
                                    , curr: res.body.data.current_page
                                    , limit: num
                                    , layout: ['limit', 'prev', 'page', 'next', 'count', 'skip']
                                    , jump: function (obj, first) {
                                        if (!first) {
                                            //当前点击页面
                                            var curr = obj.curr;
                                            that.setPage(obj.limit);
                                            that.contentLog(curr, this.id);
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
                            var str = lea.msg(res.body.msg) || '参数异常';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '数据丢失无法查看';
                        layer.msg(str);
                    });
            },
            activation: function (id) {
                var that = this;
                layer.confirm("确认要激活吗？", {title: "激活确认"}, function (index) {
                    layer.close(index);
                    layer.load(2, {
                        content: '激活中',
                        shade: [0.3, '#393D49'],
                        success: function (layero) {
                            layero.find('.layui-layer-loading2').css('padding-top', '40px');
                            layero.find('.layui-layer-loading2').css('width', '100px');
                        }
                    })
                    that.$http.get('/admin/log/activation/' + id, {emulateJSON: true})
                        .then(function (res) {
                            layer.closeAll('loading');
                            if (res.body.code == 0) {
                                that.getList(1)
                                layer.msg(lea.msg(res.body.msg));
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }, function (res) {
                            layer.closeAll('loading');
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        });
                });
            },
            delLog: function (id) {
                var that = this;
                layer.confirm("确认要删除吗，删除后不可恢复!", {title: "删除确认"}, function () {
                    that.$http.get('/admin/log/activation/delete/' + id, {emulateJSON: true})
                        .then(function (res) {
                            if (res.body.code == 0) {
                                layer.msg(lea.msg(res.body.msg));
                                that.getList(1)
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        });
                });
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
        },
        mounted: function () {
            this.getList(1);
            this.logUser();
            $("#load_gif").hide();
            $("#app").show();
        },

        created: function () {
            var that = this;
            layui.use('form', function () {
                var form = layui.form;
                form.on('select(p_type)', function (data) {
                    $("#p_type").attr('value', data.value)
                    that.type = data.value;
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
                form.render();
            })
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
            });
            layui.use('laydate', function () {
                var laydate = layui.laydate;
                laydate.render({
                    elem: '#time'
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
            layui.use('treeSelect', function () {
                var treeSelect = layui.treeSelect;
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
                    search: true,
                    // 点击回调
                    click: function (d) {
                        that.department_id = d.current.id;
                        that.logUser();
                    }
                });
            });

            layui.use('treeSelect', function () {
                var treeSelect = layui.treeSelect;
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
                    search: true,
                    // 点击回调
                    click: function (d) {
                        that.type = d.current.name;
                    }
                });
            });
        }
    })
    ;
</script>
</body>
</html>