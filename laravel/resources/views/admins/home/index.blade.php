<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台主页</title>
    <link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
    <style>
        .nav{
            height: 50px;
            color: #fff;
            background-color:#1E9FFF;
            padding: 0 10px;
            line-height: 50px;
        }
        .top-account{
            float:right;
        }
        .top-account a{
            text-decoration: none;
            color: #fff;
        }
        .navtree{
            width: 200px;
            height: 500px;
            background-color:#393D49;
            display: inline-block;
        }
        .main{
            display: inline-block;
            position: absolute;
            left: 200px;
            right: 0px;
        }
        .main iframe{
            width: 100%;
            height: 500px;
        }
    </style>
</head>
<body>
    <div>
        <div class="nav">
            <span>xxxx通用后台管理系统</span>
            <div class="top-account">
                <span class="layui-icon layui-icon-username"></span>
                <span>{{$admin['real_name'].'|'.$admin['username']}}</span>
                <a href="javascript:;" onclick="logout()">退出</a>
            </div>
        </div>
        <div class="navtree">
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                @foreach($menus as $key=>$val)
                <li class="layui-nav-item">
                    <a href="javascript:;">{{$val->title}}</a>
                    <dl class="layui-nav-child">
                    @foreach($val->child as $k=>$v)
                        <dd><a href="javascript:;" onclick="firemenu(this)" controller="{{$v->controller}}" action="{{$v->action}}">{{$v->title}}</a></dd>
                    @endforeach
                    </dl>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="main">
            <iframe src="/admins/home/welcome" frameborder="0"></iframe>
        </div>
    </div>
</body>
</html>
<script>
    layui.use(['element','layer'], function()
    {
        var element = layui.element;
        $ = layui.jquery;
        var layer = layui.layui;
        var height = document.documentElement.clientHeight - 50;
        $('.navtree').height(height);
        $('iframe').height(height);
    });

    function firemenu(obj)
    {
        var controller = $(obj).attr('controller');
        var action = $(obj).attr('action');
        var url = '/admins'+'/'+controller+'/'+action;
        $('.main iframe').attr('src',url);
    }

    function logout()
    {
        layer.confirm('是否退出？',
            {btn: ['退出', '取消']},//可以无限个按钮
            function()
            {
               $.get('/admins/account/logout',{},function(res){
                   if(res.code>0){
                       return layer.alert(res.msg,{icon:2});
                   }
                   layer.msg(res.msg);
                   setTimeout(function(){window.location.href='/admins/account/login';},1000);
               },'json');
            });
    }
</script>
