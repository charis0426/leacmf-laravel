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
</head>
<body layadmin-themealias="default">
<div class="layui-fluid" id="app">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="site-text site-block">
                <div class="">
                    <style type="text/css">
                        .rules select {
                            font-size: 12px;
                            border: 1px solid #eee;
                            width: 400px;
                            padding: 4px;
                            box-sizing: border-box;
                            font-family: Arial
                        }
                    </style>
                    <div class="rules">
                    </div>
                    <hr>
                    <a href="{{ route('roles') }}" class="layui-btn layui-btn-primary layui-btn-sm"><i
                                class="fa fa-history"></i> 返回</a>
                </div>
                <script src="/static/layuiadmin/layui/layui.js"></script>
                <script src="/static/layuiadmin/vue.min.js"></script>
                <script src="/static/layuiadmin/vue-resource.js"></script>
                <script src="/static/layuiadmin/jquery.min.js"></script>
                <script src="/static/layuiadmin/common.js"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        var url = "{{ url()->current() }}";
                        //更新已选未选
                        var updateRules = function () {
                            $.get(url, 'ajax=1', function (data) {
                                $('.rules').html(data);
                            });
                        };
                        updateRules();
                        //更新
                        $(document).on('click', '#to-right', function () {
                            var rules = $('#all').val();
                            if (!rules) {
                                return;
                            }
                            $.post(url, {operate: 'add', rules: rules}, function (data) {
                                if (data.code == 0) {
                                    updateRules();
                                } else {
                                    layer.msg(data.msg);
                                }
                            });
                        });
                        //更新
                        $(document).on('click', '#to-left', function () {
                            var rules = $('#has_permissions').val();
                            if (!rules) {
                                return;
                            }
                            $.post(url, {operate: 'remove', rules: rules}, function (data) {
                                if (data.code == 0) {
                                    updateRules();
                                } else {
                                    layer.msg(data.msg);
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
</body>
</html>