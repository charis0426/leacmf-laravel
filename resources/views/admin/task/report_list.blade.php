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
    <link id="layuicss-layer" rel="stylesheet"
          href="/static/layui/css/modules/formSelects-v4.css" media="all">
    <link rel="stylesheet" href="/static/layuiadmin/style/common.css" media="all">
</head>
<body layadmin-themealias="default">
<style>
    .lay-ext-mulitsel .layui-input.multiple {
        height: 33px !important;
        min-height: 33px;
        max-height: 33px;
        margin-top: -30px;
    }

    .lay-ext-mulitsel .layui-input.multiple a {
        line-height: 16px !important;
        height: 16px !important;
    }

    .lay-ext-mulitsel .tips {
        top: 5px !important;
    }

    .layui-form-item .layui-input-inline {
        width: 100% !important;
    }

    .layui-form-checkbox[lay-skin=primary] {
        height: 30px !important;
    }

    .echart {
        width: 100%;
        min-width: 600px;
        min-height: 400px;
    }
    .big_title{
        width: 120px!important;
        color: #1e9fff !important;
        font-size: 16px !important;
    }
    .pt-table{
        height: calc(100% - 260px);
        height: -moz-calc(100% - 260px);
        height: -webkit-calc(100% - 260px);
        margin-left: 160px;
        overflow-y: auto;
    }
