<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>找回密码</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<style>
    .backpass .layui-card {
        width: 500px;
        height: 300px;
        margin: 0 auto;
        margin-top: 40px;
    }

    .backpass .layui-card .layui-card-header {
        text-align: center;
    }
</style>
<body>
<div class="layui-fluid backpass" id="app">
    <div class="layui-card">
        <div class="layui-card-header">邮箱验证</div>
        <div class="layui-card-body">
            <form class="layui-form" style="width: 450px; margin: 0 auto;" ref="formData">
                <div class="layui-form-item">
                    <span>设置新的密码衔接已发送至<a style="color:steelblue;">@{{key}}</a></span>
                    <span>请在5分钟内登录邮箱，点击邮箱内衔接设置新的密码</span>

                </div>
                <div class="layui-form-item" style="">
                    <button class="layui-btn layui-btn-normal layui-btn-sm" type="button" @click="confirm()">返回登录
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script src="/static/admin/js/common.js"></script>
<script src="/static/layuiadmin/polyfile.min.js"></script>
<script>
    var jsonData = {
        username: '',
        email: ''
    }
    new Vue({
        el: '#app',
        data: function () {
            return {
                formData: {
                    username: '',
                    email: ''
                },
                key: '',
                type: '',
                seatFormData: jsonData
            }
        },
        methods: {
            confirm: function () {
                window.location.href = '/admin/login';
            }
        },
        mounted: function () {
            this.key = '{{$email}}';
            //console.log(this.message);
        },
        created: function () {
            //  console.log(43)
            // this.resetFormData = this.formData;
        }
    });
</script>
</body>

</html>
