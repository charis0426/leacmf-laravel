{{--<!DOCTYPE html>--}}
{{--<html lang="{{ app()->getLocale() }}">--}}

{{--<head>--}}
    {{--<meta charset="utf-8">--}}
    {{--<title>后台管理 | {{ env('APP_NAME') }}</title>--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">--}}
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    {{--<link rel="stylesheet" href="/static/admin/layui/css/layui.css">--}}
    {{--<link rel="stylesheet" href="/static/admin/plugins/font-awesome-4.7.0/css/font-awesome.min.css">--}}
    {{--<link rel="stylesheet" href="/static/admin/css/style.css">--}}
    {{--<script type="text/javascript" src="/static/admin/js/jquery.min.js"></script>--}}
    {{--@yield('style')--}}
{{--</head>--}}

{{--<body class="layui-layout-body">--}}
{{--<div class="layui-layout layui-layout-admin" layui-layout="{{ session('menu_status','open') }}">--}}
    {{--<div class="layui-header">--}}
        {{--<div class="layui-logo">--}}
            {{--<span>{{ env('APP_NAME') }} 管理系统</span>--}}
        {{--</div>--}}
        {{--<!-- 头部区域 -->--}}
        {{--<ul class="layui-nav layui-layout-left">--}}
            {{--<li class="layui-nav-item layadmin-flexible" lay-unselect>--}}
                {{--<a href="{{ route('flexible') }}" class="ajax-flexible" title="侧边伸缩">--}}
                    {{--<i class="layui-icon layui-icon-shrink-right"></i>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="layui-nav-item" lay-unselect>--}}
                {{--<a href="javascript:;" id="refresh" title="刷新数据">--}}
                    {{--<i class="layui-icon layui-icon-refresh"></i>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@role('super admin')--}}
            {{--<li class="layui-nav-item" lay-unselect>--}}
                {{--<a href="{{route('flush')}}" class="ajax-post" title="清空缓存">--}}
                    {{--<i class="fa fa-magic"></i>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endrole--}}
        {{--</ul>--}}
        {{--<ul class="layui-nav layui-layout-right">--}}
            {{--@role('super admin')--}}
            {{--<li class="layui-nav-item" lay-unselect>--}}
                {{--<a href="app/message/" layadmin-event="message">--}}
                    {{--<i class="layui-icon layui-icon-notice"></i>--}}
                    {{--<span class="layui-badge-dot"></span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endrole--}}
            {{--<li class="layui-nav-item" lay-unselect>--}}
                {{--<a href="javascript:;" class="user"><img src="{{ asset(Auth::user()->face) }}" class="layui-nav-img">{{ Auth::user()->nickname }} <i class="layui-icon layui-icon-more-vertical"></i></a>--}}
                {{--<dl class="layui-nav-child">--}}
                    {{--<dd><a href="{{ route('me') }}"><i class="fa  fa-user"></i> 个人信息</a></dd>--}}
                    {{--<hr>--}}
                    {{--<dd><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> 退出</a></dd>--}}
                {{--</dl>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</div>--}}
    {{--@php $__NAV__ = Auth::user()->getNav();@endphp--}}
    {{--<div class="aside">--}}
        {{--<div class="aside-scroll">--}}
            {{--<!-- 左侧导航区域（可配合layui已有的垂直导航） -->--}}
            {{--<ul class="aside-nav">--}}
                {{--<li class="title">导航菜单</li>--}}
                {{--@isset($__NAV__['menu']) @foreach($__NAV__['menu'] as $vo) @php parse_str($vo['param'],$param);@endphp--}}
                {{--<li>--}}
                    {{--<a target="iframe0" href="{{ route($vo['name'],$param) }}" @if (in_array($vo[ 'id'],$__NAV__[ 'parent_ids'])) class="active" @endif>--}}
                        {{--<i class="{{ isset($vo['icon'])?$vo['icon']:'fa fa-angle-right' }} fa-fw"></i> {{ $vo['title'] }}--}}
                        {{--<span>@isset($vo['_child'])<i class="fa fa-angle-left"></i>@endisset</span>--}}
                    {{--</a> @isset($vo['_child'])--}}
                        {{--<dl @if (in_array($vo[ 'id'],$__NAV__[ 'parent_ids'])) style="display: block;" @endif>--}}
                            {{--@foreach($vo['_child'] as $v) @php parse_str($v['param'],$param);@endphp--}}
                            {{--<dd><a target="iframe0" href="{{ route($v['name'],$param) }}" @if (in_array($v[ 'id'],$__NAV__[ 'parent_ids'])) class="active" @endif><i class="{{ isset($v['icon'])?$v['icon']:'fa fa-angle-right' }} fa-fw"></i> {{ $v['title']}}</a></dd>--}}
                            {{--@endforeach--}}
                        {{--</dl>--}}
                    {{--@endisset--}}
                {{--</li>--}}
                {{--@endforeach @endisset @role('super admin')--}}
                {{--<li class="title">开发者中心</li>--}}
                {{--<li><a href=""><i class="fa fa-code"></i> 缓存管理</a></li>--}}
                {{--@endrole--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="main">--}}
        {{--<div class="main-header">--}}
            {{--<div class="layui-breadcrumb">--}}
                {{--<a href="{{ route('/') }}"><i class="fa fa-dashboard"></i> 控制台</a> @if ($__NAV__['crumb']) @foreach($__NAV__['crumb'] as $vo) @php parse_str($vo['param'],$param);@endphp--}}
                {{--<a href="{{ route($vo['name'],$param) }}"><i class=<i class="fa  {{ isset($vo['icon'])?$vo['icon']:'fa-angle-right' }}"></i> {{ $vo['title'] }}</a> @endforeach @endif--}}
                {{--<a href="{{ url()->current() }}"> {{$__NAV__['self']['title']}}</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="main-content">--}}
            {{--@section('main')--}}
                {{--<div class="layui-fluid" style="padding: 0 12px;">--}}
                    {{--<div class="layui-card">--}}
                        {{--<div class="layui-card-header">{{ $__NAV__['self']['title'] }}</div>--}}
                        {{--<div class="layui-card-body">--}}
                            {{--@yield('content')--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@show--}}
            {{--<!-- 主体内容 -->--}}
                {{--<iframe src="{{route('/')}}"class="J_iframe" name="iframe0" width="100%" height="100%" allowfullscreen mozallowfullscreen webkitallowfullscreen frameborder="0" ></iframe>--}}

        {{--</div>--}}
        {{--<div class="main-footer">--}}
            {{--<!-- 底部固定区域 -->--}}
            {{--Copyright © 2016-{{ date('Y') }} 基于 LeaCMF 系统. All rights reserved.--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--<script type="text/javascript" src="/static/admin/layui/layui.js"></script>--}}
{{--<script type="text/javascript">--}}
    {{--layui.config({--}}
        {{--base: '/static/admin/js/'--}}
    {{--}).use('lea');--}}
{{--</script>--}}
{{--@yield('script')--}}
{{--</body>--}}

{{--</html>--}}





<html><head>
    <meta charset="utf-8">
    <title>layuiAdmin std</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">

    <script src="https://hm.baidu.com/hm.js?d214947968792b839fd669a4decaaffc"></script><script>
        /^http(s*):\/\//.test(location.href) || alert('请先部署到 localhost 下再访问');
    </script>
    <link id="layuicss-layer" rel="stylesheet" href="/static/layuiadmin/layui/css/modules/layer/default/layer.css?v=3.1.1" media="all"></head>
<body class="layui-layout-body" layadmin-themealias="default">

<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible"lay-unselect="" >
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect="">
                    <a href="http://www.layui.com/admin/" target="_blank" title="前台">
                        <i class="layui-icon layui-icon-website"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect="">
                    <a href="javascript:;" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect="">
                    <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach" lay-action="template/search.html?keywords=">
                </li>
                <span class="layui-nav-bar" style="left: 94px; top: 48px; width: 0px; opacity: 0;"></span></ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">

                <li class="layui-nav-item" lay-unselect="">
                    <a lay-href="app/message/index.html" layadmin-event="message" lay-text="消息中心">
                        <i class="layui-icon layui-icon-notice"></i>

                        <!-- 如果有新消息，则显示小圆点 -->
                        <span class="layui-badge-dot"></span>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect="">
                    <a href="javascript:;" layadmin-event="theme">
                        <i class="layui-icon layui-icon-theme"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect="">
                    <a href="javascript:;" layadmin-event="note">
                        <i class="layui-icon layui-icon-note"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect="">
                    <a href="javascript:;" layadmin-event="fullscreen">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>
                <li class="layui-nav-item" >
                    <a href="javascript:;">
                        <img src="{{ asset(Auth::user()->face) }}" class="layui-nav-img">{{ Auth::user()->nickname }}</a>
                    <dl class="layui-nav-child">
                        <dd><a lay-href="{{ route('me') }}">基本资料</a></dd>
                        <hr>
                        <dd><a href="{{ route('logout') }}">退出</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    @php $__NAV__ = Auth::user()->getNav();@endphp
        <!-- 侧边菜单 -->
        <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo" lay-href="home/console.html">
                    <span>layuiAdmin</span>
                </div>
                <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
                    @isset($__NAV__['menu']) @foreach($__NAV__['menu'] as $vo) @php parse_str($vo['param'],$param);@endphp
                    <li data-name="component" class="layui-nav-item">
                        @if (isset($vo['_child']))
                        <a href="javascript:;3"  lay-direction="2">
                            <i class="layui-icon layui-icon-component"></i>
                            <cite>{{ $vo['title'] }}</cite>
                            <span class="layui-nav-more">@isset($vo['_child'])@endisset</span>
                        </a>
                        @else
                        <a href="javascript:;" lay-href="{{ route($vo['name'],$param) }}" lay-direction="2">
                            <i class="layui-icon layui-icon-component"></i>
                            <cite>{{ $vo['title'] }}</cite>
                        </a>
                        @endif
                        @isset($vo['_child'])
                        <dl class="layui-nav-child" @if (in_array($vo[ 'id'],$__NAV__[ 'parent_ids']))  @endif>
                            @foreach($vo['_child'] as $v) @php parse_str($v['param'],$param);@endphp
                            @if (in_array($vo[ 'id'],$__NAV__[ 'parent_ids']))
                            <dd data-name="grid">
                                <a href="javascript:;">{{ $v['title'] }}<span class="layui-nav-more">@isset($v['_child'])@endisset</span></a>
                            </dd>
                            @else
                            <dd data-name="">
                                <a href="javascript:;" lay-href="{{ route($v['name'],$param) }}">{{ $v['title'] }}</a>
                            </dd>
                            @endif

                            @endforeach
                        </dl>
                        @endisset
                    </li>
                    @endforeach @endisset @role('super admin')
                    @endisset
                    <span class="layui-nav-bar" style="top: 438px; height: 0px; opacity: 0;"></span></ul>
            </div>
        </div>

        <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect="">
                        <a href="javascript:;" ><span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                    <span class="layui-nav-bar"></span></ul>
            </div>
            <div class="layui-tab" lay-unauto="" lay-allowclose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="home/console.html" lay-attr="home/console.html" class="layui-this"><i class="layui-icon layui-icon-home"></i><i class="layui-icon layui-unselect layui-tab-close">ဆ</i></li>
                </ul>
            </div>
        </div>


        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="{{route('/')}}" frameborder="0" class="layadmin-iframe"></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
</div>

<script src="/static/layuiadmin/layui/layui.js"></script>
<script>
    layui.config({
        base: '/static/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use('index');
    layui.use('form', function(){
        var form = layui.form;
        form.render();
    });
</script>

<!-- 百度统计 -->
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?d214947968792b839fd669a4decaaffc";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>




<style id="LAY_layadmin_theme">.layui-side-menu,.layadmin-pagetabs .layui-tab-title li:after,.layadmin-pagetabs .layui-tab-title li.layui-this:after,.layui-layer-admin .layui-layer-title,.layadmin-side-shrink .layui-side-menu .layui-nav>.layui-nav-item>.layui-nav-child{background-color:#20222A !important;}.layui-nav-tree .layui-this,.layui-nav-tree .layui-this>a,.layui-nav-tree .layui-nav-child dd.layui-this,.layui-nav-tree .layui-nav-child dd.layui-this a{background-color:#009688 !important;}.layui-layout-admin .layui-logo{background-color:#20222A !important;}</style></body></html>

</body>
</html>









