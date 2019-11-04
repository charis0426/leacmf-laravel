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
<div class="layui-fluid" id="app">
    <div v-show="main_info">
        <div class="layui-row" style="margin-top: 20px">
            <div class="layui-col-md12">
                <a class="layui-btn layui-btn-normal layui-btn-sm ajax-get" href=" {{route('add-admin')}}" title="添加用户"><i
                            class="layui-icon">&#xe61f;</i> 添加用户</a>
            </div>
            <div class="layui-inline layui-form-serch">
                <label class="layui-form-label-search">用户名</label>
                <div class="layui-input-inline">
                    <input type="text" v-model="username" placeholder="请输入用户名称" value="" autocomplete="off"
                           class="layui-input layui-input-search">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <button type="button" class="layui-btn layui-btn-normal layui-btn-sm"
                            @click="getList(1,department_id)">
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
                                <div class="text-left">人员名称</div>
                            </th>
                            <th>
                                <div class="text-left">性别</div>
                            </th>
                            <th>
                                <div class="text-left">部门名称</div>
                            </th>
                            <th>
                                <div class="text-left">手机号</div>
                            </th>
                            <th>
                                <div class="text-left">证件号</div>
                            </th>
                            {{--<th>--}}
                            {{--<div class="text-left">是否禁用</div>--}}
                            {{--</th>--}}
                            {{--<th class="text-left">--}}
                            {{--创建时间--}}
                            {{--</th>--}}
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(vo,id) in formData">
                            <td v-text="id+1+size">
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['nickname']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="sexMap[vo['sex']]"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['name']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['mobile']"></div>
                            </td>
                            <td>
                                <div class="text-left" v-text="vo['card_id']"></div>
                            </td>
                            {{--<td>--}}
                            {{--<button class="layui-btn layui-btn-xs layui-btn-danger" v-if="vo['status'] == 1">是</button>--}}
                            {{--<button class="layui-btn layui-btn-xs layui-btn-normal" v-else >否</button>--}}
                            {{--</td>--}}
                            {{--<td v-text="vo['created_at']"></td>--}}
                            <td>
                                {{--<a :href="'admin/edit/'+vo['id']" class="layui-btn layui-btn-xs layui-btn-normal  ajax-form" title="修改信息">修改</a>--}}
                                {{--<a href="#" class="layui-btn layui-btn-xs layui-btn-normal  ajax-form" v-if="vo['status'] == 1" @click="changeStatus(vo['username'],0)" >启用</a>--}}
                                {{--<a href="#" class="layui-btn layui-btn-xs layui-btn-danger  ajax-form" v-else @click="changeStatus(vo['username'],1)">停用</a>--}}
                                {{--<a :href="'admin/delete/'+vo['id']" title="删除" confirm="1" class="layui-btn layui-btn-xs layui-btn-danger  ajax-post">删除</a>--}}
                                <a href="javascript:;" class="layui-btn layui-btn-xs"
                                   @click="detail(vo)">详情</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="layui-col-md12">
                    <div id="demo8"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="info-detail" v-if="detail_info">
        <div class="layui-row top">
            <div class="layui-col-md6">
                资源列表
            </div>
            <div class="layui-col-md6 top-right">
                <i class="layui-icon" @click="goBack()">&#x1006;</i>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md4">
                <div class="layui-form-item">
                    <label class="layui-form-label">人员名称</label>
                    <div class="layui-input-block">
                        <input type="text" :value="info.username" autocomplete="off" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">证件号码</label>
                    <div class="layui-input-block">
                        <input type="text" :value="info.card_id" autocomplete="off" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">手机号码</label>
                    <div class="layui-input-block">
                        <input type="text" :value="info.mobile" autocomplete="off" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">部门名称</label>
                    <div class="layui-input-block">
                        <input type="text" :value="info.name" autocomplete="off" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>
                    <div class="layui-input-block">
                        <input type="text" :value="sexMap[info.sex]" autocomplete="off" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" @click="goBack()">关闭
                        </button>
                    </div>
                </div>
            </div>
            <div class="layui-col-md2 ">
                <img src="/static/img/u5185.png" style="width: 100%;margin-left: 10px;" alt="">
            </div>
        </div>
    </div>
</div>
<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/layer.js"></script>
<script src="/static/layuiadmin/vue.min.js"></script>
<script src="/static/layuiadmin/vue-resource.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>


<!-- vue -->
<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                size: 0,
                count: 0,
                curr: 0,
                username: "",
                formData: [],
                sexMap: {"0": "男", "1": "女"},
                detail_info: false,
                info: {},
                main_info: true,
                department_id: '',
                page: 1
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
            goBack: function () {
                this.detail_info = false;
                this.main_info = true;
            },
            detail: function (data) {
                this.info = data
                this.detail_info = true;
                this.main_info = false

            },
            changeStatus: function (username, status) {
                var that = this;
                this.$http.post('admin/status', {"username": username, "status": status}, {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            layer.msg(lea.msg(res.body.msg), {time: 1200}, function () {
                                that.getList(that.curr);
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
            getList: function (page, pt_id) {
                var num = this.getPage()
                this.$http.post('{{ url()->current() }}', {
                        "page": page,
                        "group_id": pt_id,
                        'page_size': num,
                        "username": this.username
                    },
                    {emulateJSON: true})
                    .then(function (res) {
                        if (res.body.code == 0) {
                            this.formData = res.body.data.data;
                            var that = this;
                            that.size = page > 1 ? (page - 1) * num : 0;
                            layui.use('laypage', function () {
                                var laypage = layui.laypage;
                                //执行一个laypage实例
                                laypage.render({
                                    elem: 'demo8'
                                    , count: res.body.data.total
                                    , curr: res.body.data.current_page
                                    , limit: num
                                    , layout: ['limit', 'prev', 'page', 'next', 'count', 'skip']
                                    , jump: function (obj, first) {
                                        if (!first) {
                                            //当前点击页面
                                            var curr = obj.curr;
                                            that.setPage(obj.limit)
                                            that.getList(curr, that.department_id);
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
                                th.getList(th.page, th.department_id);
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
            this.getList(1, "", "");
            $("#load_gif").hide();
            $("#app").show();
        },
        created: function () {
        }
    })
</script>
</body>
</html>