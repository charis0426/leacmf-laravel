<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>操作过期</title>
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
        <div class="layui-card-header">操作无效</div>
        <div class="layui-card-body">
            <form class="layui-form" style="width: 450px; margin: 0 auto;" ref="formData">
                <div class="layui-form-item">
                    <span>{{$info}},@{{t_content}}s后进行跳转,若没有跳转请点击</span>
                </div>
                <div class="layui-form-item" style="">
                    <button class="layui-btn layui-btn-normal layui-btn-fluid layui-btn-sm" type="button"
                            @click="confirm()">跳转
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
    new Vue({
        el: '#app',
        data: function () {
            return {
                't_content': 5,
                'time': 5
            }
        },
        methods: {
            confirm: function () {
                window.location.href = '{{$url}}';
            },
            cuntDown: function () {
                let clock = window.setInterval(() => {
                    this.time--
                    this.t_content = this.time
                    if (this.time < 0) {
                        window.clearInterval(clock)
                        this.confirm()
                    }
                }, 1000)
            }
        },
        mounted: function () {
            this.cuntDown()
        },
        created: function () {
        }
    });
</script>
</body>
</html>