</style>
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div v-show="info_main">
        <form class="layui-form">
            <div class="layui-row">
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">统计名称</label>
                    <div class="layui-input-inline">
                        <input type="text" v-model="name" placeholder="请输入统计名称" autocomplete="off"
                               class="layui-input layui-input-search">
                    </div>
                </div>
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label-search">起止时间</label>
                    <div class="layui-input-inline" style="width: 300px;">
                        <input type="text" placeholder="请选择起止时间" autocomplete="off"
                               class="layui-input layui-input-search" id="ste">
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
        <div class="layui-row" style="padding: 0px 20px 0px 20px;">
                <div class="layui-col-md12">
                    <table class="layui-table text-center" lay-size="sm">
                        <thead>
                        <tr>
                            <th style="width: 48px">编号</th>
                            <th>
                                <div class="text-left">统计报告名称</div>
                            </th>
                            <th>
                                <div class="text-left">统计时间</div>
                            </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(vo,id) in formData">
                            <td v-text="id+1+size"></td>
                            <td v-text="vo['report_name']"></td>
                            <td>
                                <div class="text-left" v-text="vo['stop_time']"></div>
                            </td>
                            <td>
                                <button type="button"  @click="reportDetail(vo['id'])"
                                        class="layui-btn layui-btn-xs">详情
                                </button>
                                <button type="button"  @click="exportTask(vo['id'])"
                                        class="layui-btn layui-btn-normal layui-btn-xs">导出
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
    <div class="info-detail" v-show="detail_info">
        <div class="layui-row top">
            <div class="layui-col-md6">
                报告详情
            </div>
            <div class="layui-col-md6 top-right">
                <a @click="goBack()">返回</a>
            </div>
        </div>
        <div class="layui-row main">
            <div class="layui-col-md7 layui-form" style="">
                <div class="layui-form-item">
                    <label class="layui-form-label">分析报告名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" readonly :value="info.report_name"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">报告时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" readonly :value="backTime(info)"
                               class="layui-input">
                    </div>
                </div>
                <div class="pt-table">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td colspan="2" style="font-size: 18px;color:#0099FF">监管对象</td>
                    </tr>
                    <tr>
                        <td>减少/新增</td>
                        <td>数量</td>
                    </tr>
                    <tr>
                        <td v-if="info.supervisor>=0">新增</td>
                        <td v-else>减少</td>
                        <td>@{{ Math.abs(info.supervisor) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size: 18px;color:#0099FF">点位数量</td>
                    </tr>
                    <tr>
                        <td>减少/新增</td>
                        <td>数量</td>
                    </tr>
                    <tr>
                        <td v-if="info.number_of_dots>=0">新增</td>
                        <td v-else>减少</td>
                        <td>@{{ Math.abs(info.number_of_dots) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size: 18px;color:#0099FF">重点对象</td>
                    </tr>
                    <tr>
                        <td>减少/新增</td>
                        <td>数量</td>
                    </tr>
                    <tr>
                        <td v-if="info.key_objects>=0">新增</td>
                        <td v-else>减少</td>
                        <td>@{{ Math.abs(info.key_objects) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size: 18px;color:#0099FF">视频巡检</td>
                    </tr>
                    <tr>
                        <td>时间类型</td>
                        <td>事件数量</td>
                    </tr>
                    <tr>
                        <td>断网</td>
                        <td v-text="info.broken_network"></td>
                    </tr>
                    <tr>
                        <td>无信号</td>
                        <td v-text="info.no_signal"></td>
                    </tr>
                    <tr>
                        <td>黑屏</td>
                        <td v-text="info.blackscreen"></td>
                    </tr>
                    <tr>
                        <td>花屏</td>
                        <td v-text="info.blurred_screen"></td>
                    </tr>
                    <tr>
                        <td>遮挡</td>
                        <td v-text="info.shelter_from"></td>
                    </tr>
                    <tr>
                        <td>冻结</td>
                        <td v-text="info.frozen"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size: 18px;color:#0099FF">智能分析</td>
                    </tr>
                    <tr>
                        <td>时间类型</td>
                        <td>事件数量</td>
                    </tr>
                    <tr>
                        <td>暴力分拣</td>
                        <td v-text="info.violent_sorting"></td>
                    </tr>
                    <tr>
                        <td>安检机未运行</td>
                        <td v-text="info.sec_not_run"></td>
                    </tr>
                    <tr>
                        <td>案件人员不在岗</td>
                        <td v-text="info.not_on_duty"></td>
                    </tr>
                    <tr>
                        <td>传送带跨越</td>
                        <td v-text="info.belt_crossing"></td>
                    </tr>
                    <tr>
                        <td>火灾</td>
                        <td v-text="info.fire"></td>
                    </tr>
                    <tr>
                        <td>爆仓</td>
                        <td v-text="info.burst_warehouse"></td>
                    </tr>
                    <tr>
                        <td>网点是否营业</td>
                        <td v-text="info.outlet_open"></td>
                    </tr>
                    <tr>
                        <td>疑似件</td>
                        <td v-text="info.suspected_package"></td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="layui-form-item ayui-col-md7" style="padding-top: 10px;margin-left: 160px">
                <div class="layui-input-block" style="margin-left: 0px">
                    <button class="layui-btn layui-btn-normal" @click="exportTask(info.id)">导出</button>
                    <button type="reset" class="layui-btn layui-btn-primary" @click="goBack()">返回</button>
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
<script src="/static/layuiadmin/echarts.js"></script>

<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                info_main: true,
                formData: {},
                size: 0,
                start_time: "",
                end_time: "",
                detail_info: false,
                name: "",
                info:{}

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
            exportTask: function (id) {
                layer.confirm("确认是否导出？", {title: "导出报告"}, function (index) {
                    layer.close(index);
                    var $form = $('<form method="GET"></form>');
                    $form.attr('action', '/admin/task/report/export/' + id);
                    $form.appendTo($('body'));
                    $form.submit();
                })
            },
            goBack:function(){
                this.detail_info = false
                this.info_main = true
            },
            backTime:function(info){
                return info.start_time+"~"+info.stop_time;
            },
            reportDetail:function(id){
                this.$http.post('/admin/task/report/show/'+id, {}, {emulateJSON: true})
                    .then(function (res) {
                        if(res.body.code == 0){
                            this.info = res.body.data
                            this.info_main = false
                            this.detail_info = true
                        }
                        else{
                            layer.msg("查询失败");
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            getList: function (page) {
                var num = this.getPage()
                var data = {
                    "page": page,
                    'page_size': num
                };
                this.name ? data.name = this.name : '';
                this.start_time ? data.start_time = this.start_time : '';
                this.end_time ? data.end_time = this.end_time : '';
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
                                    , count: res.body.data.total
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

        },
        mounted: function () {
            this.getList(1);
            $("#load_gif").hide();
            $("#app").show();
        },

        created: function () {
            var that = this;
            layui.config({
                base: '/static/layuiadmin/'
            }).extend({
                formSelects: 'layui_extends/formSelects-v4',
            }).use(['laydate', 'form', 'formSelects'], function () {
                var laydate = layui.laydate,
                    form  = layui.form;
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
                form.render();
            });
        }
    });
</script>
</body>
</html>