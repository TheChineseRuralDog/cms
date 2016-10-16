<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/css/adminAdmin.css" rel="stylesheet">
    <script src="/Public/js/jquery-1.10.2.min.js"></script>
    <script src="/Public/js/vue.min.js"></script>
    <script src="/Public/js/layer.js"></script>
    <script src="/Public/js/dialog.js"></script>
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/ajaxfileupload.js"> </script>
    <script src="/kindeditor/kindeditor-all-min.js"> </script>
    <script>
        var init=new Vue({
            data:{
                user:<?php echo ($user); ?>,
                picItem:"",
                lang:0,
            }
        });
    </script>
</head>
<body>
<div class="container">
    <aside class="col-md-2">
        <div id="user">
            <h1>{{user.name}}</h1>
            <a><span class="glyphicon glyphicon-cog"></span></a>
            <a v-on:click="exit"><span class="glyphicon glyphicon-off"></span></a>
        </div>
        <script>
            var user=new Vue({
                el:"#user",
                data:{
                    user:""
                },
                computed:{
                    user:function(){
                        return init.user;
                    }
                },
                methods:{
                    exit:function(event){
                        $.get("/index.php?m=Admin&c=Admin&a=userExit",{},function(res){
                            if(res.status==1){
                                dialog.successFun(res.message,'window.location.href="/index.php?m=Admin&c=Admin&a=Login"');
                            }
                            else{
                                dialog.error("注销失败");
                            }
                        },"json")
                    }
                }
            });

        </script>

        <ul id="left_nav">
            <li class="list-unstyled" id="cate">
                <span class="glyphicon glyphicon-picture"></span><p>轮播管理</p>
                <a class="get" id="cateList"  v-on:click="bannerList">轮播列表</a>
                <a class="get" id="cateList"  v-on:click="bannerAdd">添加轮播</a>
            </li>
            <li class="list-unstyled" id="cate">
                <span class="glyphicon glyphicon-align-justify"></span><p>栏目管理</p>
                <a class="get" id="cateList"  v-on:click="cateList">栏目列表</a>
                <a class="get" id="cateAdd" v-on:click="cateAdd">添加栏目</a>
            </li>
            <li class="list-unstyled" id="content_management">
                <span class="glyphicon glyphicon-th-large"></span><p>内容管理</p>
                <a class="get" id="alone" @click="aloneList">单页内容管理</a>
                <a class="get" id="newsList" @click="list" >列表管理</a>
                <a class="get" id="newsAdd" @click="listAdd">列表添加</a>
            </li>
            <li class="list-unstyled" id="content_management">
                <span class="glyphicon glyphicon-th-large"></span><p>留言管理</p>
                <a class="get" id="alone" @click="Comments">留言查看</a>
            </li>
            <script>
                var nav=new Vue({
                    el:"#left_nav",
                    data:{},
                    methods:{
                        cateList:function() {
                            $.get("/index.php?m=Admin&c=cate&a=cateList",{},function(res) {
                                $("#content").html(res);
                            })
                        },
                        cateAdd:function() {
                            $.get("/index.php?m=Admin&c=cate&a=cateAdd",{},function(res) {
                                $("#content").html(res);
                                editor=KindEditor.create('textarea[name="content"]',{
                                    uploadJson : '/kindeditor/php/upload_json.php',
                                    fileManagerJson : '/kindeditor/php/file_manager_json.php',
                                    allowFileManager : true,
                                });
                            })
                        },
                        aloneList:function() {
                            $.get("/index.php?m=Admin&c=Alone&a=aloneList",{},function(res) {
                                $("#content").html(res);
                            })
                        },
                        list:function() {
                            $.get("/index.php?m=Admin&c=List&a=listList",{},function(res) {
                                $("#content").html(res);
                            })
                        },
                        listAdd:function() {
                            $.get("/index.php?m=Admin&c=List&a=listAdd",{},function(res) {
                                $("#content").html(res);
                                editor=KindEditor.create('textarea[id="editor_id]',{
                                    uploadJson : '/kindeditor/php/upload_json.php',
                                    fileManagerJson : '/kindeditor/php/file_manager_json.php',
                                    allowFileManager : true,
                                });
                                editor1=KindEditor.create('textarea[id="editor_id1"]',{
                                    uploadJson : '/kindeditor/php/upload_json.php',
                                    fileManagerJson : '/kindeditor/php/file_manager_json.php',
                                    allowFileManager : true,
                                });
                                editor2=KindEditor.create('textarea[id="editor_id2"]',{
                                    uploadJson : '/kindeditor/php/upload_json.php',
                                    fileManagerJson : '/kindeditor/php/file_manager_json.php',
                                    allowFileManager : true,
                                });
                            })
                        },
                        Comments:function() {
                            $.get("/index.php?m=Admin&c=Comments&a=commentList",{},function(res) {
                                $("#content").html(res);
                            })
                        },
                        bannerList:function() {
                            $.get("/index.php?m=Admin&c=Banner&a=BannerList",{},function(res) {
                                $("#content").html(res);
                            })
                        },
                        bannerAdd:function() {
                            $.get("/index.php?m=Admin&c=Banner&a=bannerAdd",{},function(res) {
                                $("#content").html(res);
                            })
                        }
                    }
                });
            </script>
        </ul>
    </aside>
    <div class="content col-md-10">
        <header>
            <p>后台管理系统</p>
        </header>
        <div id="content">

        </div >
    </div>
</div>

</body>
</html>