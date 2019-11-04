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
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div v-show="info_main">
        <form class="layui-form">
            <div class="layui-row">
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label" style="width: 100px;">备份起止时间</label>
                    <div class="layui-input-inline" style="width: 300px;">
                        <input type="text" placeholder="请输入起止时间" autocomplete="off"
                               class="layui-input layui-input-search" id="ste">
                        <input type="hidden" name="start_time">
                        <input type="hidden" name="end_time">
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
            <div class="layui-col-md8">
                <div class="layui-col-md12">
                    <table class="layui-table text-center" lay-size="sm">
                        <thead>
                        <tr>
                            <th style="width: 48px">#</th>
                            <th>
                                <div class="text-left">文件名称</div>
                            </th>
                            <th>
                                <div class="text-left">备份时间</div>
                            </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(vo,id) in formData">
                            <td v-text="id+1+size">
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['title']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['created_at']"></div>
                            </td>

                            <td>
                                <button type="button" @click="recovery(vo['id'])"
                                        class="layui-btn layui-btn-xs">还原
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
            <div class="layui-col-md4">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">图片还原</div>
                        <div class="layui-card-body">


                            <form class="layui-form" action="">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">还原时间：</label>
                                    <div class="layui-input-block">
                                        <input type="text" class="layui-input" id="picTime" placeholder="yyyy-MM-dd">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <div class="layui-input-block">
                                        <button class="layui-btn layui-btn-sm" lay-submit lay-filter="picture">立即提交
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">数据备份</div>
                        <div class="layui-card-body">
                            <form class="layui-form" action="">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">备份数据</label>
                                    <div class="layui-input-block">
                                        <input type="checkbox" name="type" value='1' title="数据库" checked>
                                        <input type="checkbox" name="type" value='2' title="应用程序">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <div class="layui-input-block">
                                        <button class="layui-btn layui-btn-sm" lay-submit lay-filter="backup">立即提交
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                department_id: "",
                detail_info: false,
                info_main: true,
                show_data: false,
                info: {},
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
                this.$http.post('{{ url()->current() }}', {
                    "page": page,
                    'page_size': num,
                    "department_id": this.department_id,
                    "start_time": this.start_time,
                    "end_time": this.end_time
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
            recovery: function (id) {
                layer.load(2, {
                    content: '还原中',
                    shade: [0.3, '#393D49'],
                    success: function (layero) {
                        layero.find('.layui-layer-loading2').css('padding-top', '40px');
                        layero.find('.layui-layer-loading2').css('width', '100px');
                    }
                })
                this.$http.post('/admin/data/recovery/' + id, {emulateJSON: true})
                    .then(function (res) {
                            layer.closeAll('loading');
                            if (res.body.code == 0) {
                                // this.info = res.body.data;
                                // this.detail_info = false;
                                // this.info_main = true;
                                // this.show_data = false;
                                // this.getList(1);
                                layer.msg('还原成功，请重新登录系统');
                                setTimeout(function () {
                                    top.location = "{{ route('logout') }}";
                                }, 2000);
                            } else {
                                var str = lea.msg(res.body.msg) || '文件不存在';
                                layer.msg(str);
                            }
                        }, function (res) {
                            layer.closeAll('loading');
                            var str = lea.msg(res.body.msg) || '文件不存在';
                            layer.msg(str);
                        }
                    )
            },
            dataBackup: function (type) {
                if (!type) {
                    layer.msg('备份数据类型不能为空');
                    return false;
                }
                layer.load(2, {
                    content: '备份中',
                    shade: [0.3, '#393D49'],
                    success: function (layero) {
                        layero.find('.layui-layer-loading2').css('padding-top', '40px');
                        layero.find('.layui-layer-loading2').css('width', '100px');
                    }
                })
                this.$http.post('/admin/data/backup', {"type": type}, {emulateJSON: true})
                    .then(function (res) {
                            layer.closeAll('loading');
                            if (res.body.code == 0) {
                                this.info = res.body.data;
                                this.detail_info = false;
                                this.info_main = true;
                                this.show_data = false;
                                this.getList(1);
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }, function (res) {
                            layer.closeAll('loading');
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    )
            },

        },
        mounted: function () {
            this.getList(1);
            $("#load_gif").hide();
            $("#app").show();
        },

        created: function () {
            var that = this;
            layui.use('form', function () {
                var form = layui.form;
                form.render();
                form.on('submit(backup)', function (data) {
                    var arr = new Array();
                    $("input:checkbox[name='type']:checked").each(function (i) {
                        arr[i] = $(this).val();
                    });
                    var type = arr.join(",");//将数组合并成字符串
                    that.dataBackup(type);
                    return false;
                });
            })
            layui.use('laydate', function () {
                var laydate = layui.laydate;
                laydate.render({
                    elem: '#ste'
                    , type: 'datetime'
                    , range: '~'
                    , format: 'yyyy-MM-dd HH:mm:ss'
                    , done: function (value) {
                        var time = value.split(' ~ ');
                        that.start_time = time[0];
                        that.end_time = time[1];
                    }
                });
                laydate.render({
                    elem: '#picTime'
                    , done: function (value, date) {

                    }
                });
            });


        }
    });

</script>
</body>
</html>