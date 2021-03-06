<div class="" style="width: 400px;float: left;">
    <div class="form-group">
        <blockquote class="layui-elem-quote">权限列表</blockquote>
        <select multiple="multiple" class="form-control" size="20" style="height: 420px" id="all">
            @foreach($permissions as $vo)
                <option value="{{ $vo['id'] }}" @if (in_array($vo[ 'id'],$ids)) disabled="disabled" @endif>{{
                    $vo['html'] }} {{ $vo['title'] }} [ {{ $vo['name'] }} ]
                </option>
            @endforeach
        </select>
    </div>
</div>
<div style="width: 80px;float: left;text-align: center;">
    <p style="margin-top: 180px;">
        <button class="layui-btn layui-btn-sm" id="to-right"><i class="layui-icon layui-icon-right"></i></button>
    </p>
    <p style="margin-top: 20px;">
        <button class="layui-btn layui-btn-sm" id="to-left"><i class="layui-icon layui-icon-left"></i></button>
    </p>
</div>
<div style="width: 400px;float: left;">
    <div class="form-group">
        <blockquote class="layui-elem-quote">已分配权限</blockquote>
        <select multiple="multiple" class="form-control" size="20" style="height: 420px" id="has_permissions">
            @foreach($has_permissions as $vo)
                <option value="{{ $vo['id'] }}">{{ $vo['title'] }} [ {{ $vo['name'] }} ]</option>
            @endforeach
        </select>
    </div>
</div>