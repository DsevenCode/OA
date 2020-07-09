<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>更新管理员信息</title>
    <link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="background-color: #e2e2e2">
    <form class="layui-form" style="padding-right: 20px;padding-top: 10px; ">
        @csrf
        <input type="hidden" name="aid" value="{{$list['id']}}">
        <div class="layui-form-item" >
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="username" value="{{$list['username']}}" disabled>
            </div>
        </div>
        <div class="layui-form-item" >
            <label class="layui-form-label">密&nbsp&nbsp&nbsp&nbsp码</label>
            <div class="layui-input-inline">
                <input type="password" class="layui-input" name="pwd">
            </div>
        </div>
        <div class="layui-form-item" >
            <label class="layui-form-label">确认密码</label>
            <div class="layui-input-inline">
                <input type="password" class="layui-input" name="pwd1">
            </div>
        </div>
        <div class="layui-form-item" >
            <label class="layui-form-label">用户角色</label>
            <div class="layui-input-inline">
                <select name="gid">
                    <option value=""></option>
                    @foreach($group as $val)
                    <option value="{{$val['gid']}}" {{$val['gid']==$list['gid']?'selected':''}}>{{$val['title']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item" >
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="real_name" value="{{$list['real_name']}}">
            </div>
        </div>
        <div class="layui-form-item" >
            <label class="layui-form-label">电话号码</label>
            <div class="layui-input-inline">
                <input type="text"  lay-verify="phone" class="layui-input" name="phone" value="{{$list['phone']?$list['phone']:''}}">
            </div>
        </div>
        <div class="layui-form-item" >
            <label class="layui-form-label">用户状态</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="status" lay-skin="switch" lay-text="正常|禁用" {{$list['status']?'':'checked'}}>
            </div>
        </div>
        <div class="layui-form-item" >
            <div class="layui-input-inline">
                <button type="button" class="layui-btn" onclick="save()">保存</button>
            </div>
        </div>
    </form>
</body>
</html>
<script>
    layui.use(['layer','form'],function(){
        layer = layui.layer;
        form = layui.form;
        $ = layui.jquery;
    });

    function save(){
        var username = $.trim($('input[name=username]').val());
        var pwd = $.trim($('input[name=pwd]').val());
        var pwd1 = $.trim($('input[name=pwd1]').val());
        var gid = parseInt($('select[name=gid]').val());
        var phone = $('input[name=phone]').val();
        var real_name = $.trim($('input[name=real_name]').val());
        var status = $('input[name=status]').val();
        if(username==''){
            return layer.alert('请输入用户名',{icon:2});
        }
        if(pwd!=''&&pwd!=pwd1){
            return layer.alert('两次密码不一致',{icon:2});
        }
        if(pwd1!=''&&pwd!=pwd1){
            return layer.alert('两次密码不一致',{icon:2});
        }
        if(gid==''){
            return layer.alert('请选择用户角色',{icon:2});
        }
        if(real_name==''){
            return layer.alert('请输入真实姓名',{icon:2});
        }
        if(phone==''){
            return layer.alert('请输入联系电话',{icon:2});
        }
        if(!$.isNumeric(phone)){
            return layer.alert('电话号码错误',{icon:2});
        }
        if(status==''){
            return layer.alert('请选择用户状态',{icon:2});
        }
        $.post('/admins/admin/save',$('form').serialize(),function(res){
            if(res.code>0){
                return layer.alert(res.msg,{icon:2});
            }
            layer.msg(res.msg);
            setTimeout(function(){parent.window.location.reload()},1000);
        },'json');
    }

</script>
