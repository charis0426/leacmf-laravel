
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>欢迎使用 {{ env('APP_NAME') }} 后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<style>

    .layui-form-checkbox i{
        border-left: 1px solid #d2d2d2;
    }
    .layui-input, .layui-textarea{
        padding-left:50px;
    }
    .layui-form-pane .layui-input{
        color:#fff;
    }
</style>
<body>
<div class="login">
    <div class="layui-card-header">
        {{ env('APP_NAME') }}</b>
    </div>
    <div class="layui-card">

        <div class="layui-card-body">
            <form class="layui-form  layui-form-pane">
                <div class="layui-form-item">
                    <input type="text" name="username" placeholder="请输入邮箱/手机号" autocomplete="off" class="layui-input phone-input">
                    <div class="layui-form-line"></div>
                </div>
                <div class="layui-form-item">
                    <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input pwd-input ">
                    <div class="layui-form-line"></div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-inline" style="width:60%;margin-right: 20px;">
                        <input type="text" name="captcha" maxlength="4" placeholder="验证码" autocomplete="off" class="layui-input  captcha-input">
                        <div class="layui-form-sline"></div>
                    </div>
                    <div class="layui-input-inline" style="width: calc(40% - 20px);border: 1px solid black;height: 37px;margin-right: 0px;">
                        <img src="{{captcha_src('flat')}}" alt="captcha" id="captcha-src" style="width: 100%;height: 36px;" />
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-inline" style="width: 60%;margin-right: 20px;">
                        <input type="checkbox" value="1"   name="remember"style="border:1px solid #d2d2d2;color: #f2f2f2; " > 保存登录
                    </div>
                    {{--<div class="layui-input-inline" style="width: calc(40% - 20px);margin-right: 0px;line-height:38px; ">--}}
                    {{--<p><span style="font-family:Monaco,Consolas;font-weight:300"><a href="{{ route('backpass')}}">忘记密码</a></span></p>--}}
                    {{--</div>--}}
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-normal layui-btn-fluid" lay-submit lay-filter="*">登 录</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/static/admin/layui/layui.js"></script>
<script src="/static/admin/js/jquery.min.js"></script>
<script src="/static/admin/js/common.js"></script>
<script>
    layui.use(['form', 'layer', 'element'], function () {
        var form = layui.form,
            layer = layui.layer,
            $ = layui.$;

        $('#captcha-src').click(function () {
            var str = '{{captcha_src('flat')}}';
            $(this).attr('src', str + '?' + Math.random());
        });

        form.on('submit(*)', function (data) {
            var str = data.field['username'];
            var map ={}
            if(checkEmail(str)){
                map['email'] = str;
            }else if(checkMobile(str)){
                map['mobile'] = str;
            }else{
                layer.msg("请填写正确的邮箱/手机号码");
                return false;
            }
            map['password'] = data.field['password'];
            map['captcha']  = data.field['captcha'];
            map['remember'] = data.field['remember'];
            $.post('/admin/login', map, function (res) {
                layer.msg(res.msg);
                if (res.code == 0) {
                    window.location.href = res.url;
                } else {
                    $('#captcha-src').click();
                }
            });
            return false;
        });

    });
</script>
</body>

</html>
