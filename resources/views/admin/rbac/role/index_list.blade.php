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
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <a class="layui-btn layui-btn-normal layui-btn-sm ajax-get" href=" {{route('add-role')}}" title="添加角色"><i
                        class="layui-icon">&#xe61f;</i> 添加角色</a>
        </div>
        <div class="layui-col-md12">
            <table class="layui-table  text-center" lay-size="sm">
                <tbody>
                <tr>
                    <th style="width: 48px">#</th>
                    <th>
                        <div class="text-left">角色标题</div>
                    </th>
                    <th>
                        <div class="text-left">角色名称</div>
                    </th>
                    <th style="width:40%" class="text-left">
                        说明
                    </th>
                    <th>操作</th>
                </tr>
                @foreach ($record as $vo)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="text-left">{{ $vo['title'] }}</div>
                        </td>
                        <td>
                            <div class="text-left"> {{ $vo['name'] }}</div>
                        </td>
                        <td>{{ $vo['remark'] }}</td>
                        <td>
                            <a href="{{ route('edit-role',['id'=>$vo['id']]) }}"
                               class="layui-btn layui-btn-xs ajax-form" title="修改">修改</a>
                            <a href="{{ route('assign-permission',['id'=>$vo['id']]) }}"
                               class="layui-btn layui-btn-xs layui-btn-normal" title="权限">权限</a>
                            <a href="{{ route('delete-role',['id'=>$vo['id']]) }}" title="删除" confirm="1"
                               class="layui-btn layui-btn-xs layui-btn-danger ajax-post">删除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="/static/layuiadmin/layui/layui.js"></script>
<script src="/static/layuiadmin/jquery.min.js"></script>
<script src="/static/layuiadmin/common.js"></script>


<!-- 百度统计 -->
<script>
</script>
</body>
</html>