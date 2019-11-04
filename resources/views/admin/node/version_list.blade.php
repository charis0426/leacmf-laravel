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
</head>
<body layadmin-themealias="default">
<style>
    .layui-form-label {
        width: 60px !important;
        text-align: right;
        padding-right: 10px;
    }

    #test6 {
        width: 200px !important;
    }

    .node-manage {
        padding: 0px 20px 0px 20px;
        overflow-y: auto;
        border-bottom: 1px solid #dcdcdc;
        border-left: 1px solid #dcdcdc;
        height: calc(100% - 61px) !important;
        height: -moz-calc(100% - 61px) !important;
        height: -webkit-calc(100% - 61px) !important;
        background-color: #eeeeee;
    }

    .node-text {
        margin-bottom: 10px;
    }

    #myFile {
        margin-bottom: 10px;
    }

    .input-new {
        line-height: 30px;
        max-height: 30px;
    }

    .layui-input-block {
        margin-left: 80px;
    }

    .layui-progress {
        margin-bottom: 10px;
    }
</style>
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div v-show="info_main">
        <div class="layui-row">
            <div class="layui-inline layui-form-serch">
                <label class="layui-form-label">日期范围</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input layui-input-search" id="test6" placeholder="请选择时间区间" readonly>
                </div>
            </div>
            <div class="layui-inline layui-form-serch">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-inline">
                    <input type="text" v-model="description" placeholder="请输入描述内容" autocomplete="off"
                           class="layui-input layui-input-search">
                </div>
            </div>
            <div class="layui-inline layui-form-serch">
                <label class="layui-form-label">版本</label>
                <div class="layui-input-inline">
                    <input type="text" v-model="version" placeholder="请输入版本号" autocomplete="off"
                           class="layui-input layui-input-search">
                </div>
            </div>
            <div class="layui-input-inline">
                <button class="layui-btn layui-btn-normal layui-btn-sm" @click="getList(1)"><i class="layui-icon">&#xe615;</i>搜索</button>
            </div>
        </div>
    </div>
    <div class="layui-row m-lr20">
        <div class="layui-col-md4 c-left">
            <div class="grid-demo grid-demo-bg1" style="text-align: center">节点升级</div>
            <div class="node-manage">
                <div class="layui-form-item">
                    <label class="layui-form-label">当前版本</label>
                    <div class="layui-input-block input-new">
                        <input type="text" name="video_url" readonly lay-verify="required" :value="versionInfo['version']"
                               autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">更新时间</label>
                    <div class="layui-input-block input-new">
                        <input type="text" name="video_url" readonly lay-verify="required" :value="versionInfo['updated_at']"
                               autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item" style="margin-bottom: 5px;">
                    <label class="layui-form-label">安装包</label>
                    <div class="layui-input-block input-new">
                        <form action="" id="fileForm">
                            <input type="file" id="myFile" multiple>
                        </form>
                    </div>
                </div>
                <div class="layui-form-item" v-if="upload_progress" style="margin-bottom: 5px">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div class="layui-progress layui-progress-big" lay-showPercent="true">
                            <div class="layui-progress-bar layui-bg-blue " id="upload-progress" :lay-percent="percent"
                                 value=""></div>
                            {{--<p>已上传@{{data.progress}}</p>--}}
                        </div>
                    </div>
                </div>
                <div class="layui-form-item" v-if="upload_btn" style="margin-bottom: 5px">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block input-new">
                        <input type="button" class="upload-item-btn layui-btn layui-btn-normal layui-btn-sm"
                               :disabled="btn_disable" :data-name="data.fileName" :data-size="data.totalSize"
                               data-state="default" :value="data.uploadVal">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">描述</label>
                    <div class="layui-input-block">
                        <textarea name="desc" v-model="ug_description" placeholder="请输入内容"
                                  class="layui-textarea"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">升级进度</label>
                    <div  class="layui-input-block"  style="margin-left: 80px;">
                        <div class="layui-progress layui-col-md6" lay-showPercent="yes" style="margin-top: 15px;">
                            <div class="layui-progress-bar layui-bg-blue" :lay-percent="progress"></div>
                        </div>
                        <div class="layui-col-md4 layui-col-md-offset2">
                            <button v-if="versionInfo['status'] != '2'&&progress != '100%'" class="layui-btn layui-btn-normal layui-btn-sm" @click="stopUpgrade()">暂停升级</button>
                            <button v-else class="layui-btn layui-btn-normal layui-btn-sm layui-btn-disabled">暂停升级</button>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button v-if="progress == '100%'|| versionInfo['status'] == '2'" class="layui-btn layui-btn-sm"
                                @click="upgrade()">
                            @{{upgrade_btn_value}}
                        </button>
                        <button v-else class="layui-btn layui-btn-sm layui-btn-disabled">
                            @{{upgrade_btn_value}}
                        </button>
                        <button class="layui-btn layui-btn-sm" @click="roleBack()">回滚</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md8">
            <div class="layui-col-md12">
                <table class="layui-table  text-center" lay-size="sm">
                    <thead>
                    <tr>
                        <th>
                            <div class="text-left">更新时间</div>
                        </th>
                        <th>
                            <div class="text-left">版本</div>
                        </th>
                        <th>
                            <div class="text-left">描述</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(vo,id) in formData">
                        <td>
                            <div class="text-left" v-text="vo['updated_at']"></div>
                        </td>
                        <td>
                            <div class="text-left" v-text="vo['version']"></div>
                        </td>
                        <td v-text="vo['description']"></td>
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
</div>

