<html>
<head>
    <meta charset="utf-8">
    @if( asset('admin/supervise/model') == url()->current() )
        <title>监管模型配置</title>
    @elseif( asset('admin/supervise/time') == url()->current() )
        <title>监管时间配置</title>
    @endif
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
    .layui-fluid input {
        width: 60px;
        border-bottom: #7950ff 1px solid;
        border-left-width: 0px;
        border-right-width: 0px;
        border-top-width: 0px;
        margin: 0 10px;
    }

    .body-block {
        font-size: 14px;
        text-align: left;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .block-left {
        border: 1px solid #f6f6f6;
        height: 90%;
        width: 49.5%;
        float: left;
        margin-bottom: 10px;
    }

    .block-right {
        border: 1px solid #f6f6f6;
        height: 90%;
        width: 49.5%;
        float: right;
    }

    .block-title {
        font-weight: bold;
        float: left;
        margin-left: 20px;
        margin-top: 20px;
    }

    .block-notice {
        float: left;
        font-size: 13px;
        color: #a0a0a0;
        margin-left: 10px;
        margin-top: 30px;
    }

    .synch-notice {
        width: 80%;
        font-size: 13px;
        color: #a0a0a0;
        float: left;
        margin: 30px;
    }

    .block-button {
        position: absolute;
        right: 3%;
        bottom: 3%;
    }

    .block-time {
        position: absolute;
        margin-top: 60px;
        width: 100%;
        height: 70%;
    }

    .block-box {
        cursor: pointer;
        float: left;
        border: 1px solid dodgerblue;
        margin: 10px;
        color: dodgerblue;
        width: 25%;
        height: 30px;
    }

    .block-box-left {
        float: left;
        line-height: 30px;
        margin-left: 20px;
    }

    .block-box-right {
        float: right;
        line-height: 30px;
        margin-right: 20px;
        font-size: 16px;
    }

    .layui-laydate-content > .layui-laydate-list {
        padding-bottom: 0px;
        overflow: hidden;
    }

    .layui-laydate-content > .layui-laydate-list > li {
        width: 50%
    }

    .merge-box .scrollbox .merge-list {
        padding-bottom: 5px;
    }

    .time-select {
        text-align: center;
        width: 300px;
        height: 100px;
        line-height: 100px
    }
</style>
<body layadmin-themealias="default">
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
@if( asset('admin/supervise/model') == url()->current() )
    <div id="app" class="layui-fluid">
        <div class="layui-row m-lr20" v-show="list_supervise">
            <div class="layui-col-md12" style="margin-top: 20px">
                <table class="layui-table text-center" lay-size="sm">
                    <thead>
                    <tr>
                        <th style="width: 48px;">#</th>
                        <th>
                            <div class="text-left">模型名称</div>
                        </th>
                        <th>
                            <div class="text-left">状态</div>
                        </th>
                        <th>
                            <div class="text-left">修改时间</div>
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(vo,id) in formData">
                        <td v-text="id+1+size">
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['models']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-if="vo['updated_at']" style='color:green'>
                                已配置
                            </div>
                            <div class="text-left" v-else style='color:orangered'>未配置</div>
                        </td>
                        <td v-text="vo['updated_at']"></td>
                        <td>
                            <button type="button" class="layui-btn layui-btn-xs" title=""
                                    @click="queryDetail(vo['id'])">配置
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="info-detail" v-show="edit_supervise">
            <div class="layui-fluid" style="margin: 0px">
                <div class="layui-row top">
                    <div class="layui-col-md6">
                        模型配置
                    </div>
                    <div class="layui-col-md6 top-right">
                        <a @click="goBack(0)">返回</a>
                    </div>
                </div>
                <div class="layui-row main">
                    <div class="layui-col-md12">
                        <div class="layui-form-item" style="margin-top: 10px">
                            <label class="layui-form-label">模型名称</label>
                            <div class="layui-input-block" v-text="data.models" style="line-height: 40px;"></div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-form-label">触发条件</div>
                            <div class="layui-input-block" style="line-height: 40px;">
                                <span v-if="data.type == 2">
                                    单次抓拍画面内包裹数量占据画面达到
                                    <input type="text" name="area" placeholder="面积" autocomplete="off"
                                           :value="data.area" width="100px">
                                    % （50% ~ 100%）即判定为发生了一次爆仓事件；<br/>
                                </span>
                                在<input type="number" name="e_hour" placeholder="请输入时间" autocomplete="off"
                                        :value="data.e_hour" title="请输入时间">
                                小时（0.1 ~ 24）内，系统判定某监控画面内出现<span v-if="data.type == 0">上述4种</span>@{{ data.models
                                }}行为累计达到
                                <input type="number" name="e_count" placeholder="请输入次数" autocomplete="off"
                                       :value="data.e_count" title="请输入次数">
                                次（1 ~ 1000）即触发告警
                            </div>
                        </div>
                        <div class="layui-form-item layui-col-sm-offset1" style="margin-top: 50px">
                            <button type="button" class="layui-btn layui-btn-sm"
                                    @click="update(data.pid?data.pid:data.id)">
                                保存
                            </button>
                            <button type="button" class="layui-btn layui-btn-sm layui-btn-warm"
                                    @click="delModel(data.pid?data.id:'')">
                                关闭模型
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif( asset('admin/supervise/time') == url()->current() )
    <div id="app" class="layui-card m-lr20" style="margin-top: 20px;overflow-y: hidden;">
        <div class="layui-row">
            <div class="layui-card-header">监管时间配置</div>
            <div class="layui-card-body">
                <div class="layui-row body-block">
                    <div class="layui-col-md6 block-left">
                        <div class="block-title">转运中心工作时间</div>
                        <div class="block-notice">工作时间段不能重复存在，且24小时内</div>
                        <div class="block-time">
                            <div class="block-box" v-for="(vo,id) in timesList" v-if="vo['type'] == 0">
                                <p class="block-box-left">@{{ vo['start_time'] }} ~ @{{ vo['end_time'] }}</p>
                                <p class="block-box-right" @click="removeTime($event,vo['id'])">X</p>
                            </div>
                        </div>
                        <div class="block-button">
                            <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" @click="synch(0)">同步
                            </button>
                            <button type="button" class="layui-btn layui-btn-sm" @click="addTime(0)">添加</button>
                        </div>
                    </div>
                    <div class="layui-col-md6 block-right">
                        <div class="block-title">网点工作时间</div>
                        <div class="block-notice">工作时间段不能重复存在，且24小时内</div>
                        <div class="block-time">
                            <div class="block-box" v-for="(vo,id) in timesList" v-if="vo['type'] == 1">
                                <p class="block-box-left">@{{ vo['start_time'] }} ~ @{{ vo['end_time'] }}</p>
                                <p class="block-box-right" @click="removeTime($event,vo['id'])">X</p>
                            </div>
                        </div>
                        <div class="block-button">
                            <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" @click="synch(1)">同步
                            </button>
                            <button type="button" class="layui-btn layui-btn-sm" @click="addTime(1)">添加</button>
                        </div>
                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>
            <div class="layui-card-footer"
                 style="height: 35px;background-color: #FFFFFF;border: 1px solid #f6f6f6;"></div>
        </div>
    </div>
@endif
{{--<script src="/static/layuiadmin/layer.js"></script>--}}
<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>


<!-- 百度统计 -->
<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                formData: {
                    models: '',
                    updated_at: '',
                    dataId: '',
                },
                size: 0,
                data: {},
                timesList: {},
                list_supervise: true,
                edit_supervise: false,
            }
        },
        methods: {
            getList: function () {
                this.$http.post('/admin/supervise/model', {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.formData = res.body.data;
                            $("#load_gif").hide()
                            $("#app").css('display', 'block');
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
                this.$http.get('/admin/supervise/model/update/' + id, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.data = res.body.data;
                                this.edit_supervise = true;
                                this.list_supervise = false;
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
            update: function (id) {
                var data = {};
                var e_hour = $("[name='e_hour']").val();
                if (e_hour < 0.1) {
                    layer.msg("有效时间不能小于0.1小时");
                    $("[name='e_hour']").val('')
                    return false;
                } else if (e_hour > 24) {
                    layer.msg("有效时间不能超过24小时");
                    $("[name='e_hour']").val('')
                    return false;
                } else if (!/^[0-9]+.?[0-9]*$/.test(e_hour)) {
                    layer.msg("请输入有效时间");
                    $("[name='e_hour']").val('')
                    return false;
                }
                var e_count = $("[name='e_count']").val();
                if (!/^[1-9]+[0-9]*]*$/.test(e_count)) {
                    layer.msg("请输入有效次数");
                    $("[name='e_count']").val('');
                    return false;
                } else if (e_count > 1000) {
                    layer.msg("有效次数不能大于1000");
                    $("[name='e_count']").val('');
                    return false;
                }
                var area = $("[name='area']").val();
                if (this.data.type == 2) {
                    if (!/^[0-9]+.?[0-9]*$/.test(area)) {
                        layer.msg("请输入有效面积");
                        $("[name='area']").val('');
                        return false;
                    }
                    if (area < 100 && area > 50) {
                        data.area = area;
                    } else {
                        layer.msg("面积占比大于50%且小于100%，请输入有效面积");
                        $("[name='area']").val('');
                        return false;
                    }
                }
                data.e_hour = e_hour;
                data.e_count = e_count;
                this.$http.post('/admin/supervise/model/update/' + id, data, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            var str = lea.msg(res.body.msg);
                            var that = this;
                            layer.msg(str, {time: 2000});
                            that.getList();
                            setTimeout(function () {
                                that.goBack();
                            }, 2000)
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            removeTime: function ($event, id) {
                this.$http.post('/admin/supervise/time/delete/' + id, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            var str = lea.msg(res.body.msg) || '删除成功';
                            layer.msg(str);
                            this.timeList();
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            addTime: function (type) {
                var that = this;
                layui.use('layer', function () {
                    var layer = layui.layer;
                    layer.open({
                        type: 1,
                        area: 'auto',
                        title: '工作时间段',
                        content: '<div class="time-select">' +
                            '<select name="timeStart" class="layui-select">\n' +
                            '<option value="">开始时间</option>\n' +
                            '<option value="00:00">00:00</option>\n' + '<option value="00:30">00:30</option>\n' +
                            '<option value="01:00">01:00</option>\n' + '<option value="01:30">01:30</option>\n' +
                            '<option value="02:00">02:00</option>\n' + '<option value="02:30">02:30</option>\n' +
                            '<option value="03:00">03:00</option>\n' + '<option value="03:30">03:30</option>\n' +
                            '<option value="04:00">04:00</option>\n' + '<option value="04:30">04:30</option>\n' +
                            '<option value="05:00">05:00</option>\n' + '<option value="05:30">05:30</option>\n' +
                            '<option value="06:00">06:00</option>\n' + '<option value="06:30">06:30</option>\n' +
                            '<option value="07:00">07:00</option>\n' + '<option value="07:30">07:30</option>\n' +
                            '<option value="08:00">08:00</option>\n' + '<option value="08:30">08:30</option>\n' +
                            '<option value="09:00">09:00</option>\n' + '<option value="09:30">09:30</option>\n' +
                            '<option value="10:00">10:00</option>\n' + '<option value="10:30">10:30</option>\n' +
                            '<option value="11:00">11:00</option>\n' + '<option value="11:30">11:30</option>\n' +
                            '<option value="12:00">12:00</option>\n' + '<option value="12:30">12:30</option>\n' +
                            '<option value="13:00">13:00</option>\n' + '<option value="13:30">13:30</option>\n' +
                            '<option value="14:00">14:00</option>\n' + '<option value="14:30">14:30</option>\n' +
                            '<option value="15:00">15:00</option>\n' + '<option value="15:30">15:30</option>\n' +
                            '<option value="16:00">16:00</option>\n' + '<option value="16:30">16:30</option>\n' +
                            '<option value="17:00">17:00</option>\n' + '<option value="17:30">17:30</option>\n' +
                            '<option value="18:00">18:00</option>\n' + '<option value="18:30">18:30</option>\n' +
                            '<option value="19:00">19:00</option>\n' + '<option value="19:30">19:30</option>\n' +
                            '<option value="20:00">20:00</option>\n' + '<option value="20:30">20:30</option>\n' +
                            '<option value="21:00">21:00</option>\n' + '<option value="21:30">21:30</option>\n' +
                            '<option value="22:00">22:00</option>\n' + '<option value="22:30">22:30</option>\n' +
                            '<option value="23:00">23:00</option>\n' + '<option value="23:30">23:30</option>\n' +
                            '</select> 至 ' +
                            '<select name="timeEnd" class="layui-select">\n' +
                            '<option value="">结束时间</option>\n' +
                            '<option value="00:00">00:00</option>\n' + '<option value="00:30">00:30</option>\n' +
                            '<option value="01:00">01:00</option>\n' + '<option value="01:30">01:30</option>\n' +
                            '<option value="02:00">02:00</option>\n' + '<option value="02:30">02:30</option>\n' +
                            '<option value="03:00">03:00</option>\n' + '<option value="03:30">03:30</option>\n' +
                            '<option value="04:00">04:00</option>\n' + '<option value="04:30">04:30</option>\n' +
                            '<option value="05:00">05:00</option>\n' + '<option value="05:30">05:30</option>\n' +
                            '<option value="06:00">06:00</option>\n' + '<option value="06:30">06:30</option>\n' +
                            '<option value="07:00">07:00</option>\n' + '<option value="07:30">07:30</option>\n' +
                            '<option value="08:00">08:00</option>\n' + '<option value="08:30">08:30</option>\n' +
                            '<option value="09:00">09:00</option>\n' + '<option value="09:30">09:30</option>\n' +
                            '<option value="10:00">10:00</option>\n' + '<option value="10:30">10:30</option>\n' +
                            '<option value="11:00">11:00</option>\n' + '<option value="11:30">11:30</option>\n' +
                            '<option value="12:00">12:00</option>\n' + '<option value="12:30">12:30</option>\n' +
                            '<option value="13:00">13:00</option>\n' + '<option value="13:30">13:30</option>\n' +
                            '<option value="14:00">14:00</option>\n' + '<option value="14:30">14:30</option>\n' +
                            '<option value="15:00">15:00</option>\n' + '<option value="15:30">15:30</option>\n' +
                            '<option value="16:00">16:00</option>\n' + '<option value="16:30">16:30</option>\n' +
                            '<option value="17:00">17:00</option>\n' + '<option value="17:30">17:30</option>\n' +
                            '<option value="18:00">18:00</option>\n' + '<option value="18:30">18:30</option>\n' +
                            '<option value="19:00">19:00</option>\n' + '<option value="19:30">19:30</option>\n' +
                            '<option value="20:00">20:00</option>\n' + '<option value="20:30">20:30</option>\n' +
                            '<option value="21:00">21:00</option>\n' + '<option value="21:30">21:30</option>\n' +
                            '<option value="22:00">22:00</option>\n' + '<option value="22:30">22:30</option>\n' +
                            '<option value="23:00">23:00</option>\n' + '<option value="23:30">23:30</option>\n' +
                            '</select></div>',
                        btn: '添加',
                        btnAlign: 'c', //按钮居中
                        shade: 0.1, //不显示遮罩
                        yes: function () {
                            var startTime = $("select[name='timeStart']").val();
                            var endTime = $("select[name='timeEnd']").val();
                            if (startTime >= endTime) {
                                var str = '结束时间不能小于开始时间';
                                layer.msg(str, {time: 1000});
                                return false;
                            } else if (!startTime || !endTime) {
                                var str = '工作时间不能为空';
                                layer.msg(str, {time: 1000});
                                return false;
                            }

                            that.$http.post('/admin/supervise/time/add', {
                                start_time: startTime,
                                end_time: endTime,
                                type: type
                            }, {emulateJSON: true})
                                .then(function (res) {
                                    if (res.body.code == 0) {
                                        var str = lea.msg(res.body.msg) || '添加成功';
                                        layer.msg(str);
                                        that.timeList();
                                    } else {
                                        var str = lea.msg(res.body.msg) || '服务器异常';
                                        layer.msg(str);
                                    }
                                }, function (res) {
                                    var str = lea.msg(res.body.msg) || '服务器异常';
                                    layer.msg(str);
                                });
                            layer.closeAll();

                        }
                    });
                });
            },
            timeList: function () {
                this.$http.post('/admin/supervise/time', {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.timesList = res.body.data;
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            synch: function (type) {
                var that = this;
                layui.use('layer', function () {
                    var layer = layui.layer;
                    layer.open({
                        type: 1,
                        area: 'auto',
                        title: '同步时间',
                        content: `<div class="synch-notice">确定将时间同步至转运中心/网点,已设置的时间将被覆盖</div>`,
                        btn: ['确定', '取消'],
                        btnAlign: 'c', //按钮居中
                        shade: 0.1, //不显示遮罩
                        yes: function () {
                            layer.closeAll();
                            layer.load(2, {
                                content: '同步中',
                                shade: [0.3, '#393D49'],
                                success: function (layero) {
                                    layero.find('.layui-layer-loading2').css('padding-top', '40px');
                                    layero.find('.layui-layer-loading2').css('width', '100px');
                                }
                            })
                            that.$http.post('/admin/supervise/time/sync', {type: type}, {emulateJSON: true})
                                .then(function (res) {
                                    layer.closeAll();
                                    if (res.body.code == 0) {
                                        var str = lea.msg(res.body.msg) || '同步成功';
                                        layer.msg(str);
                                    } else {
                                        var str = lea.msg(res.body.msg) || '服务器异常';
                                        layer.msg(str);
                                    }
                                }, function (res) {
                                    var str = lea.msg(res.body.msg) || '服务器异常';
                                    layer.msg(str);
                                });
                        }
                    });
                })
            },
            delModel: function (id) {
                var that = this;
                layui.use('layer', function () {
                    var layer = layui.layer;
                    layer.open({
                        type: 1,
                        area: 'auto',
                        title: '关闭模型',
                        content: `<div class="synch-notice">确定关闭该模型配置吗？</div>`,
                        btn: ['确定', '取消'],
                        btnAlign: 'c', //按钮居中
                        offset: 'auto',
                        shade: 0.1, //不显示遮罩
                        yes: function () {
                            layer.closeAll();
                            if (!id) {
                                layer.msg('尚未配置关闭失败', {time: 2000});
                                return false;
                            }
                            that.$http.post('/admin/supervise/model/delete/' + id, {emulateJSON: true})
                                .then(function (res) {
                                    layer.closeAll();
                                    if (res.body.code == 0) {
                                        var str = lea.msg(res.body.msg) || '关闭成功';
                                        layer.msg(str, {time: 2000});
                                        that.getList();
                                        setTimeout(function () {
                                            that.goBack();
                                        }, 2000)
                                    } else {
                                        var str = lea.msg(res.body.msg) || '关闭失败';
                                        layer.msg(str);
                                    }
                                }, function (res) {
                                    var str = lea.msg(res.body.msg) || '服务器异常';
                                    layer.msg(str);
                                });
                        }
                    });
                })
            },
            goBack: function () {
                this.edit_supervise = false;
                this.list_supervise = true;
            }

        },
        mounted: function () {
            this.getList();
            this.timeList();
        }
    });
</script>

</body>
</html>