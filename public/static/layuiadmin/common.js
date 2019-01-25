layui.config({
    base: '/static/layuiadmin/' //静态资源所在路径
}).extend({
    index: 'lib/index' //主入口模块
}).use('index');
var lea = {
    msg: function(msg) {
        var _msg = '';
        if (typeof msg === 'object') {
            $.each(msg, function(i, val) {
                _msg += '<li style="text-align:left;list-syle-type:square">' + val + '</li>';
            });
        } else {
            _msg = msg;
        }
        return _msg;
    }
};
/**
 * 异步url请求
 * 用户简单操作，如删除
 */
$(document).on('click', '.ajax-post', function(event) {
    event.preventDefault();
    var self = $(this);
    var url = self.attr('href') || self.data('url');
    var title = self.attr('title') || '执行该操作';
    if (!url) return false;

    if (self.attr('confirm')) {
        layer.confirm('您确定要 <span style="color:#f56954">' + title + '</span> 吗？',{offset: '200px'}, function(index) {
            $.get(url, function(res) {
                layer.msg(lea.msg(res.msg));
                setTimeout(function(){
                    window.location.reload();//页面刷新
            },1000);
            });
        });

    }
    return false;
})