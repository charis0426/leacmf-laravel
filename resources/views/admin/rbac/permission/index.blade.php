<html><head>
    <meta charset="utf-8">
    <title>layuiAdmin std</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
    <body><
<div class="data-list" data-url="">
    <form class="layui-form inline-form">
        <div class="pull-left">
            <div class="layui-inline">
                <button class="layui-btn layui-btn-normal layui-btn-sm ajax-form" data-url="/admin/rbac/permission/add" title="添加权限"><i class="layui-icon">&#xe61f;</i> 添加权限</button>
            </div>
        </div>
    </form>
    <div class="data">
        <p><i class="fa fa-spinner fa-spin"></i> 加载中...</p>
    </div>
</div>
</body>