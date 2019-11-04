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

    .big_title {
        width: 120px !important;
        color: #1e9fff !important;
        font-size: 16px !important;
    }
</style>
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div v-show="info_main">
        <form class="layui-form">
            <div class="layui-row">
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label">定制报告名称</label>
                    <div class="layui-input-inline">
                        <input type="text" v-model="name" placeholder="请输入定制报告名称" autocomplete="off"
                               class="layui-input layui-input-search">
                    </div>
                </div>
                <div class="layui-inline layui-form-serch">
                    <label class="layui-form-label">创建起止时间</label>
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
            <div class="layui-col-md12" style="margin-bottom: 10px">
                <button type="button" class="layui-btn layui-btn-sm"
                        @click="PortCk()">
                    <i class="layui-icon">&#xe62c;</i>
                    可视化定制
                </button>
            </div>
            <div class="layui-col-md12">
                <table class="layui-table text-center" lay-size="sm">
                    <thead>
                    <tr>
                        <th style="width: 48px">#</th>
                        <th>
                            <div class="text-left">定制报告名称</div>
                        </th>
                        <th>
                            <div class="text-left">报告创建时间</div>
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(vo,id) in formData">
                        <td v-text="id+1+size"></td>
                        <td v-text="vo['name']"></td>
                        <td>
                            <div class="text-left" v-text="vo['created_at']"></div>
                        </td>
                        <td>
                            <button type="button" v-if="vo['status'] == 2" @click="exportTask(vo)"
                                    class="layui-btn layui-btn-normal layui-btn-xs">导出
                            </button>
                            <button type="button" v-else
                                    class="layui-btn layui-btn-disabled layui-btn-xs">正在生成,请明日下载
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
    <div class="info-detail" v-show="add_info">
        <div class="layui-row top">
            <div class="layui-col-md6">
                可视化报告定制
            </div>
            <div class="layui-col-md6 top-right">
                <a @click="PortCk(0)">返回</a>
            </div>
        </div>
        <div class="layui-row main">
            <div class="layui-col-md7 layui-form" style="height:500px;">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" v-model="info.name" placeholder="请输入定制报告名称" value=""
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">时间</label>
                    <div class="layui-input-block">
                        <input type="text" placeholder="请输入定制报告的起止时间" autocomplete="off"
                               class="layui-input layui-input-search" id="add_ste">
                    </div>
                </div>
                <div class="layui-form-item" v-show="p_id != 2">
                    <label class="layui-form-label">请选择组织机构</label>
                    <div class="layui-input-block">
                        <input type="radio" name="sex" value="0" lay-filter="dp" title="全国" v-if="p_id == 0">
                        <input type="radio" name="sex" value="1" title="省级" lay-filter="dp"
                               v-if="p_id == 0 || p_id ==1">
                        <input type="radio" name="sex" value="2" title="地市级" lay-filter="dp"
                               v-if="p_id == 0|| p_id ==1|| p_id ==2">
                    </div>
                    <div class="layui-input-block" v-show="dp_show" style="margin-top: 10px;">
                        <select name="city" xm-select="select1" xm-select-placehoder="请选择组织结构" xm-select-show-count="2"
                                xm-select-search="">
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label big_title">监管对象</label>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">企业</label>
                    <div class="layui-input-block">
                        <select name="city" xm-place-title="请选择试试" xm-select-placehoder="请选择企业" xm-select="select2"
                                xm-select-show-count="2" xm-select-search="">
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">对象数据</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="ob_type" title="转运中心" value="0">
                        <input type="checkbox" name="ob_type" title="网点" value="1">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label big_title">数据项</label>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">基础数据</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="devices_count" title="点位数量" value="1">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">视频巡检</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="ievents" value="1" title="断网">
                        <input type="checkbox" name="ievents" value="2" title="无信号">
                        <input type="checkbox" name="ievents" value="3" title="黑屏">
                        <input type="checkbox" name="ievents" value="4" title="花瓶">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">智能分析</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="aevents" title="暴力分拣" value="1">
                        <input type="checkbox" name="aevents" title="安检机未运行" value="2">
                        <input type="checkbox" name="aevents" title="安检人员不在岗" value="3">
                        <input type="checkbox" name="aevents" title="火灾" value="4">
                        <input type="checkbox" name="aevents" title="爆仓" value="5">
                        <input type="checkbox" name="aevents" title="网点是否运营" value="6">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label big_title">输出类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="type" value="0" lay-filter="out_type" title="总数据" checked>
                        <input type="radio" name="type" value="1" lay-filter="out_type" title="详细表格">
                    </div>
                </div>
                <div class="layui-form-item layui-col-md-offset3">
                    <div class="layui-input-block" style="margin-left: 0px;">
                        <button class="layui-btn layui-btn-sm" @click="addPort()">提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary layui-btn-sm" @click="PortCk(0)">返回
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="info-detail" v-show="detail_info">
        <div class="layui-row">
            <div class="layui-col-md6 layui-col-md-offset3 echartPt">
                <div id='main' class="echart"></div>
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
                dp_show: false,
                info_main: true,
                formData: {},
                region: {},
                size: 0,
                start_time: "",
                end_time: "",
                department_id: "",
                detail_info: false,
                name: "",
                add_info: false,
                laydate:null,
                form:null,
                info: {
                    name: '',
                    start_time: '',
                    end_time: '',
                    department_ids: [],
                    company_ids: '',
                    transportation_ids: '',
                    devices_count: 0,
                    aevents: '',
                    ievents: '',
                    dot_ids: ''
                },
                dvList: [],
                p_id: '{{$p_id}}',
                g_id: '{{$g_id}}',
                formSelects: null,
                myChart: null,
                out_type: 0

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
            test: function () {
                console.log($(".echartPt").width())
            },
            PortCk: function (type) {
                if (type == 0) {
                    this.add_info = false
                    this.info_main = true
                } else {
                    this.dp_show = false
                    this.start_time = ""
                    this.end_time = ""
                    this.info.name = ""
                    if(this.p_id != 2) {
                        this.info.department_ids = []
                        $("input:radio[name='sex']:checked").each(function (i, el) {
                            el.checked = false;
                        });
                        this.formSelects.data('select1', 'local', {
                            arr: []
                        });
                        this.formSelects.data('select2', 'local', {
                            arr: []
                        });
                    }else{
                        this.info.department_ids = [this.g_id]
                        //如果为市级 查询事件企业列表
                        this.$http.post("{{route('task-object')}}", {"department_ids":[this.g_id]}, {emulateJSON: true})
                            .then(function (res) {
                                if (res.body.data.length != 0) {
                                    this.formSelects.data('select2', 'local', {
                                        arr: res.body.data
                                    });
                                }
                            }, function (res) {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            });
                    }
                    $("input:checkbox[name='ievents']:checked").each(function (i,el) {
                        el.checked = false;
                    });
                    $("input:checkbox[name='aevents']:checked").each(function (i,el) {
                        el.checked = false;
                    });
                    $("input:checkbox[name='ob_type']:checked").each(function (i,el) {
                        el.checked = false;
                    });
                    $("input:radio[name='type']")[0].checked =true
                    $("input:checkbox[name='devices_count']")[0].checked =false
                    this.out_type = 0
                    $("#add_ste").val("");
                    this.laydate.render();
                    this.form.render();
                    this.add_info = true
                }
            },
            addPort: function () {
                var data = {}
                var arr_i = new Array();
                $("input:checkbox[name='ievents']:checked").each(function (i) {
                    arr_i[i] = $(this).val();
                });
                data.ievents = arr_i.join(",");
                var arr_a = new Array();
                $("input:checkbox[name='aevents']:checked").each(function (i) {
                    arr_a[i] = $(this).val();
                });
                data.aevents = arr_a.join(",");
                var arr_o = new Array();
                $("input:checkbox[name='ob_type']:checked").each(function (i) {
                    arr_o[i] = $(this).val();
                });
                data.object_ids = arr_o.join(",");
                if ($("input:checkbox[name='devices_count']:checked").length == 1) {
                    data.devices_count = 1
                } else {
                    data.devices_count = 0
                }
                data.start_time = this.info.start_time;
                data.end_time = this.info.end_time;
                data.name = this.info.name;
                data.company_ids = this.formSelects.value('select2', 'valStr');
                if (data.name == "") {
                    layer.msg("请输入报告名称");
                    return;
                }
                if (data.start_time == "" || data.end_time == "") {
                    layer.msg("请选择起止时间");
                    return;
                }
                if (this.info.department_ids.length != 0) {
                    data.department_ids = this.info.department_ids.join(',');
                } else {
                    layer.msg("请选择组织机构");
                    return;
                }
                data.type = this.out_type
                if (data.department_ids == "") {
                    layer.msg("请选择地理范围");
                    return;
                }
                if (data.company_ids == "") {
                    layer.msg("请选择企业");
                    return;
                }
                if (data.object_ids == "") {
                    layer.msg("请选择对象数据");
                    return;
                }
                if (data.devices_count == 0 && data.aevents == "" && data.ievents == "") {
                    layer.msg("请选择数据库项");
                    return;
                }
                this.$http.post("{{route('task-add')}}", data, {emulateJSON: true})
                    .then(function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str,{time:2000});
                        if (res.body.code == 0) {
                            //页面刷新
                            this.getList(1);
                            var that = this
                            setTimeout(function () {
                                that.add_info = false
                                that.info_main = true;
                            }, 2000)

                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            //判断是否是多个企业
            checkCompNum: function (str) {
                var arr = str.split(',');
                if (arr.length > 1) {
                    return true;
                }
                return false;
            },
            exportTask: function (vo) {
                layer.confirm("确认是否导出？", {title: "导出报告"}, function (index) {
                    layer.close(index);
                    if (vo['status'] != 2) {
                        layer.msg("当前报告未生成,请稍后重试");
                        return;
                    }
                    var $form = $('<form method="GET"></form>');
                    $form.attr('action', '/admin/task/export/' + vo['id']);
                    $form.appendTo($('body'));
                    $form.submit();
                    })
            },
            queryDetail: function (vo) {
                //多个企业
                if (this.checkCompNum(vo.company_ids)) {

                } else {

                }
                this.info_main = false;
                this.detail_info = true;
                this.$nextTick(function () {
                    this.drawOne();
                })
                //单个企业
            },
            setCharts: function (obj) {
                console.log(obj)
                obj.style.width = $(".echartPt").width() + 'px';
                obj.style.height = Math.round($(".echartPt").width() * 4 / 6) + 'px';
            },
            drawOne: function () {
                var div = document.getElementById('main')
                this.setCharts(div)
                this.myChart = echarts.init(div);
                app.config = {
                    rotate: 90,
                    align: 'left',
                    verticalAlign: 'middle',
                    position: 'insideBottom',
                    distance: 15,
                    onChange: function () {

                    }
                };
                var labelOption = {
                    normal: {
                        show: true,
                        position: app.config.position,
                        distance: app.config.distance,
                        align: app.config.align,
                        verticalAlign: app.config.verticalAlign,
                        rotate: app.config.rotate,
                        formatter: '{c}  {name|{a}}',
                        fontSize: 16,
                        rich: {
                            name: {
                                textBorderColor: '#fff'
                            }
                        }
                    }
                };

                var option = {
                    color: ['#003366', '#006699', '#4cabce', '#e5323e'],
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    legend: {
                        data: ['Forest', 'Steppe', 'Desert', 'Wetland']
                    },
                    toolbox: {
                        show: false,
                        orient: 'vertical',
                        left: 'right',
                        top: 'center',
                        feature: {
                            mark: {show: true},
                            dataView: {show: true, readOnly: false},
                            magicType: {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                            restore: {show: true},
                            saveAsImage: {show: true}
                        }
                    },
                    calculable: true,
                    xAxis: [
                        {
                            type: 'category',
                            axisTick: {show: false},
                            data: ['2012', '2013', '2014', '2015', '2016']
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value'
                        }
                    ],
                    series: [
                        {
                            name: 'Forest',
                            type: 'bar',
                            barGap: 0,
                            label: labelOption,
                            data: [320, 332, 301, 334, 390]
                        },
                        {
                            name: 'Steppe',
                            type: 'bar',
                            label: labelOption,
                            data: [220, 182, 191, 234, 290]
                        },
                        {
                            name: 'Desert',
                            type: 'bar',
                            label: labelOption,
                            data: [150, 232, 201, 154, 190]
                        },
                        {
                            name: 'Wetland',
                            type: 'bar',
                            label: labelOption,
                            data: [98, 77, 101, 99, 40]
                        }
                    ]
                };
                this.myChart.setOption(option);
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
                that.laydate = layui.laydate;
                 that.form = layui.form;
                that.formSelects = layui.formSelects;
                that.formSelects.on('select1', function (id, vals, val, isAdd, isDisabled) {
                    //id:           点击select的id
                    //vals:         当前select已选中的值
                    //val:          当前select点击的值
                    //isAdd:        当前操作选中or取消
                    //isDisabled:   当前选项是否是disabled
                    var data = []
                    for (var i in vals) {
                        data.push(vals[i].value)
                    }
                    that.info.department_ids = data
                }, true);
                that.formSelects.closed('select1', function () {
                    that.$http.post("{{route('task-object')}}", {"department_ids": that.info.department_ids}, {emulateJSON: true})
                        .then(function (res) {
                            if (res.body.data.length != 0) {
                                that.formSelects.data('select2', 'local', {
                                    arr: res.body.data
                                });
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        });
                });
                //组织选择
                that.form.on('radio(dp)', function (data) {
                    if (data.value == 0) {
                        that.dp_show = false
                        that.info.department_ids = [1]
                        that.$http.post("{{route('task-object')}}", {"department_ids": [1]}, {emulateJSON: true})
                            .then(function (res) {
                                if (res.body.data.length != 0) {
                                    that.formSelects.data('select2', 'local', {
                                        arr: res.body.data
                                    });
                                }
                            }, function (res) {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            });
                    } else {
                        that.$http.post("{{route('task-department')}}", {"type": data.value}, {emulateJSON: true})
                            .then(function (res) {
                                if (res.body.data.length != 0) {
                                    that.formSelects.data('select1', 'local', {
                                        arr: res.body.data
                                    });
                                }
                            }, function (res) {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            });
                        that.dp_show = true
                    }
                });
                that.form.on('radio(out_type)', function (data) {
                    that.out_type = data.value
                })
                that.laydate.render({
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
                that.laydate.render({
                    elem: '#add_ste'
                    , type: 'datetime'
                    , range: '~'
                    , format: 'yyyy-MM-dd'
                    , max: new Date().toLocaleString()
                    , done: function (value) {
                        var time = value.split(' ~ ');
                        that.info.start_time = time[0];
                        that.info.end_time = time[1];
                    }
                });
                that.form.render();
            });
        }
    });
</script>
</body>
</html>