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
    <link rel="stylesheet" href="/static/layuiadmin/style/common.css" media="all">
</head>
<style>
    .form_label {
        width: 112px;
    }

    .form_block {
        margin-left: 150px;
    }

    #app {
        background-color: white;
        height: calc(100% - 40px);
    }

    .info-detail {
        position: fixed;
        _position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        z-index: 97;
        background-color: #eeeeee;
        /*overflow: auto;*/
    }

    .m-lr20 {
        margin: 20px;
        background-color: #FFFFFF;
        height: calc(100% - 40px);
    }
</style>
<body layadmin-themealias="default">
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div class="layui-fluid" id="app">
    <div class="info-detail">
        <div class="layui-row m-lr20">
            <div class="layui-col-md12" style="margin-top: 20px;margin-left: 20px">
                <form class="layui-form" action="">
                    <div class="layui-form-item">
                        <label class="layui-form-label form_label">平台名称</label>
                        <div class="layui-input-block form_block">
                            <input type="text" name="title" required lay-verify="required" v-model="formData.title"
                                   placeholder="平台名称" autocomplete="off" class="layui-input"
                                   @blur.prevent="reg($event,'title')" style="width: 50%;">
                            <span style="color: red" v-if="title">中英文均可，字数范围10~20之间</span>
                            <span style="color: red;display: none" v-else>中英文均可，字数范围10~20之间</span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label form_label">视频联网平台地址</label>
                        <div class="layui-input-block form_block">
                            <input type="text" name="video_url" required lay-verify="required"
                                   v-model="formData.video_url" placeholder="视频联网平台地址" autocomplete="off"
                                   class="layui-input" @blur.prevent="reg($event,'video_url')" style="width: 50%;">
                            <span style="color: red" v-if="video_url">请输入有效网络地址</span>
                            <span style="color: red;display: none" v-else>请输入有效网络地址</span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label form_label">ICP备案序号</label>
                        <div class="layui-input-block form_block">
                            <input type="text" name="record_num" required lay-verify="required"
                                   v-model="formData.record_num" placeholder="ICP备案序号" autocomplete="off"
                                   class="layui-input" @blur.prevent="reg($event,'record_num')" style="width: 50%;">
                            <span style="color: red" v-if="record_num">ICP备案编号:"‘省简称’ICP备‘数字’号" </span>
                            <span style="color: red;display: none" v-else>ICP备案编号:"‘省简称’ICP备‘数字’号"</span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label form_label">版权信息</label>
                        <div class="layui-input-block form_block">
                            <input type="text" name="copyright_info" required lay-verify="required"
                                   v-model="formData.copyright_info" placeholder="版权信息" autocomplete="off"
                                   class="layui-input" style="width: 50%;">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label form_label">网站状态</label>
                        <div class="layui-input-block form_block">
                            <input type="radio" name="status" value="0" title="正常">
                            <input type="radio" name="status" value="1" title="关闭">
                            <input type="radio" name="status" value="2" title="升级中"></div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block form_block">
                            <button class="layui-btn layui-btn-sm" lay-submit lay-filter="formDemo">提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary layui-btn-sm">清空</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script>layui.use('form',
        function () {
            var form = layui.form;
            //监听提交
            form.on('submit(formDemo)',
                function (data) {
                    var title = $("input[name='title']").val();
                    if (!/^([\u4e00-\u9fa5a-zA-Z_-]+)$/.test(title)) {
                        $("input[name='title']").next('span').css('display', 'block');
                        return false;
                    }
                    var video_url = $("input[name='video_url']").val();
                    if (!/[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+\.?/.test(video_url)) {
                        $("input[name='video_url']").next('span').css('display', 'block');
                        return false;
                    }
                    var record_num = $("input[name='record_num']").val();
                    if (!/^[\u4e00-\u9fa5]{1,1}ICP备[0-9]{8,8}号$/.test(record_num)) {
                        $("input[name='record_num']").next('span').css('display', 'block');
                        return false;
                    }
                    $.post('{{ url()->current() }}', data.field, {
                        emulateJSON: true
                    }).then(function (res) {
                            console.log(res);
                            if (res.code == 0) {
                                layer.msg(res.msg, {
                                        time: 1200
                                    },
                                    function () {
                                    });
                            } else {
                                var str = res.msg || '服务器异常';
                                layer.msg(str);
                            }
                        },
                        function (res) {
                            var str = res.msg || '服务器异常';
                            layer.msg(str);
                        });
                    return false;
                });
        });

    new Vue({
        el: '#app',
        data: {
            formData: {},
            title: false,
            video_url: false,
            record_num: false
        },
        methods: {
            reg: function (e, name) {
                switch (name) {
                    case 'title':
                        var title = e.currentTarget.value;
                        if (!/^([\u4e00-\u9fa5a-zA-Z_-]+)$/.test(title)) {
                            this.title = true;
                        } else {
                            this.title = false;
                        }
                        break;
                    case 'video_url':
                        var video_url = e.currentTarget.value;
                        if (!/[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+\.?/.test(video_url)) {
                            this.video_url = true;
                        } else {
                            this.video_url = false;
                        }
                        break;
                    case 'record_num':
                        var record_num = e.currentTarget.value;
                        if (!/^[\u4e00-\u9fa5]{1,1}ICP备[0-9]{8,8}号$/.test(record_num)) {
                            this.record_num = true;
                        } else {
                            this.record_num = false;
                        }
                        break;
                }
            }
        },
        mounted: function () {
            let str = '{{$list}}'.replace(/&quot;/g, '"');
            str = str.replace(/\\/g, "/");
            if (str !== '') {
                this.formData = $.parseJSON(str);
                $('input:radio[name=status]')[this.formData.status].checked = true;

            }
            $("#load_gif").hide();
            $("#app").show();

        },
        created: function () {

        }
    });</script>
</body>

</html>