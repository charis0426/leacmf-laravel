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
<body layadmin-themealias="default">
<div class="layui-fluid" id="app">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="site-text site-block">
    <form class="layui-form"  style="width: 500px;" >
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" name="username" v-model="formData.username" readonly="1" placeholder="用户名" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">昵称</label>
            <div class="layui-input-block">
                <input type="text" name="nickname" v-model="formData.nickname" placeholder="昵称" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" v-model="formData.password" placeholder="密码" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所属角色</label>
            <div class="layui-input-block">
                @foreach($roles as $role)
                    @if ($role->id!=1)
                <input type="checkbox" name="roles" value="{{ $role->id }}"  @if (in_array($role->id,$has_roles)) checked @endif lay-skin="primary" title="{{ $role->title }}">
                @endif @endforeach
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn"type="button" @click="editAdmin()">立即提交</button>
                <button type="button" class="layui-btn layui-btn-primary" @click="goBack()">返回</button>
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
    layui.use('form', function(){
        var form = layui.form;
        form.render();
        //监听提交
    });
    const jsonData = {
        nickname:'',
        password:''
    }
    new Vue({
        el: '#app',
        data: {
            message: '<span>Hello Vue.js!</span>',
            formData:{},
            seatFormData:jsonData
        },
        methods:{
            editAdmin:function(){
                var arr = new Array();
                $("input:checkbox[name='roles']:checked").each(function(i){
                    arr[i] = $(this).val();
                });
                this.formData.roles = arr;
                this.$http.post('{{ url()->current() }}', this.formData,{emulateJSON:true})
                    .then(function(res){
                        if (res.code == 0) {
                            layer.msg(lea.msg(res.body.msg), { time: 1200 }, function() {
                                layer.close(index);
                            });
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    },function(res){
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            goBack(){
                history.go(-1);
            }
        },
        mounted(){
            let str = '{{$admin}}'.replace(/&quot;/g,'"');
            str = str.replace(/\\/g,"/");
            this.formData =$.parseJSON(str)
            this.formData.password = ""
        },
        created(){
            //  console.log(43)
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
