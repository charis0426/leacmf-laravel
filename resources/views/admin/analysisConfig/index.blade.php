<html><head>
    <meta charset="utf-8">
    <title>layuiAdmin std</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="/static/layuiadmin/style/common.css" media="all">
</head>
<body layadmin-themealias="default">
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div class="layui-fluid" id="app">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="site-text site-block">
                <form class="layui-form"  style="width: 500px;" >
                    <div class="layui-form-item">
                        <label class="layui-form-label">平台名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" v-model="formData.Models" placeholder="智能模型" value="" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">频率</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" v-model="formData.Frequency" placeholder="角色标识" value="" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">开始时间</label>
                        <div class="layui-input-block">
                            <input name="text" type="text" v-model="formData.StartTime" class="layui-input" value="" placeholder="描述">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">结束时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" v-model="formData.EndTime" placeholder="角色标识" value="" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">摄像机id</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" v-model="formData.CamId" placeholder="角色标识" value="" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">Url</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" v-model="formData.Url" placeholder="角色标识" value="" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn"type="button" @click="addRole()">立即提交</button>
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
<script>
    layui.use('form', function(){
        var form = layui.form;
        form.render();
        //监听提交
    });

    new Vue({
        el: '#app',
        data: {
            formData:{

            },
        },
        methods:{
            addRole:function(){
                if(this.formData.statistics_time == null){
                    delete this.formData.statistics_time;
                }
                if(this.formData.concurrency === null){
                    delete this.formData.concurrency;
                }
                if(this.formData.numbers === null){
                    delete this.formData.numbers;
                }
                if(this.formData.page_size === null){
                    delete this.formData.page_size;
                }
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
            let str = '{{$list}}'.replace(/&quot;/g,'"');
            str = str.replace(/\\/g,"/");
            if(str !== ''){
                this.formData = $.parseJSON(str);
            }
            $("#load_gif").hide();
            //$("#app").show();

        },
        created(){
            //  console.log(43)
            // this.resetFormData = this.formData;
        }
    });
</script>
</body>
</html>