<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/layer.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>


<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                size: 0,
                formData: {},
                version: '',
                description: '',
                info_main: true,
                upload_btn: false,
                start_time: '',
                end_time: '',
                data: {
                    fileName: "",
                    totalSize: "",
                    uploadVal: "",
                    progress: 0
                },
                percent: '0%',
                btn_disable: false,
                element: null,
                ug_description: '',
                upload_progress: false,
                upgrade_btn: false,
                upgrade_btn_value: "升级",
                progress: '0%',
                versionInfo:{},
                progressInfo:{}
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
            stopUpgrade:function(){
                var that = this;
                layer.confirm("确认暂停升级所有节点吗？", {title: "提醒"}, function (index) {
                    that.$http.get('/admin/node/stopUp', {}, {emulateJSON: true})
                        .then(function (res) {
                            if(res.body.code == 0){
                               that.versionInfo.status = 2;
                            }
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        });
                    layer.close(index);
                })
            },
            roleBack: function () {
                var that = this;
                layer.confirm("确认要回滚至上一个版本？", {title: "提醒"}, function (index) {
                    that.$http.post('/admin/node/roleBack', {}, {emulateJSON: true})
                        .then(function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        });
                    layer.close(index);
                })
            },
            upgrade: function () {
                var map = {}
                if (this.ug_description != '') {
                    map.description = this.ug_description
                } else {
                    layer.msg("请填写升级描述内容");
                    return;
                }
                if (this.data.fileName == '' || this.percent != '100%') {
                    layer.msg("请先上传文件");
                    return;
                }
                map.file_path = this.data.fileName
                this.$http.post('/admin/node/upgrade', map,
                    {emulateJSON: true})
                    .then(function (res) {
                        if(res.body.code == 0){
                            this.getVersionInfo()
                        }
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });

            },
            getVersionInfo:function(){
                this.$http.get("/admin/node/version", {}, {emulateJSON: true})
                    .then(function (res) {
                        if(res.body.code == 0){
                            this.versionInfo = res.body.data.info
                            this.progressInfo = res.body.data.progress

                            var total = this.progressInfo.total;
                            var finish = this.progressInfo.finish;
                            if(total == 0 || finish == 0){
                                this.progress = '0%';
                            }else{
                                var progress = (finish/total).toFixed(2)*100;
                                this.progress = progress+"%";
                            }
                            this.$nextTick(function () {
                                layui.use('element', function () {
                                    var element = layui.element;
                                    element.render()
                                })
                            })
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            getList: function (page) {
                var map = {};
                var num = this.getPage()
                if (this.start_time != '') {
                    map['start_time'] = this.start_time;
                }
                if (this.end_time != '') {
                    map['end_time'] = this.end_time;
                }
                if (this.version != '') {
                    map['version'] = this.version;
                }
                if (this.description != '') {
                    map['description'] = this.description;
                }
                map.page = page;
                map.page_size = num;
                this.$http.post('{{ url()->current() }}', map, {emulateJSON: true})
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
            }

        },
        mounted: function () {
            this.getList(1);
            $("#load_gif").hide()
            $("#app").show();
            this.getVersionInfo();
            var that = this;
            $(window).unload(function () {
                // 关闭删除10天前的记录
                var storage=window.localStorage;
                var reg = /^(node_)(\d{1})(.)(\d{1})(.)(\d{8})(.)(\d{6})(.)(tar.gz_)/;
                for(var i=0;i<storage.length;i++){
                    var key=storage.key(i);
                    if(reg.test(key)){
                        var s_time = key.split('_')[1].split('.')[2].replace(/^(\d{4})(\d{2})(\d{2})$/, "$1-$2-$3")
                        var date = new Date();
                        var day1 = new Date(s_time);
                        var day2 = new Date(date .getFullYear()+"-"+(parseInt(date.getMonth())+1)+"-"+ date .getDate());
                       if((day2 - day1) /(1000 * 60 * 60 * 24)>10){
                           window.localStorage.removeItem(key)
                       }
                    }
                }
            });

            // 选择文件-显示文件信息
            $('#myFile').change(function (e) {
                var file,
                    // uploadItem = [],
                    // uploadItemTpl = $('#file-upload-tpl').html(),
                    size,
                    percent,
                    progress = '未上传',
                    uploadVal = '开始上传';
                if (this.files.length > 1) {
                    layer.msg("只能选择一个文件");
                    return false;
                }
                file = this.files[0];
                var reg = /^(node_)(\d{1})(.)(\d{1})(.)(\d{8})(.)(\d{6})(.)(tar.gz)$/;
                if (!reg.test(file.name)) {
                    layer.msg("文件格式不正确");
                    $("#fileForm")[0].reset();
                    return false;
                }
                percent = undefined;
                progress = '未上传';
                uploadVal = '开始上传';

                // 计算文件大小
                size = file.size > 1024
                    ? file.size / 1024 > 1024
                        ? file.size / (1024 * 1024) > 1024
                            ? (file.size / (1024 * 1024 * 1024)).toFixed(2) + 'GB'
                            : (file.size / (1024 * 1024)).toFixed(2) + 'MB'
                        : (file.size / 1024).toFixed(2) + 'KB'
                    : (file.size).toFixed(2) + 'B';

                // 初始通过本地记录，判断该文件是否曾经上传过
                percent = window.localStorage.getItem(file.name + '_p');
                if (percent && percent !== '100.0') {
                    progress = '已上传 ' + percent + '%';
                    uploadVal = '继续上传';
                    that.percent = percent + "%";
                    that.btn_disable = false
                    that.upload_progress = true
                } else if (percent && percent == '100.0') {
                    progress = '已上传 100%';
                    uploadVal = '已经上传';
                    that.percent = "100%";
                    that.btn_disable = true
                    that.upload_progress = true
                } else {
                    progress = '已上传 0%';
                    uploadVal = '开始上传';
                    that.percent = "0%";
                    that.btn_disable = false
                }

                // 更新文件信息列表
                var map = {}
                map['fileName'] = file.name;
                map['fileType'] = file.type || file.name.match(/\.\w+$/) + '文件';
                map['fileSize'] = size;
                map['progress'] = progress;
                map['totalSize'] = file.size;
                map['uploadVal'] = uploadVal;
                //that.data.push(map);
                that.data = map
                that.upload_btn = true
                that.$nextTick(function () {
                    that.element.render()
                })
            });

            /**
             * 上传文件时，提取相应匹配的文件项
             * @param  {String} fileName   需要匹配的文件名
             * @return {FileList}          匹配的文件项目
             */
            function findTheFile(fileName) {
                var files = $('#myFile')[0].files,
                    theFile;

                for (var i = 0, j = files.length; i < j; ++i) {
                    if (files[i].name === fileName) {
                        theFile = files[i];
                        break;
                    }
                }

                return theFile ? theFile : [];
            }

            // 上传文件
            $(document).on('click', '.upload-item-btn', function () {
                that.upload_progress = true
                var $this = $(this),
                    state = $this.attr('data-state'),
                    msg = {
                        done: '上传成功',
                        failed: '上传失败',
                        in: '上传中...',
                        paused: '暂停中...'
                    },
                    fileName = $this.attr('data-name'),
                    $progress = $("#upload-progress"),
                    eachSize = 1024 * 1 * 3,
                    totalSize = $this.attr('data-size'),
                    chunks = Math.ceil(totalSize / eachSize),
                    percent,
                    chunk,
                    // 暂停上传操作
                    isPaused = 0;

                // 进行暂停上传操作
                if (state === 'uploading') {
                    $this.val('继续上传').attr('data-state', 'paused');
                    $progress.attr('value', msg['paused'] + percent + '%');
                    isPaused = 1;
                    window.localStorage.setItem(fileName + '_status', 1);
                    return;
                }
                // 进行开始/继续上传操作
                else if (state === 'paused' || state === 'default') {
                    window.localStorage.setItem(fileName + '_status', 0);
                    $this.val('暂停上传').attr('data-state', 'uploading');
                    isPaused = 0;
                }

                // 第一次点击上传
                startUpload('first');

                // 上传操作 times: 第几次
                function startUpload(times) {
                    // 上传之前查询是否以及上传过分片
                    chunk = window.localStorage.getItem(fileName + '_chunk') || 0;
                    chunk = parseInt(chunk, 10);
                    // 判断是否为末分片
                    var isLastChunk = (chunk == (chunks - 1) ? 1 : 0);

                    // 如果第一次上传就为末分片，即文件已经上传完成，则重新覆盖上传
                    if (times === 'first' && isLastChunk === 1) {
                        window.localStorage.setItem(fileName + '_chunk', 0);
                        chunk = 0;
                        isLastChunk = 0;
                    }

                    // 设置分片的开始结尾
                    var blobFrom = chunk * eachSize, // 分段开始
                        blobTo = (chunk + 1) * eachSize > totalSize ? totalSize : (chunk + 1) * eachSize, // 分段结尾
                        percent = (100 * blobTo / totalSize).toFixed(1), // 已上传的百分比
                        timeout = 5000, // 超时时间
                        fd = new FormData($('#myForm')[0]);
                    fd.append('theFile', findTheFile(fileName).slice(blobFrom, blobTo)); // 分好段的文件
                    fd.append('fileName', fileName); // 文件名
                    fd.append('start', blobFrom);
                    fd.append('end', blobTo);
                    fd.append('totalSize', totalSize); // 文件总大小
                    fd.append('isLastChunk', isLastChunk); // 是否为末段
                    fd.append('isFirstUpload', times === 'first' ? 1 : 0); // 是否是第一段（第一次上传）

                    // 上传
                    $.ajax({
                        type: 'post',
                        url: '/upload',
                        data: fd,
                        processData: false,
                        contentType: false,
                        timeout: timeout,
                        success: function (rs) {
                            rs = JSON.parse(rs);

                            // 上传成功
                            if (rs.status === 200) {
                                // 记录已经上传的百分比
                                window.localStorage.setItem(fileName + '_p', percent);

                                // 已经上传完毕
                                if (chunk === (chunks - 1)) {
                                    $progress.attr('value', msg['done']);
                                    that.percent = '100%';
                                    that.$nextTick(function () {
                                        that.element.render()
                                    })
                                    that.data.uploadVal = "已经上传"
                                    that.btn_disable = true
                                } else {
                                    // 记录已经上传的分片
                                    window.localStorage.setItem(fileName + '_chunk', ++chunk);
                                    $progress.attr('value', msg['in'] + percent + '%');
                                    that.percent = percent + '%';
                                    that.$nextTick(function () {
                                        that.element.render()
                                    })
                                    var status = window.localStorage.getItem(fileName + '_status')
                                    if (status == 0) {
                                        startUpload();
                                        // window.setTimeout(function(){startUpload();},1000);
                                    }

                                }
                            }
                            // 上传失败，上传失败分很多种情况，具体按实际来设置
                            else{
                                layer.msg("文件上传错误，请重新上传")
                                var storage=window.localStorage;
                                var reg = eval("/^("+fileName+"_)/");
                                for(var i=0;i<storage.length;i++){
                                    var key=storage.key(i);
                                    if(reg.test(key)){
                                        window.localStorage.removeItem(key)
                                    }
                                }
                                $("#fileForm")[0].reset();
                                that.percent = '0%';
                                progress = '已上传 0%';
                                that.data.uploadVal = '开始上传';
                                that.data.fileName = '';
                                that.upload_btn = false
                                that.$nextTick(function () {
                                    that.element.render()
                                })
                            }
                        },
                        error: function () {
                            $progress.attr('value', msg['failed']);
                            layer.msg(msg['failed']);
                        }
                    });
                }
            });
        },

        created: function () {
            var that = this;
            layui.use(['laydate', 'element'], function () {
                var laydate = layui.laydate;
                laydate.render({
                    elem: '#test6'
                    , range: '~'
                    , done: function (value) {
                        var date = value.split("~");
                        that.start_time = date[0];
                        that.end_time = date[1];
                    }
                });
                that.element = layui.element;
            })
        }
    });
</script>
</body>
</html>