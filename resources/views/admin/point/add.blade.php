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
                        <label class="layui-form-label">对象类型</label>
                        <input type="hidden" id="roles" value="">
                        <div class="layui-input-block">
                            <input @click="clickClear()" type="radio" name="roles" value="1" lay-filter="radio" lay-skin="primary" title="企业">
                            <input @click="clickClear()" type="radio" name="roles" value="2" lay-filter="radio" lay-skin="primary" title="转运中心">
                            <input @click="clickClear()"  type="radio" name="roles" value="3" lay-filter="radio" lay-skin="primary" title="网点">

                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">搜索选择框</label>
                        <div class="layui-input-inline">
                            <select v-model="type111"  name="modules" lay-verify="required" lay-search="">
                                <option value="">直接选择或搜索选择</option>
                                <option v-for="(list, index)  in lists"  :value="list.id" >@{{list.name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">昵称</label>
                        <div class="layui-input-block">
                            <input type="text" name="nickname"  v-model="formData.nickname" placeholder="昵称" value="" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">密码</label>
                        <div class="layui-input-block">
                            <input type="password" name="password" v-model="formData.password" placeholder="密码" value="" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn layui-btn-sm" type="button" @click="addAdmin()">立即提交</button>
                            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" @click="goBack()">返回</button>
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
<script src="/static/layuiadmin/polyfile.min.js"></script>
<script>


    new Vue({
        el: '#app',
        data:function (){
            return {
                type111:"",
                message: '<span>Hello Vue.js!</span>',
                lists :[],
                formData: {}
            }
        },
        methods:{
            addAdmin:function(){
                var arr = new Array();
                if($("#roles").attr('value')!="") {
                    arr[0] = $("#roles").attr('value');
                }else{
                    layer.msg("请选择所属角色");
                    return;
                }
                this.formData.group_id = parseInt($('#group_id').attr('value'));
                this.formData.roles = arr;
                this.$http.post('{{ url()->current() }}', this.formData,{emulateJSON:true})
                    .then(function(res){
                        if (res.body.code == 0) {
                            layer.msg(lea.msg(res.body.msg), { time: 1200 }, function(index) {
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
            getList:function(val){
                this.$http.post('/admin/point/object/list', {"type":val},{emulateJSON:true})
                    .then(function(res){
                        if (res.body.code == 0) {
                            this.lists = res.body.data
                            layui.form.render()
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    },function(res){
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            },
            goBack:function(){
                history.go(-1);
            },
            clickClear:function () {
                this.type111=""

            }
        },
        mounted:function(){
            th = this
            layui.use('form', function(){
                //监听角色选择
                var form = layui.form;
                form.on('radio', function(data){
                    if(data.value==1){
                        //系统管理员不需要组织结构
                        $(".group").hide();
                    }else{
                        $(".group").show();
                    }
                    $('#roles').attr('value',data.value)
                    val= ( $('#roles').val());
                    th.getList(val);
                });
                form.on('select', function(data){
                })
            });
        },
        created:function(){
            //  console.log(43)
            // this.resetFormData = this.formData;
            //console.log(str)
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