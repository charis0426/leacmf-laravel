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

    .layui-form-item {
        margin-bottom: 20px;
    }
</style>
<body>
<div class="layui-fluid backpass" id="app">
    <div class="layui-card">
        <div class="layui-card-header">输入账号</div>
        <div class="layui-card-body">
            <form class="layui-form" style="width: 400px; margin: 0 auto;" ref="formData">
                <div class="layui-form-item">
                    <span>请输入需要找回的手机号/邮箱</span>
                </div>
                <div class="layui-form-item">
                    <input type="text" v-model="formData.username" name="username" placeholder="请输入手机号/邮箱"
                           class="layui-input">
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-inline" style="width: 60%;">
                        <input type="text" name="captcha" maxlength="4" v-model="formData.captcha"
                               placeholder="请输入图片中的数字或字母" autocomplete="off" class="layui-input ">
                    </div>
                    <div class="layui-input-inline" style="width:calc(40% - 10px);margin-right:0px; ">
                        <img src="{{captcha_src('flat')}}" alt="captcha" id="captcha-src" @click="ckCode()"
                             style="width: 100%;height: 36px;"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-normal layui-btn-fluid layui-btn-sm" type="button"
                            @click="sendEmail()">下一步
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
                seatFormData: jsonData
            }
        },
        methods: {
            sendEmail: function () {
                var str = this.formData['username'];
                var map = {}
                if (checkEmail(str)) {
                    map['email'] = str;
                } else if (checkMobile(str)) {
                    map['mobile'] = str;
                } else {
                    layer.msg("请填写正确的邮箱/手机号码");
                    return false;
                }
                map['captcha'] = this.formData['captcha'];
                this.$http.post('{{ url()->current() }}', map, {emulateJSON: true})
                    .then(function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                        if (res.body.code == 0) {
                            setTimeout(() => {
                                window.location.href = res.body.url;
                            }, 1000);
                        } else {
                            $('#captcha-src').click();
                        }
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
            // console.log(33);
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
