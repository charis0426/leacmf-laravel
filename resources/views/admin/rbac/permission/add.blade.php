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
    <form class="layui-form"  style="width: 500px;" ref="formData">
        <div class="layui-form-item">
            <label class="layui-form-label">父级权限</label>
            <div class="layui-input-block">
                <select id="pid" name="pid"  value="" lay-filter="pid" lay-verify="required">
                    <option value="0">顶级权限</option>
                    @foreach ($list as $vo)
                    <option value="{{$vo['id']}}">{{$vo['html']}} {{$vo['title']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" v-model="formData.title" name="title" placeholder="标题"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" v-model="formData.name" placeholder="路由名称" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图标</label>
            <div class="layui-input-inline">
                <input type="text" name="icon" v-model="formData.icon" placeholder="fa fa-edit" value="" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">支持font-awesome字体</div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-inline">
                    <input type="number" name="sort" v-model="formData.sort" value="0" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">是否菜单</label>
                    <div class="layui-input-block">
                        <input type="radio" name="is_menu" lay-filter="" value="1" title="是" >
                        <input type="radio" name="is_menu"  value="0" title="否" checked>
                    </div>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">参数</label>
            <div class="layui-input-block">
                <input type="text" name="param" v-model="formData.param" placeholder="参数，http_build_query格式" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn"type="button" @click="addAuth()">立即提交</button>
                <button type="button" class="layui-btn layui-btn-primary" @click="resetAuth()">重置</button>
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
        form.on('select(pid)',function (data) {
            $("#pid").attr('value',data.value)
        })
    });
   const jsonData = {
        pid:0,
        title:'',
        name:'',
        icon:'',
        sort:0,
        is_menu:'',
        param:''
    }
    new Vue({
        el: '#app',
        data: {
            message: '<span>Hello Vue.js!</span>',
            formData:{
                pid:0,
                title:'',
                name:'',
                icon:'',
                sort:0,
                is_menu:'',
                param:''
            },
            seatFormData:jsonData
        },
        methods:{
            addAuth:function(){
                this.formData['is_menu'] = $("input:radio[name='is_menu']:checked").val();
                this.formData['pid'] = $("#pid").val();
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
            resetAuth(){
                //console.log(jsonData)
                Object.assign(this.$data.formData, this.$options.data().seatFormData)
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