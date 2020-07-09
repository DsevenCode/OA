<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
    <style>
        .login-box{
            margin: 100px auto;
            padding: 10px;
            width: 400px;
            border-radius: 4px;
            box-shadow: 5px 5px 20px #444;
        }
        .layui-form-label{
            /*width: 42px;*/
        }
        .vericode img{
            width: 88px;
            height: 35px;
            border:1px solid #d2d2d2;

        }
        .vericode img:hover{
            cursor: pointer;
        }
    </style>
    <title>后台登录页</title>
</head>
<body >
    <div class="login-box layui-form" style="background-color:#1E9FFF ">
        @csrf
        <div class="layui-form-item"><h2>通用后台管理系统</h2></div>
        <hr>
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" name="username" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密&nbsp&nbsp&nbsp&nbsp码</label>
            <div class="layui-input-block">
                <input type="password" name="pwd" class="layui-input">
            </div>
        </div>
        <div class="vericode layui-form-item">
            <label class="layui-form-label">验证码</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="vericode">
            </div>
            <img id="vericode" src="/admins/account/vericode" onclick="reload_captcha()">
        </div>
        <div class="login-btn layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" onclick="dologin()">登录/注册</button>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    layui.use(['layer'],function(){
        $ = layui.jquery;
    });
    function reload_captcha(){
        $('#vericode').attr('src','/admins/account/vericode?rand='+Math.random());
    }
    function dologin(){
        var username = $.trim($('input[name = username]').val());
        var pwd = $.trim($('input[name = pwd]').val());
        var vericode = $.trim($('input[name = vericode]').val());
        var _token = $('input[name = _token]').val();
        if(username === ''){
            return layer.alert('请输入用户名',{icon:2})
        }
        if(pwd === ''){
            return layer.alert('请输入密码',{icon:2})
        }
        if(vericode === ''){
            return layer.alert('请输入验证码',{icon:2})
        }
        $.post('/admins/account/dologin',{_token:_token,username:username,pwd:pwd,vericode:vericode},
            function(res){
                if(res.code > 0){
                    return layer.alert(res.msg,{icon:2});
                }
                layer.msg(res.msg);
                setTimeout(function(){window.location.href = '/admins/home/index'},1000);
            },
            'json')
    }
</script>
