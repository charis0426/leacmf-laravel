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
            <div class="layui-inline layui-form-serch">
                <label class="layui-form-label-search">企业名称</label>
                <div class="layui-input-inline">
                    <input type="text" v-model="name" placeholder="请输入企业名称" maxlength="80" autocomplete="off"
                           class="layui-input layui-input-search">
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-normal layui-btn-sm" @click="getList(1,department_id,name)">
                        <i class="layui-icon">&#xe615;</i>搜索
                    </button>
                </div>
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
                            <td v-text="id+1+size">
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
                                <button type="button" @click="queryDetail(vo['id'])"
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
                    <label class="layui-form-label">企业名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.name" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">企业注册地</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.position" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">企业许可号码</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.licenses" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">许可证有效期</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.last_time" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">企业品牌</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.brands" autocomplete="off" placeholder="请输入标题"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">企业法人</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.head" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">统一社会信用代码</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.code" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">区域范围</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" :value="info.position" autocomplete="off" readonly
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" @click="goBack()">返回</button>
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
                formData: {},
                size: 0,
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
            getList: function (page, department_id, name) {
                this.$http.post('{{ url()->current() }}', {
                    "page": page,
                    'page_size': this.getPage(),
                    "department_id": department_id,
                    "name": name
                }, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.formData = res.body.data.data;
                            var that = this;
                            that.size = page > 1 ? (page - 1) * this.getPage() : 0;
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
                                            that.getList(curr, department_id, name);
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
            queryDetail: function (id) {
                this.$http.get('/admin/company/show/' + id, {emulateJSON: true})
                    .then(function (res) {
                            if (res.body.code == 0) {
                                this.info = res.body.data;
                                this.detail_info = true;
                                this.info_main = false;
                            } else {
                                var str = lea.msg(res.body.msg) || '服务器异常';
                                layer.msg(str);
                            }
                        }, function (res) {
                            var str = lea.msg(res.body.msg) || '服务器异常';
                            layer.msg(str);
                        }
                    )
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
                                th.getList(1, th.department_id, th.name);
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
            this.getList(1, this.department_id, this.name);
            $("#load_gif").hide();
            $("#app").show();
        },

        created: function () {

        }
    });
</script>
</body>
</html>