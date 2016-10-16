<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link href="/Public/css/adminlogin.css" rel="stylesheet">
</head>
<body>
<form id="form">
    <h1 id="title">登录</h1>
    <div class="text">
        <input v-model="form.name" class="text" type="text" placeholder="用户名">
        <input v-model="form.pwd" class="text" type="text " placeholder="密码">
    </div>

    <input id="checkbox" v-model="form.autoLogin" type="checkbox" ><label id="checkbox_lab">自动登录</label>
    <input v-on:click="submit" id="submit" type="button" value="登录">
</form>
<script src="/Public/js/jquery-1.10.2.min.js"></script>
<script src="/Public/js/vue.min.js"></script>
<script src="/Public/js/layer.js"></script>
<script src="/Public/js/dialog.js"></script>
<script>
    var form=new Vue({
        el:"#form",
        data:{
            form:{
                name:"",
                pwd:"",
                autoLogin:false,
            }
        },
        methods:{
            submit:function() {
                if(form.form.name==""){
                    alert("请输入用户名");
                    return ;
                }
                if(form.form.pwd==""){
                    alert("请输入密码");
                    return ;
                }
                $.post("/index.php/Admin/Admin/doLogin",form.form,function(res){
                    if(res.status==1){
                        dialog.success(res.message,"/index.php?m=admin&c=admin&=index");
                    }
                    else{
                        dialog.error(res.message);
                    }
                },"json");
            }
        }
    })
</script>
</body>
</html>