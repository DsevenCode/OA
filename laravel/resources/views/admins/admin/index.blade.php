<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>账号列表</title>
    <link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body>
<div style="float:right ">
    <button class="layui-btn" onclick="add()">添加</button>
</div>
    <table class="layui-table">
        @csrf
        <thead>
            <tr>
                <td>ID</td>
                <td>username</td>
                <td>gid</td>
                <td>real_name</td>
                <td>phone</td>
                <td>lastlogin</td>
                <td>add_time</td>
                <td>status</td>
                <td>操作</td>
        </tr>
        </thead>
        <tbody>
            @foreach($lists as $list)
            <tr>
            <td>{{$list['id']}}</td>
                <td>{{$list['username']}}</td>
                <td>{{$title[$list['id']]['title']}}</td>
                <td>{{$list['real_name']}}</td>
                <td>{{$list['phone']}}</td>
                <td>{{$list['lastlogin']?date('Y-m-d',$list['lastlogin']):'0'}}</td>
                <td>{{date('Y-m-d',$list['add_time'])}}</td>
                <td>{{$list['status']}}</td>
                <td>
                    <button class="layui-btn layui-btn-xs" onclick="edit({{$list['id']}})">修改</button>
                    <button class="layui-btn layui-btn-xs layui-btn-danger" onclick="del({{$list['id']}})">注销</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
<script>
    layui.use(['layer'],function(){
        var layer = layui.layer;
         $ = layui.jquery;
    });
    function add(){
        layer.open({
            type: 2,
            title: '添加管理员',
            shadeClose: true,
            shade: false,
            maxmin: true, //开启最大化最小化按钮
            area: ['380px', '600px'],
            content: '/admins/admin/add'
        });
    }
    //修改管理员信息
    function edit(aid)
    {
        layer.open({
            type: 2,
            title: '修改管理员',
            shadeClose: true,
            shade: false,
            maxmin: true, //开启最大化最小化按钮
            area: ['380px', '600px'],
            content: '/admins/admin/edit?aid='+aid
        });
    }

    function del(aid)
    {
        layer.confirm('是否删除？',
            {btn: ['删除', '取消']},//可以无限个按钮
            function()
            {
                var _token = $('input[name=_token]').val();
                $.post('/admins/admin/del',{aid:aid,_token:_token},function(res){
                    if(res.code>0)
                    {
                        return layer.alert(res.msg,{icon:2});
                    }
                    console.log('fff');
                    layer.msg(res.msg);
                    setTimeout(function(){window.location.reload()},1000);
                },'json')
            });
    }
</script>
