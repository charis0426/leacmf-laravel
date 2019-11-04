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
        <div class="layui-card-header">验证手机</div>
        <div class="layui-card-body">
            <form class="layui-form" style="width: 450px; margin: 0 auto;" ref="formData">
                <div class="layui-form-item">
                    <span>短信验证码已发送至<a style="color:steelblue;">@{{key}}</a></span>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-inline" style="width: 60%;">
                        <input type="text" name="code" maxlength="6" v-model="formData.code" placeholder="请输入短信验证码"
                               autocomplete="off" class="layui-input ">
                    </div>
                    <div class="layui-input-inline" style="width:calc(40% - 10px);margin-right:0px; ">
                        <button class="layui-btn layui-btn-normal layui-btn-sm" type="button" @click="countDown">
                            @{{content}}
                        </button>
                    </div>
                </div>
                <div class="layui-form-item" style="">
                    <button class="layui-btn layui-btn-normal layui-btn-fluid layui-btn-sm" type="button"
                            @click="confirm()">下一步
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
                content: '重新发送验证码',  // 按钮里显示的内容
                totalTime: 60,      //记录具体倒计时时间
                canClick: true,    //添加canClick
                formData: {
                    username: '',
                    email: ''
                },
                key: '',
                type: '',
                seatFormData: jsonData,
                code: ''
            }
        },
        methods: {
            confirm: function () {
                this.$http.post('{{ route('checksmscode') }}', {
                    'code': this.formData.code,
                    "mobile": this.key
                }, {emulateJSON: true})
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
            ckCode: function () {
                var str = '{{captcha_src('flat')}}';
                $("#captcha-src").attr('src', str + '?' + Math.random());
            },
            resetAuth: function () {
                //console.log(jsonData)
                Object.assign(this.$data.formData, this.$options.data().seatFormData)
            },
            countDown() {
                if (!this.canClick) return  //改动的是这两行代码
                this.canClick = false
                this.content = '重新获取(' + this.totalTime + 's)'
                let clock = window.setInterval(() => {
                    this.totalTime--
                    this.content = '重新获取(' + this.totalTime + 's)'
                    if (this.totalTime < 0) {
                        window.clearInterval(clock)
                        this.content = '重新发送验证码'
                        this.totalTime = 60
                        this.canClick = true  //这里重新开启
                    }
                }, 1000)
            }
        },
        mounted: function () {
            this.key = '{{$mobile}}';
            //console.log(this.message);
            this.canClick = true;
            this.countDown();
        },
        created: function () {
            //  console.log(43)
            // this.resetFormData = this.formData;
        }
    });
</script>
</body>

</html>
