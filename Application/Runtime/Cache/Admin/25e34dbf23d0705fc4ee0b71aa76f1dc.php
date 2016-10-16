<?php if (!defined('THINK_PATH')) exit();?> <ul id="myTab" class="nav nav-tabs">
    <li class="active">
        <a href="#home" id="chinese" data-toggle="tab">中文</a>
    </li>
    <li>
        <a href="#senior" id="engilsh" data-toggle="tab">英文</a>
    </li>
</ul>
<div id="myTabContent" class="tab-content">

    <select v-model="cateMark" class="form-control" id="news_cate" v-on:change="getList">
        <option selected value="0">请选择栏目</option>
        <option v-for="i in cateList" value="{{i.id}}">{{i.name}}</option>
    </select>
    <table id="news_list" class="table table-striped">
        <tr>
            <td>标题</td>
            <td>所属栏目</td>
            <td>作者</td>
            <td>操作</td>
        </tr>
        <tr v-for="i in newsList" data-id="{{i.id}}" data-cid="{{i.cate}}">
            <td>{{i.title}}</td>
            <td>{{i.name}}</td>
            <td>{{i.author}}</td>
            <td data-mid={{i.id}}>
                <a @click="update">修改</a>
                <a v-on:click="del" >删除</a>
            </td>
        </tr>
    </table>

    
</div> 

<script>
    var newsCate=new Vue({
        el:"#news_cate",
        data:{
            cateMark:"0",
            cateList:"",
        },
        methods:{
            init:function(event){
                var cid=0;
                var lang=init.lang;
                $.getJSON("/index.php?m=Admin&c=List&a=getList",{cid:cid,lang:lang},function(res){
                    if(res.status==0){
                        dialog.error(res.message);
                    }
                    else{
                        newsList.newsList=res.data;
                    }
                });
                $.getJSON("/index.php?m=Admin&c=List&a=cateList",{lang:lang},function(res){
                    if(res.status==0){
                      alert.error(res.message);
                    }
                    else{
                      newsCate.cateList=res.data;
                    }
                });
            },
            getList:function() {
                var cid=newsCate.cateMark;
                var lang=init.lang;
                $.getJSON("/index.php?m=Admin&c=List&a=getList",{cid:cid,lang:lang},function(res){
                    newsList.newsList=res.data;
                });
            }
        }
    });
    newsCate.init();

    var newsList=new Vue({
        el:"#news_list",
        data:{
            newsList:"",
        },
        methods:{
            del:function(event){
                var mid=event.currentTarget.parentNode.dataset.mid;
                $.get("/index.php?m=Admin&c=List&a=del",{mid:mid},function(res) {
                    if(res.status==1){
                        dialog.successFun(res.message,function() {
                            nav.list();
                        });
                    }
                    else{
                        dialog.error(res.message);
                    }
                },"json");
            },
            update:function(event) {
                var mid=event.currentTarget.parentNode.dataset.mid;
                $.get("/index.php?m=Admin&c=List&a=update",{mid:mid},function(res) {
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
                });
            }
        }
    });
</script>
<script type="text/javascript">
    $("#chinese").click(function() {
        init.lang=0;
        newsCate.init();
    });
    $("#engilsh").click(function() {
        init.lang=1;
        newsCate.init();
    })
</script>