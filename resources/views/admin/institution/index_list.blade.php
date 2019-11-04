<html><head>
    <meta charset="utf-8">
    <title>layuiAdmin std</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
    <link id="layuicss-layer" rel="stylesheet" href="/static/layuiadmin/layui/css/modules/layer/default/layer.css?v=3.1.1" media="all">
    <link rel="stylesheet" href="/static/layuiadmin/style/common.css" media="all">
</head>
<body layadmin-themealias="default">
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id ="app" class="layui-fluid">
    <div style="width: 100%;background: #fff;">
    <ul id="demo"style="width: 100%;"></ul>
    </div>
</div>


<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>


<script>

    var jsonData={
        username:'',
        email:''
    }
    new Vue({
        el: '#app',
        data: function(){
            return {
                formData: {
                    username: '',
                    email: ''
                },
                key:'',
                type:'',
                seatFormData: jsonData
            }
        },
        methods:{

        },
        mounted:function(){
            this.$http.post('{{ url()->current() }}', {},{emulateJSON:true})
                .then(function(res){
                    var data = res.body.data
                    data[0]['spread'] = true;
                    layui.use('tree', function(){
                        layui.tree({
                            elem: '#demo' //传入元素选择器
                            ,nodes: data,
                            shin:"ssss",
                            click: function(node){
                            }
                        });
                    });
                },function(res){
                    var str = lea.msg(res.body.msg) || '服务器异常';
                    layer.msg(str);
                });
            $("#load_gif").hide()
            $("#app").show()
        },
        created:function(){
        }
    });
</script>
</body>
</html>