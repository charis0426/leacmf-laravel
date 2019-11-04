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
        <div class="layui-card-header">验证身份</div>
        <div class="layui-card-body">
            <form class="layui-form" style="width: 450px; margin: 0 auto;" ref="formData">
                <div class="layui-form-item">
                    <span>你正在为账号<a style="color:steelblue;">@{{key}}</a>找回密码,为了保护账号安全,需要验证身份</span>
                </div>
                <div class="layui-form-item" style="padding: 10px;background: rgba(242,242,242,1);">
                    <div class="layui-icon layui-icon-cellphone"
                         style="font-size: 30px; color: #1E9FFF; width: 40px;float: left;" v-if="type == 1"></div>
                    <div class="layui-icon layui-icon-release"
                         style="font-size: 30px; color: #1E9FFF; width: 40px;float: left;" v-if="type == 0"></div>
                    <div style="width: 340px;float: left;text-align: center;">
                        <span v-if="type == 1">通过手机号@{{key}}验证</span>
                        <span v-if="type == 0">通过登录邮箱@{{key}}验证</span>
                    </div>
                    <div style="float: right">
                        <button class="layui-btn layui-btn-normal layui-btn-sm" type="button" @click="confirm()">验证
                        </button>
                    </div>
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
                this.$http.post('{{ url()->current() }}', {}, {emulateJSON: true})
                    .then(function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                        setTimeout(() => {
                            window.location.href = res.body.url;
                        }, 1000);
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            ckCode: function () {
                var str = '{{captcha_src('flat')}}';
                $("#captcha-src").attr('src', str + '?' + Math.random());
            },
            resetAuth: function () {
                //console.log(jsonData)
                Object.assign(this.$data.formData, this.$options.data().seatFormData)
            }
        },
        mounted: function () {
            this.key = '{{$key}}';
            this.type = '{{$type}}';
            //console.log(this.message);
        },
        created: function () {
            //  console.log(43)
            // this.resetFormData = this.formData;
        }
    });
</script>
</body>
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

</html>
