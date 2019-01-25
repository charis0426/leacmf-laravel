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
            <label class="layui-form-label">角色名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" v-model="formData.title" placeholder="角色名称" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色标识</label>
            <div class="layui-input-block">
                <input type="text" name="name" v-model="formData.name" placeholder="角色标识" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-block">
                <textarea name="remark"  v-model="formData.remark" class="layui-textarea" placeholder="描述"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn"type="button" @click="addRole()">立即提交</button>
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

    new Vue({
        el: '#app',
        data: {
            message: '<span>Hello Vue.js!</span>',
            formData:{
                title:'',
                name:'',
                remark:''
            },
        },
        methods:{
            addRole:function(){
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
                //console.log(jsonData)
                history.go(-1);
            }
        },
        mounted(){
            // console.log(33);
            //console.log(this.message);
        },
        created(){
            //  console.log(43)
            // this.resetFormData = this.formData;
        }
    });
</script>
</body>
</html>