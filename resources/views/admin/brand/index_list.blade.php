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
    <link rel="stylesheet" href="/static/layuiadmin/style/common.css" media="all">
</head>
<body layadmin-themealias="default">
<div class="load_gif" id="load_gif"><img src="/static/img/gif4.gif" alt=""></div>
<div id="app" class="layui-fluid">
    <div v-show="info_main">
        <div class="layui-row">
            <div class="layui-inline layui-form-serch layui-form">
                <label class="layui-form-label-search">品牌名称</label>
                <div class="layui-input-inline">
                    <input type="text" v-model="key" placeholder="请输入内容" autocomplete="off" maxlength="80"
                           class="layui-input layui-input-search">
                </div>
            </div>
            <div class="layui-inline layui-form-serch layui-form">
                <label class="layui-form-label-search">所属企业</label>
                <div class="layui-input-inline">
                    <select id="p_type" value="" lay-filter="p_type" lay-verify="required">
                        <option value="">请选择所属企业</option>
                        @foreach($record as $vo)
                            <option value={{$vo['id']}}>{{$vo['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-input-inline">
                <button class="layui-btn layui-btn-normal layui-btn-sm" @click="getList(1,key)"><i class="layui-icon">&#xe615;</i>搜索</button>
            </div>

        </div>
        <div class="layui-row m-lr20">
            <div class="layui-col-md2 c-left">
                <div class="grid-demo grid-demo-bg1" style="text-align: center">组织机构</div>
                <ul id="demop"></ul>
            </div>
            <div class="layui-col-md10">
                <div class="layui-col-md12">
                    <table class="layui-table  text-center" lay-size="sm">
                        <thead>
                        <tr>
                            <th style="width: 48px">#</th>
                            <th>
                                <div class="text-left">品牌名称</div>
                            </th>
                            <th>
                                <div class="text-left">缩写</div>
                            </th>
                            <th>
                                <div class="text-left">所属企业</div>
                            </th>
                            <th>
                                <div class="text-left">商标</div>
                            </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(vo,id) in formData">
                            <td v-text="id+1+size">
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['name']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['shorthand']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['pname']"></div>
                            </td>
                            <td>
                                <div class="text-left">
                                    <img :src="vo['trademark']" alt="" style="width: 100px;height: 22px">
                                </div>
                            </td>
                            <td>
                                <button type="button" @click="queryDetail(vo)"
                                        class="layui-btn layui-btn-xs">详情
                                </button>
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
    </div>
    <div class="info-detail" v-if="detail_info">
        <div class="layui-row top">
            <div class="layui-col-md6">
                详情
            </div>
            <div class="layui-col-md6 top-right">
                <a @click="goBack()">返回</a>
            </div>
        </div>
        <div class="layui-row main">
            <div class="layui-col-md8">
                <div class="layui-form-item">
                    <label class="layui-form-label">品牌商标</label>
                    <div class="layui-input-block">
                        <img :src="info.trademark" alt="" style="height: 36px;">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">品牌名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.name" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">品牌缩写</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.shorthand" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">所属企业</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.pname" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">品牌描述</label>
                    <div class="layui-input-block">
                        <textarea name="desc" :value="info.description" class="layui-textarea"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" @click="goBack()">返回
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/layer.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>


<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                size: 0,
                formData: {},
                key: '',
                company_id: '',
                department_id: "",
                detail_info: false,
                name: "",
                info_main: true,
                info: {}
            }
        },
        methods: {
            getPage:function(){
                var limit = window.localStorage.getItem('page_size');
                if(limit != null){
                    return limit
                }
                return 10
            },
            setPage:function(num){
                var limit = window.localStorage.getItem('page_size');
                if(limit != num) {
                    window.localStorage.setItem('page_size', num);
                }
            },
            getList: function (page, name) {
                var data = {}
                if (this.company_id != '') {
                    data.id = this.company_id
                }
                if (name != '') {
                    data.name = name
                }
                if (this.department_id != '') {
                    data.department_id = this.department_id
                }
                data.page = page
                data.page_size = this.getPage()
                this.$http.post('{{ url()->current() }}', data, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.formData = res.body.data.data;
                            var that = this;
                            that.size = page > 1 ? (page - 1) * data.page_size : 0;
                            layui.use('laypage', function () {
                                var laypage = layui.laypage;
                                //执行一个laypage实例
                                laypage.render({
                                    elem: 'demoa'
                                    , count: res.body.data.count
                                    , curr: res.body.data.current_page
                                    , limit: that.getPage()
                                    , layout: ['limit', 'prev', 'page', 'next', 'count', 'skip']
                                    , jump: function (obj, first) {
                                        if (!first) {
                                            //当前点击页面
                                            var curr = obj.curr;
                                            var num = obj.limit;
                                            that.setPage(obj.limit)
                                            that.page = num;
                                            that.getList(curr, name);
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
            },
            queryDetail: function (data) {
                this.info = data;
                this.detail_info = true;
                this.info_main = false;
            },
            goBack: function () {
                this.detail_info = false;
                this.info_main = true;
            }

        },
        mounted: function () {
            this.$http.post('/admin/department', {}, {emulateJSON: true})
                .then(function (res) {
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
                                th.department_id = node.id;
                                th.getList(1, th.page, th.name);
                            }
                        });
                    });
                    $(document).on("mouseover", "#demop li a", function (e) {
                        e.currentTarget.setAttribute("title", e.currentTarget.children[1].innerText)
                    })
                }, function (res) {
                    var str = lea.msg(res.body.msg) || '服务器异常';
                    layer.msg(str);
                });
            this.getList(1, this.name);
            $("#load_gif").hide();
            $("#app").show();
        },

        created: function () {
            var that = this
            layui.use(['form'], function () {
                form = layui.form;
                form.render();
                form.on('select(p_type)', function (data) {
                    that.company_id = data.value
                })
            })

        }
    });
</script>
</body>
</html>