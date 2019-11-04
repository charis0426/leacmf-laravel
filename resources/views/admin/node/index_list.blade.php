<html>
<head>
    <meta charset="utf-8">
    <title>节点列表</title>
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
<body layadmin-themealias="default">
<style>
    .layui-form-label {
        width: 60px !important;
        text-align: right;
        padding-right: 10px;
    }
    .field-title legend{
        font-size: 16px;
        color: #000000;
        font-weight: 400;
    }
    .layui-input-block span{
        line-height: 40px;
    }
    .info-detail .layui-input-block{
        margin-left: 100px !important;
    }
    .field-title .layui-field-box{
        height: calc(100% - 32px) !important;
        height: -moz-calc(100% - 32px) !important;
        height: -webkit-calc(100% - 32px)!important;    }
    .field-title .layui-field-box .cavp,.field-title .layui-field-box .cavp .echart{
        height: 100%;
    }
    .yuanzhu{    height: 100%;position: relative; width: 100px; border:1px solid #a2a2a2; background:#cdcdcd;margin:10px auto; z-index: 999  }
    .yuanzhu:before{position: absolute; border:1px solid #a2a2a2;top:-14px; content: ""; left:-1px;display: block; width: 100px; height: 30px; border-radius:50%; background: #cdcdcd;  z-index: 99}
    .yuanzhu:after{position: absolute; bottom:-14px; content: "";border:1px solid #a2a2a2;display: block; left:-1px;width: 100px; height: 30px; border-radius:50%; background: #cdcdcd; z-index: 9 }
    .yuanzhu1{       border-top: none !important; display:none;margin-top:-24px !important;border:1px solid #a2a2a2;position: relative; width: 100px;  background:#009966;margin:10px auto; z-index: 999  }
    .yuanzhu1:before{position: absolute;top:-14px;border:1px solid #a2a2a2;content: ""; display: block; left:-1px;width: 100px; height: 30px; background: #009966; border-radius:50%; z-index: 99}
    .yuanzhu1:after{position: absolute;border:1px solid #009966; bottom:-14px; content: ""; left:-1px;display: block; width: 100px; height: 30px; border-radius:50%; background: #009966; z-index: 9 }
    .cx{
        position: relative;
        width: 150px;
        float: left;
        height: 20px;
        border-top:1px solid #555;
        border-left: 1px solid #555;
    }
    .cx .cd{
        position: relative;
        float: left;
        width: 29px;
        height: 10px;
        border-right: 1px solid #555;
    }
    .cx .cd:after{
        position: absolute;
        bottom: -20px;
        font: 11px/1 sans-serif;
    }
    .cx1 .cd:nth-of-type(1):after {
        content: "0%";
    }
    .cx2 .cd:nth-of-type(1):after {
        content: "50%";
    }
    .cx2 .cd:nth-of-type(5):after {
        content: "100%";
        right: -20px;
    }
    .cl{
        position: relative;
        float:left;
        height: 20px;
    }
    .cc{
        min-width: 312px;
        position: absolute;
        height: 100%;
        top: 30%;
    }
    .triangle-down {
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-top: 20px solid red;
        margin-left: -10px;
    }
    .triangle{
        position: absolute;
        top:-30px;
        z-index: 10000;
    }
    .cavp .disk_zhu{
        height: calc(100% - 50px) !important;
        height: -moz-calc(100% - 50px) !important;
        height: -webkit-calc(100% - 50px)!important;
    }
    .info-detail .main{
        padding: 0px;
        margin: 20px;
    }
    .layui-progress{
        width: 80px;
        margin-right: 50px;
    }
    .jindu-text{
        float: right;
        height: 20px;
        width: 43px;
        margin-top: -6px;
    }
</style>
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div v-show="info_main">
        <div class="layui-row layui-form">
            <div class="layui-inline layui-form-serch">
                <label class="layui-form-label">节点状态</label>
                <div class="layui-input-inline">
                    <select lay-filter="nodeStatus">
                        <option value="">全部</option>
                        <option value="0">正常</option>
                        <option value="1">异常</option>
                        <option value="2">升级中</option>
                    </select>
                </div>
            </div>
            <div class="layui-inline layui-form-serch">
                <label class="layui-form-label">组织机构</label>
                <div class="layui-input-inline">
                    <select name="modules"  id="selectData" lay-filter="selectData" placeholder="请选择组织机构" lay-verify="" lay-search>
                    </select>
                </div>
            </div>
            <div class="layui-input-inline">
                <button class="layui-btn layui-btn-normal layui-btn-sm" @click="getList(1)">
                    <i class="layui-icon">&#xe615;</i>搜索
                </button>
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
                        <colgroup>
                            <col width="20">
                            <col width="100">
                            <col width="100">
                            <col width="50">
                            <col>
                        </colgroup>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <div class="text-left">IP地址</div>
                            </th>
                            <th>
                                <div class="text-left">版本</div>
                            </th>
                            <th>
                                <div class="text-left">状态</div>
                            </th>
                            <th class="text-left">
                                所属机构
                            </th>
                            <th>
                            <div class="text-left">CPU使用情况</div>
                            </th>
                            <th>
                                <div class="text-left">磁盘使用情况</div>
                            </th>
                            <th>
                                <div class="text-left">内存使用情况</div>
                            </th>
                            <td>
                                <div class="text-left">资源监控</div>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(vo,id) in formData">
                            <td v-text="id+1+size">
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['ip']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['versions']"></div>
                            </td>
                            <td>
                                <div class="text-left">
                                    <span style="color:#009688" v-if="vo['status'] == 0">正常</span>
                                    <span style="color:#FF5722" v-if="vo['status'] == 1">异常</span>
                                    <span style="color:#1E9FFF" v-if="vo['status'] == 2">升级中</span>
                                </div>
                            </td>
                            <td v-text="vo['name']"></td>
                            <td>
                                <span class="jindu-text"  v-text="backUseInfo(vo['cpu_use'],'0')"></span>
                            <div class="layui-progress">
                            <div class="layui-progress-bar"  style="background-color:#009688":lay-percent="backUseInfo(vo['cpu_use'],'0')">
                            </div>
                            </div>
                            </td>
                            <td>
                                <span class="jindu-text" v-text="backUseInfo(vo['disk_use'],'')"></span>
                                <div class="layui-progress">
                                    <div class="layui-progress-bar" style="background-color:#FFB800" :lay-percent="backUseInfo(vo['disk_use'],'')">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span  class="jindu-text" v-text="backUseInfo(vo['mem_use'],'')"></span>
                                <div class="layui-progress">
                                    <div class="layui-progress-bar" style="background-color: #FF5722" :lay-percent="backUseInfo(vo['mem_use'],'')">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button class="layui-btn layui-btn-xs" title=""
                                        @click="source(vo)">资源监控
                                </button>
                                <button class="layui-btn layui-btn-normal layui-btn-xs" title=""
                                        @click="sshCmd(vo['id'])">远程维护
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
            <div class="layui-col-md6">
                资源监控
            </div>
            <div class="layui-col-md6 top-right">
                <a @click="goBack(0)">返回</a>
            </div>
        </div>
        <div class="layui-row main layui-col-space20" style="padding-bottom: 0px;height: calc(100% - 91px);height: -moz-calc(100% - 91px);height: -webkit-calc(100% - 91px);">
            <div class="layui-col-md3" style="height:100%">
                <fieldset class="layui-elem-field field-title" style="height:100%">
                    <legend>基本信息</legend>
                    <div class="layui-field-box">
                        <div class="layui-form-item">
                            <label class="layui-form-label">IP地址</label>
                            <div class="layui-input-block">
                                <span v-text="info.ip"></span>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">当前版本</label>
                            <div class="layui-input-block">
                                <span v-text="info.versions"></span>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">当前状态</label>
                            <div class="layui-input-block">
                                <span v-if="info.status == 0">
                                    <span class="icon iconfont" style="color:#5FB878;font-size: 20px;margin-right: 5px;">&#xe70f;</span>正常
                                </span>
                                <span v-if="info.status == 1">
                                    <span class="icon iconfont" style="color:#FF0000;font-size: 20px;margin-right: 5px;">&#xe6c1;</span> 异常
                                </span>
                                <span v-if="info.status == 2">
                                    <span class="icon iconfont" style="font-size: 20px;margin-right: 5px;">&#xe6e7;</span>升级中
                                </span>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">所属结构</label>
                            <div class="layui-input-block">
                                <span v-text="info.name"></span>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">所在位置</label>
                            <div class="layui-input-block">
                                <span v-text="info.position"></span>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="layui-col-md9" style="height: calc(100% - 20px);height: -moz-calc(100% - 20px);height: -webkit-calc(100% - 20px);">
                <fieldset class="layui-elem-field field-title" style="height: 33%;">
                    <legend>CPU检测</legend>
                    <div class="layui-field-box">
                        <div class="layui-col-md4 cavp">
                            <div class="cc">
                                <div class="triangle">
                                    <p v-text="cpu_use"></p>
                                    <div class="triangle-down"></div>
                                </div>
                                <div style="width: 100%;height: 20px;">
                                    <div class="cl" style="width:120px;background: #55a532; "></div>
                                    <div class="cl" style="width:62px;background: #0000FF; "></div>
                                    <div class="cl" style="width:60px;background:#ee9900;"></div>
                                    <div class="cl" style="width:61px;background: #ff0000;"></div>
                                </div>
                                <div class="cx cx1">
                                    <div class="cd"></div>
                                    <div class="cd"></div>
                                    <div class="cd"></div>
                                    <div class="cd"></div>
                                    <div class="cd" style="border-right: none;"></div>
                                </div>
                                <div class="cx cx2" style=" border-right: 1px solid #555;">
                                    <div class="cd"></div>
                                    <div class="cd"></div>
                                    <div class="cd"></div>
                                    <div class="cd"></div>
                                    <div class="cd" style="border-right: none;"></div>
                                </div>
                                <div style="text-align: center;margin-top: 70px;"> CPU使用率@{{cpu_use}}</div>
                            </div>
                        </div>
                        <div class="layui-col-md8 cavp">
                            <div id='cpu_2' class="echart"></div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="layui-elem-field field-title" style="height: 33%;">
                    <legend>内存监测</legend>
                    <div class="layui-field-box">
                        <div class="layui-col-md4 cavp">
                            <div id='mem_1' class="echart"></div>
                        </div>
                        <div class="layui-col-md8 cavp">
                            <div id='mem_2' class="echart"></div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="layui-elem-field field-title" style="height: 33%;">
                    <legend>磁盘监测</legend>
                    <div class="layui-field-box">
                        <div class="layui-col-md4 cavp">
                            <div class="disk_zhu">
                                <div class="yuanzhu"></div>
                                <div class="yuanzhu1"></div>
                            </div>
                            <p style="text-align: center">使用率：@{{disk_info['percent']}}%</p>
                            <p style="text-align: center">总计：@{{disk_info['total']}}G</p>
                        </div>
                        <div class="layui-col-md8 cavp">
                            <div id='disk_2' class="echart"></div>
                        </div>
                    </div>
                </fieldset>
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
<script src="/static/admin/plugins/font/iconfont.js"></script>
<script src="/static/layuiadmin/echarts.js"></script>

<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                formData: {},
                size: 0,
                department_id: "",
                name: "",
                status: '',
                ip: '',
                info_main: true,
                info: {},
                myChart_cpu: null,
                myChart_mem: null,
                myChart_disk: null,
                myChart_mem_1:null,
                detail_info:false,
                isFirst:0,
                cpu_data:[0,0,0,0,0],
                mem_data:[0,0,0,0,0],
                disk_data:[0,0,0,0,0],
                setTime:null,
                form:null,
                selectData:[],
                cpu_use:'0%',
                disk_info:{
                    total:0,
                    percent:0
                },
                color: {cpu_2:"#009688",
                    mem_2:"#1E9FFF",
                    disk_2:"#FF5722"
                }
            }
        },
        methods: {
            sshCmd:function(id){
                this.$http.post('/admin/node/sshcmd',{"NodeId":parseInt(id)}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                layer.msg("维护成功");
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
            backUseInfo:function(value,type){
              if(value.split(',').length != 5){
                  return '0%';
              }else{
                  if(type == '0'){
                      return value.split(',')[4]+"%";
                  }else{
                      var str = value.split(',')[4];
                      return str.split('_')[0]+"%";
                  }
              }
            },
            formatDate:function(date) {
                // 获取年月日时分秒值  slice(-2)过滤掉大于10日期前面的0
                var datetime = new Date(date);
                var year = datetime.getFullYear(),
                    month = ("0" + (datetime.getMonth() + 1)).slice(-2),
                    date = ("0" + datetime.getDate()).slice(-2),
                    hour = ("0" + datetime.getHours()).slice(-2),
                    minute = ("0" + datetime.getMinutes()).slice(-2),
                    second = ("0" + datetime.getSeconds()).slice(-2);
                // 拼接
                var result = hour +":"+ minute +":" + second;
                // 返回
                return result;
            },
            getSysInfo:function(id){
                this.$http.post('/admin/node/use/' + id, {}, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                var cpu = res.body.data.cpu_use.split(',')
                                var mem = res.body.data.mem_use.split(',')
                                var disk = res.body.data.disk_use.split(',')
                                var time  = Date.parse(new Date());
                                if(this.isFirst == 0){
                                    this.cpu_data = []
                                    this.mem_data = []
                                    this.disk_data = []
                                    for(var i in cpu){
                                        var arr =  new Array();
                                        arr[0] = time - (cpu.length-i) * 1000;
                                        arr[1] = cpu[i]
                                        this.cpu_data.push(arr)
                                    }
                                    for(var i in mem){
                                        var arr =  new Array();
                                        arr[0] = time - (mem.length-i) * 1000;
                                        arr[1] = mem[i].split('_')[0]
                                        this.mem_data.push(arr)
                                    }
                                    for(var i in disk){
                                        var arr =  new Array();
                                        arr[0] = time - (disk.length-i) * 1000;
                                        arr[1] = disk[i].split('_')[0]
                                        this.disk_data.push(arr)
                                    }
                                    this.canvas('cpu_2',this.cpu_data,this.myChart_cpu)
                                    this.canvas('mem_2',this.mem_data,this.myChart_mem)
                                    this.canvas('disk_2',this.disk_data,this.myChart_disk)
                                    var data={"total":mem[4].split('_')[1],'percent':mem[4].split('_')[0]}
                                    this.memUse(data)
                                    this.isFirst = 1
                                }else{
                                    this.cpu_data.shift();
                                    this.mem_data.shift();
                                    this.disk_data.shift();
                                    this.cpu_data.push([time, cpu[4]])
                                    this.mem_data.push([time, mem[4].split('_')[0]])
                                    this.disk_data.push([time, disk[4].split('_')[0]])
                                    this.myChart_cpu.setOption({
                                        series: [{
                                            data: this.cpu_data
                                        }]
                                    });
                                    this.myChart_mem.setOption({
                                        series: [{
                                            data: this.mem_data
                                        }]
                                    });
                                    this.myChart_disk.setOption({
                                        series: [{
                                            data: this.disk_data
                                        }]
                                    });
                                    this.myChart_mem_1.setOption({
                                        series: [{
                                            data:[{value:mem[4].split('_')[0]}],
                                            detail: {
                                                formatter: function (value) {
                                                    return "总内存:"+mem[4].split('_')[1]+"M\n"+"内存使用率:"+value+"%";
                                                },
                                            },
                                        }]
                                    })
                                }
                                if(disk[4].split('_')[0]>0) {
                                    $(".yuanzhu1").css('height', (disk[4].split('_')[0]) + "%");
                                    $(".yuanzhu").css('height', (100 - disk[4].split('_')[0]) + "%");
                                    $(".yuanzhu1").show();
                                }else{
                                    $(".yuanzhu").css('height',  "100%");
                                    $(".yuanzhu1").hide();
                                }
                                this.disk_info.total = disk[4].split('_')[1]
                                this.disk_info.percent = disk[4].split('_')[0]
                                var cpu_use = cpu[4].split('_')[0]
                                this.cpu_use = cpu_use+"%"
                                if(cpu_use >=0 && cpu_use<=40){
                                    $(".triangle-down").css('margin-left',((120*cpu_use)/40-10).toFixed(2)+"px")
                                }else if(cpu_use >40 && cpu_use<=60){
                                    $(".triangle-down").css('margin-left',((62*cpu_use)/20-10).toFixed(2)+"px")
                                }else if(cpu_use >60 && cpu_use<=80){
                                    $(".triangle-down").css('margin-left',((60*cpu_use)/20-10).toFixed(2)+"px")
                                }else if(cpu_use >80 && cpu_use<=100){
                                    $(".triangle-down").css('margin-left',((61*cpu_use)/20-10).toFixed(2)+"px")
                                }


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
            memUse:function(data){
                var div = document.getElementById("mem_1")
                this.setCharts(div,"mem_1")
                this.myChart_mem_1 = echarts.init(div);
                var option = {
                    tooltip : {
                        formatter: "{a}:{c}%"
                    },
                    toolbox: {
                        feature: {
                        }
                    },
                    series: [
                        {
                            name: 'CPU占用率',
                            type: 'gauge',
                            detail: {
                                formatter: function (value) {
                                    return "总内存:"+data.total+"M\n"+"内存使用率:"+value+"%";
                                },
                                fontSize:12,
                                color:'black',
                                padding:[60,0,0,0]
                            },
                            data: [{value: data.percent,total:data.total}],
                            radius:'100%%',
                            axisLine: {
                                lineStyle: {
                                    width: 10 // 这个是修改宽度的属性
                                }
                            },
                            splitLine:{
                                length:20
                            },
                            axisLabel:{
                                distance:2
                            }
                        }
                    ]
                };
                this.myChart_mem_1.setOption(option);
            },
            setCharts: function (obj,id) {
                obj.setAttribute("width",$("#"+id+"").width() + 'px')
                obj.setAttribute("height",Math.round($("#"+id+"").height()) + 'px')
            },
            canvas:function(id,data,obj){
                var div = document.getElementById(id)
                this.setCharts(div,id)
                var that = this
                obj = echarts.init(div);
                var option = {
                    title: {
                        text: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            return that.formatDate(params[0]['data'][0])+" <br/>"+params[0]['data'][1];
                        },
                        axisPointer: {
                            animation: false
                        }
                    },
                    xAxis: {
                        type: 'time',
                        name: '时间',
                        splitLine: {
                            show: false
                        }
                    },
                    yAxis: {
                        type: 'value',
                        name: '百分比',
                        boundaryGap: [0, '100%'],
                        splitLine: {
                            show: false
                        },
                        max:100
                    },
                    series: [{
                        name: '模拟数据',
                        type: 'line',
                        showSymbol: true,
                        hoverAnimation: false,
                        data: data,
                        itemStyle: {
                            normal: {
                                color: "red",//折线点的颜色
                                lineStyle: {
                                    color: this.color[id]//折线的颜色
                                }

                            }
                        }

                    }]
                };
                obj.setOption(option);
                if(id === "cpu_2"){
                    this.myChart_cpu = obj
                }else if(id === 'mem_2' ){
                    this.myChart_mem = obj
                }else{
                    this.myChart_disk = obj
                }
            },
            goBack:function(){
                this.info_main = true
                this.detail_info = false
                this.isFirst = 0
                window.clearInterval(this.setTime);
            },
            source:function(vo){
                if(vo.cpu_use.split(',').length!=5||vo.mem_use.split(',').length!=5||vo.disk_use.split(',').length!=5){
                    layer.msg("节点资源数据异常");
                    var t;
                    clearTimeout(t)
                    t = setTimeout(function () {
                        location.reload();
                    }, 2000);
                    return;
                }
                this.info = vo
                this.info_main = false
                this.detail_info = true
                this.getSysInfo(vo.id)
                var that = this
                clearTimeout(this.setTime);
                this.setTime = window.setInterval(function (){
                    that.getSysInfo(vo.id)
                },3000);
            },
            getList: function (page) {
                var map = {};
                var num = this.getPage()
                if (this.ip != '') {
                    map['ip'] = this.ip;
                }
                if (this.status != '') {
                    map['status'] = this.status;
                }
                if (this.department_id != '') {
                    map['department_id'] = this.department_id;
                }
                map.page = page;
                map.page_size = num;
                this.$http.post('{{ url()->current() }}', map, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.formData = res.body.data.data;
                            this.$nextTick(function () {
                                layui.use('element', function () {
                                    var element = layui.element;
                                    element.render()
                                })
                            })
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
                                            var num = obj.limit;
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
            backSelectData:function (data) {
                var str = "<option value=''>请选择组织结构</option>"
                for (var i in data){
                    str += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>"
                    var first = data[i]
                    if(first['children'] != undefined &&first['children'].length > 0 ){
                        for (var n in first['children']){
                            var secend = first['children']
                            str += "<option value='"+secend[n]['id']+"'>├─"+secend[n]['name']+"</option>";
                            if(secend[n]['children'] != undefined && secend[n]['children'].length >0){
                                for (var a in secend[n]['children']) {
                                    var third = secend[n]['children'][a]
                                    str += "<option value='" + third['id'] + "'>├─├─" + third['name'] + "</option>";
                                }
                            }
                        }
                    }
                }
                $("#selectData").html(str)
                layui.use(['form'], function () {
                      var form = layui.form;
                      form.render('select')
               })

            }
        },
        mounted: function () {
            this.$http.post('/admin/department', {}, {emulateJSON: true})
                .then(function (res) {
                    var str = lea.msg(res.body.msg) || '服务器异常';
                    var th = this
                    var data = res.body.data
                    this.backSelectData(data)
                    // this.$nextTick(function () {
                    //     layui.use(['form'], function () {
                    //         var form = layui.form;
                    //         form.render()
                    //     })
                    // })
                    data[0]['spread'] = true;
                    layui.use('tree', function () {
                        layui.tree({
                            elem: '#demop' //传入元素选择器
                            , nodes: data,
                            shin: "ssss",
                            click: function (node) {
                                th.department_id = node.id;
                                $("#selectData").val(node.id);
                                th.form.render('select');
                                th.getList(1);
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
            this.getList(1);
            $("#load_gif").hide();
            $("#app").show();
            // 窗口resize
            var that = this
            $(window).resize(function () {
                if(that.detail_info == true) {
                    that.myChart_cpu.resize();
                    that.myChart_mem.resize();
                    that.myChart_disk.resize();
                    that.myChart_mem_1.resize();
                }
            })
        },

        created: function () {
            var that = this
            layui.use(['form'], function () {
                 that.form = layui.form;
                that.form.on('select(selectData)', function(data){
                        that.department_id = data.value
                });
                that.form.on('select(nodeStatus)', function(data){
                    that.status = data.value
                });
                that.form.render()

            })
        }
    });
</script>
</body>
</html>