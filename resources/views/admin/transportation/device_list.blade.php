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
    <link id="layuicss-layer" rel="stylesheet"
          href="/static/layuiadmin/layui/css/modules/layer/default/layer.css?v=3.1.1" media="all">
</head>
<body layadmin-themealias="default">
<style>
    .layui-icon {
        display: none;
    }

    .layui-tree li {
        background: #f3f5da;

    }

    /*.layui-tree li a cite{*/
    /*color: #39d4c4;*/

    /*}*/
</style>

{{--<div class="layui-form-item" style="margin-top: 20px">--}}
{{--<label class="layui-form-label">企业名称</label>--}}
{{--<div class="layui-input-block" >--}}
{{--<input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input" >--}}
{{--<div class="layui-inline">--}}
{{--<div class="layui-input-inline">--}}
{{--<button class="layui-btn" ><i class="layui-icon">&#xe615;</i>搜索</button>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
'{{dd($info)}}'
<div id="app" class="layui-fluid">
    <div class="layui-form-item" style="margin-top: 20px">
        <div class="layui-inline">
            <label class="layui-form-label">企业名称</label>
            <div class="layui-input-inline">
                <input type="text" v-model="name" placeholder="请输入企业名称" autocomplete="off" class="layui-input"
                       maxlength="80">
            </div>
        </div>
        <div class="layui-inline">
            <div class="layui-input-inline">
                <button class="layui-btn layui-btn-sm layui-btn-normal" @click="getList(1,10,department_id,name)"><i class="layui-icon">&#xe615;</i>搜索
                </button>
            </div>
        </div>
    </div>
    >
    <div class="layui-fluid"
         style=" padding: 7.5px; height:1000px;width:20%;float: left ;overflow-y:scroll;border-collapse: collapse;border-spacing: 0">
        <div class="grid-demo grid-demo-bg1" style="text-align: center">组织机构</div>
        <ul id="demop"></ul>
    </div>
    <div class="layui-row layui-col-space15" style=" float: left;width: 1000px;">
        <div class="layui-col-md12">
            <table class="layui-table  text-center" lay-size="sm">
                <thead>
                <tr>
                    <th style="width: 48px">#</th>
                    <th>
                        <div class="text-left">企业名称</div>
                    </th>
                    <th>
                        <div class="text-left">所在地区</div>
                    </th>
                    <th>
                        <div class="text-left">负责人</div>
                    </th>
                    <th class="text-left">
                        联系电话
                    </th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(vo,id) in formData">
                    <td v-text="id+1">
                    </td>
                    <td>
                        <div class="text-left" v-text="vo['name']"></div>
                    </td>
                    <td>
                        <div class="text-left" v-text="vo['position']"></div>
                    </td>
                    <td>
                        <div class="text-left" v-text="vo['head']"></div>
                    </td>
                    <td v-text="vo['phone']"></td>
                    <td>
                        <a :href="'transportation/show/'+vo['id']"
                           class="layui-btn layui-btn-sm ajax-form" title="修改信息">详情</a>
                        <a :href="'transportation/device/'+vo['id']" class="layui-btn layui-btn-sm layui-btn-normal"
                           title="修改信息">资源</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="layui-col-md12">
            <div id="demoa"></div>
        </div>
    </div>
</div>


<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>
<script src="/static/layuiadmin/polyfile.min.js"></script>


<!-- 百度统计 -->
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
                size: 0,
                department_id: "",
                name: "",
                seatFormData: jsonData
            }
        },
        methods: {
            getList: function (page, num, department_id, name) {
                this.$http.post('{{ url()->current() }}', {
                    "page": page,
                    'page_size': num,
                    "department_id": department_id,
                    "name": name
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.formData = res.body.data.data;
                            var that = this;
                            that.size = page > 1 ? (page - 1) * num : 0;
                            layui.use('laypage', function () {
                                var laypage = layui.laypage;
                                //执行一个laypage实例
                                laypage.render({
                                    elem: 'demoa'
                                    , count: res.body.data.count
                                    , curr: res.body.data.current_page
                                    , limit: res.body.data.page_size
                                    , layout: ['limit', 'prev', 'page', 'next', 'count', 'skip']
                                    , jump: function (obj, first) {
                                        if (!first) {
                                            //当前点击页面
                                            var curr = obj.curr;
                                            var num = obj.limit;
                                            that.getList(curr, num, department_id, name);
                                        }
                                    }
                                })
                            });
                        } else {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    }, function (res) {
                        var str = lea.msg(res.body.msg) || '服务器异常';
                        layer.msg(str);
                    });
            }

        },
        mounted: function () {
            this.$http.post('/admin/department', {}, {emulateJSON: true})
                .then(function (res) {
                    console.log(res.body.data)
                    var str = lea.msg(res.body.msg) || '服务器异常';
                    var th = this
                    var data = res.body.data
                    data[0]['spread'] = true;
                    layui.use('tree', function () {
                        layui.tree({
                            elem: '#demop' //传入元素选择器
                            , nodes: data,
                            shin: "ssss",
                            click: function (node) {
                                //  console.log(node) //node即为当前点击的节点数据
                                th.department_id = node.number;
                                console.log(th.department_id)
                            }
                        });
                    });
//                    setTimeout(() =>{
//                        window.location.href = res.body.url;
//                    },1000);
                    $(document).on("mouseover", "#demop li a", function (e) {
                        e.currentTarget.setAttribute("title", e.currentTarget.children[1].innerText)
                    })
                }, function (res) {
                    var str = lea.msg(res.body.msg) || '服务器异常';
                    layer.msg(str);
                });
            this.getList(1, 10, this.department_id, this.name);
        },

        created: function () {
            //  console.log(43)
            // this.resetFormData = this.formData;
        }
    });
</script>

</body>
</html>