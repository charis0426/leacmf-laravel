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
        <div class="layui-card-header">修改密码</div>
        <div class="layui-card-body">
            <form class="layui-form" style="width: 400px; margin: 0 auto;" ref="formData">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-block">
                        <input type="text" v-model="formData.username" name="username" readonly="1" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">新密码</label>
                    <div class="layui-input-block">
                        <input type="text" v-model="formData.password" name="password" placeholder="密码"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">确认密码</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" v-model="formData.confirmPassword" placeholder="确认密码" value=""
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" type="button" @click="updatePass()">立即提交</button>
                        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" @click="resetAuth()">重置
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
<script src="/static/layuiadmin/polyfile.min.js"></script>
<script>
    var jsonData = {
        password: '',
        confirmPassword: ''
    }
    new Vue({
        el: '#app',
        data: {
            formData: {
                password: '',
                confirmPassword: '',
                username: '{{$username}}'
            },
            seatFormData: jsonData
        },
        methods: {
            updatePass: function () {
                this.$http.post('{{ url()->current() }}', this.formData, {emulateJSON: true})
                    .then(function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                        if (res.body.code == 0) {
                            setTimeout(() => {
                                window.location.href = res.body.url;
                            }, 1000);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            resetAuth: function () {
                //console.log(jsonData)
                Object.assign(this.$data.formData, this.$options.data().seatFormData)
            }
        },
        mounted: function () {

        },
        created: function () {
            //  console.log(43)
            // this.resetFormData = this.formData;
        }
    });
</script>
</body>
</html>
