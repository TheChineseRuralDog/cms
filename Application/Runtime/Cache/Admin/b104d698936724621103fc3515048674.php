<?php if (!defined('THINK_PATH')) exit();?>
<style>
    .operation a{
        color: #000000;
    }
</style>
<table class="table table-striped" id="table" >
    <tr align="center">
        <td>栏目</td>
        <td>操作</td>
    </tr>
    <tr v-for="i in list" align="center">
        <td>{{i.name}}</td>
        <td class="operation">
            <a  data-id="{{i.id}}" data-name="{{i.name}}" @click="addContent" v-if="(i.is_content==0)">添加内容</a>
            <div v-else>
                <a data-id="{{i.id}}" data-name="{{i.name}}" @click="update">修改内容</a>
                <a data-id="{{i.id}}"  v-on:click="del">删除内容</a>
            </div>
        </td>
    </tr>
</table>
<script>
    var aloneList=new Vue({
        el:"#table",
        data:{
            list:<?php echo ($list); ?>
        },
        methods:{
            addContent:function(event) {
                var id=event.currentTarget.dataset.id;
                var name=event.currentTarget.dataset.name;
                $.get("/index.php?m=Admin&c=Alone&a=addContent",{id:id,name:name},function(res) {
                    $("#content").html(res);
                    editor=KindEditor.create('textarea[name="content"]',{
                        uploadJson : '/kindeditor/php/upload_json.php',
                        fileManagerJson : '/kindeditor/php/file_manager_json.php',
                        allowFileManager : true,
                    });
                });
                
            },
            del:function(event){
                var id=event.currentTarget.dataset.id;
                $.get("/index.php?m=Admin&c=Alone&a=del",{cid:id},function(res){
                    if(res.status==1){
                        dialog.toconfirm(res.message);
                        nav.aloneList();
                    }
                    else{
                        dialog.error(res.message);
                    }
                },"json");
            },
            update:function(event) {
                var id=event.currentTarget.dataset.id;
                var name=event.currentTarget.dataset.name;
                $.get("/index.php?m=Admin&c=Alone&a=update",{cid:id,name:name},function(res){
                    $("#content").html(res);
                    editor=KindEditor.create('textarea[name="content"]',{
                        uploadJson : '/kindeditor/php/upload_json.php',
                        fileManagerJson : '/kindeditor/php/file_manager_json.php',
                        allowFileManager : true,
                    });
                })
            }
        }
    });
</script>