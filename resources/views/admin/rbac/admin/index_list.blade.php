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
</head>
    <body layadmin-themealias="default">
    <div class="layui-fluid">
     <div class="layui-row layui-col-space15">
         <div class="layui-col-md12">
             <a class="layui-btn layui-btn-normal layui-btn-sm ajax-get" href=" {{route('add-admin')}}" title="添加用户"><i class="layui-icon">&#xe61f;</i> 添加用户</a>
         </div>
     <div class="layui-col-md12">
        <table class="layui-table  text-center" lay-size="sm">
        <thead>
        <tr>
            <th style="width: 48px">#</th>
            <th>
                <div class="text-left">用户名</div>
            </th>
            <th>
                <div class="text-left">昵称</div>
            </th>
            <th class="text-left">
                创建时间
            </th>
            <th>操作</th>
        </tr>
        </thead>
        @foreach ($record as $vo)
        <tbody>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <div class="text-left">{{ $vo['username'] }}</div>
            </td>
            <td>
                <div class="text-left"> {{ $vo['nickname'] }}</div>
            </td>
            <td>{{ $vo['created_at'] }}</td>
            <td>
                <a href="{{ route('edit-admin',['id'=>$vo['id']]) }}" class="layui-btn layui-btn-xs layui-btn-normal  ajax-form" title="修改信息">修改</a>
                <a href="{{ route('delete-admin',['id'=>$vo['id']]) }}" title="删除" confirm="1" class="layui-btn layui-btn-xs layui-btn-danger  ajax-post">删除</a>
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