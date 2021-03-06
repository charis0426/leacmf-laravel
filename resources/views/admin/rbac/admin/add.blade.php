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
</head>
<body layadmin-themealias="default">
<div class="layui-fluid" id="app">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="site-text site-block">
                <form class="layui-form" style="width: 500px;">
                    <div class="layui-form-item">
                        <label class="layui-form-label">用户名</label>
                        <div class="layui-input-block">
                            <input type="text" name="username" v-model="formData.username" placeholder="用户名" value=""
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">昵称</label>
                        <div class="layui-input-block">
                            <input type="text" name="nickname" v-model="formData.nickname" placeholder="昵称" value=""
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">手机号码</label>
                        <div class="layui-input-block">
                            <input type="text" name="mobile" v-model="formData.mobile" placeholder="请输入手机号码" value=""
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">邮箱</label>
                        <div class="layui-input-block">
                            <input type="text" name="email" v-model="formData.email" placeholder="请输入邮箱" value=""
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">密码</label>
                        <div class="layui-input-block">
                            <input type="password" name="password" v-model="formData.password" placeholder="密码" value=""
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item group" v-show="'{{$city}}' != 1">
                        <label class="layui-form-label">所属组织</label>
                        <div class="layui-input-block">
                            <select id="group_id" name="group_id" value="{{$group_id}}" lay-filter="group_id"
                                    lay-verify="required">
                                @foreach ($group_list as $vo)
                                    <option value="{{$vo['id']}}">{{$vo['html']}} {{$vo['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item" v-show="'{{$role_id}}' !=3">
                        <label class="layui-form-label">所属角色</label>
                        <input type="hidden" id="roles" value="">
                        <div class="layui-input-block">
                            @foreach($roles as $role)
                                @if ($role_id==1 || $role_id<$role->id)
                                    <input type="radio" name="roles" value="{{ $role->id }}" lay-filter="radio"
                                           lay-skin="primary" title="{{ $role->title }}">
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn layui-btn-sm" type="button" @click="addAdmin()">立即提交</button>
                            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" @click="goBack()">
                                返回
                            </button>
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
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();
        //监听提交
        form.on('select(group_id)', function (data) {
            $("#group_id").attr('value', data.value)
        })
        //监听角色选择
        form.on('radio', function (data) {
            if (data.value == 1 || '{{$city}}' == 1) {
                //系统管理员不需要组织结构
                $(".group").hide();
            } else {
                $(".group").show();
            }
            $('#roles').attr('value', data.value)
        })
    });
    new Vue({
        el: '#app',
        data: function () {
            return {
                message: '<span>Hello Vue.js!</span>',
                formData: {}
            }
        },
        methods: {
            addAdmin: function () {
                var arr = new Array();
                if ($("#roles").attr('value') != "") {
                    arr[0] = $("#roles").attr('value');
                } else {
                    layer.msg("请选择所属角色");
                    return;
                }
                this.formData.group_id = parseInt($('#group_id').attr('value'));
                this.formData.roles = arr;
                this.$http.post('{{ url()->current() }}', this.formData, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            layer.msg(lea.msg(res.body.msg), {time: 1200}, function (index) {
                                layer.close(index);
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
            goBack: function () {
                history.go(-1);
            }
        },
        mounted: function () {
            //console.log(str)
        },
        created: function () {
            //  console.log(43)
            // this.resetFormData = this.formData;
            //console.log(str)
        }
    });
</script>
</body>
<style>
    .layui-form-checkbox span {
        height: auto !important;
    }
</style>
</html>