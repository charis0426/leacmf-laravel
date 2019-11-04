<html><head>
    <meta charset="utf-8">
    <title>layuiAdmin std</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
</head>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>企业详情</legend>
</fieldset>
<body layadmin-themealias="default">
<div class="layui-fluid" id="app">
    <div class="layui-form-item">
        <label class="layui-form-label">企业名称</label>
        <div class="layui-input-block">
            <input type="text" name="title" value='{{($info["name"])}}' lay-verify="title" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">企业注册地</label>
        <div class="layui-input-block">
            <input type="text" name="title" value='{{($info["position"])}}' lay-verify="title" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">企业许可号码</label>
        <div class="layui-input-block">
            <input type="text" name="title" value='{{($info["licenses"])}}' lay-verify="title" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">许可证有效期</label>
        <div class="layui-input-block">
            <input type="text" name="title" value='{{($info["last_time"])}}' lay-verify="title" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">企业品牌</label>
        <div class="layui-input-block">
            <input type="text" name="title"  value='{{($info["brands"])}}' lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">企业法人</label>
        <div class="layui-input-block">
            <input type="text" name="title"  value='{{($info["head"])}}' lay-verify="title" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">统一社会信用代码</label>
        <div class="layui-input-block">
            <input type="text" name="title"  value='{{($info["code"])}}' lay-verify="title" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">区域范围</label>
        <div class="layui-input-block">
            <input type="text" name="title" value='{{($info["position"])}}' lay-verify="title" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" @click="goBack()">返回</button>
        </div>
    </div>
</div>
<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script>

    var jsonData = {
        nickname:'',
        password:''
    }
    new Vue({
        el: '#app',
        data: function(){
            return{};

        },
        methods:{
            goBack:function(){
                history.go(-1);
            }
        },
        mounted:function () {

        },
        created:function () {
            // this.resetFormData = this.formData;
        }
    });
</script>
</body>
<style>
    .layui-form-checkbox span{
        height: auto !important;
    }
</style>
</html>
