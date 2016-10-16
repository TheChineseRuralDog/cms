<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="/Public/css/reset.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/news.css" type="text/css">
    <script src="/Public/js/jquery-3.0.0.min.js"></script>
    <script src="/Public/js/vue.min.js"></script>
    <script src="/Public/js/layer.js"></script>
    <script src="/Public/js/dialog.js"></script>
    <script type="text/javascript" src="/Public/js/js.js"></script>
    <script type="text/javascript">
    var layoutInit=new Vue({
        data:{
            cate:<?php echo ($cate); ?>,
            cid:<?php echo ($cid); ?>,
            topCid:<?php echo ($topCid); ?>,
            cate2:<?php echo ($cate2); ?>,
            currentCate:"",
            currentCate2:"",
        },
        computed:{
            currentCate:function() {
                var arr=this.cate;
                for (var i = arr.length - 1; i >= 0; i--) {
                    arr[i].url="/index.php?m=Chinese&c=Index&a=cate&id="+arr[i].id
                    if(arr[i].id==this.topCid){
                        return arr[i];
                    }
                }
                return ""; 
            },
            currentCate2:function() {
                var arr=this.cate2;
                for (var i = arr.length - 1; i >= 0; i--) {
                    arr[i].url="/index.php?m=Chinese&c=Index&a=cate&id="+arr[i].id
                    if(arr[i].id==this.cid){
                        return arr[i];
                    }
                    for (var j = arr[i].child.length - 1; j >= 0; j--) {
                        if(arr[i].child[j].id==this.cid){
                            return arr[i].child[j];
                        }
                    }
                }
                return "";
            }
        }
    });

    </script>
</head>
<body >
<!-- oncontextmenu="return false" onselectstart="return false" -->
<div class="warp">

    <div class="header">
            <div class="logo left"><img src="/Public/images/logo.png"></div>
            <div class="top right">
                <div class="lang">
                    <span><a href="/index.php?m=chinese&c=index&a=setLang&lang=0">简体中文</a></span><span>|</span><span><a href="/index.php?m=chinese&c=index&a=setLang&lang=1">English</a></span>
                </div>

                <div class="email right"><img src="/Public/images/email.png"><span>dorcoo@dorcoo.com</span></div>
                <div class="tel right"><img src="/Public/images/tel.png"><span>0574-88167020</span></div>
            </div>


    </div>
    <div class="menu">
        <ul class="nav clear" id="nav">
            <li v-for="i in cate" class="{{i.class}}">
                <a href="{{i.url}}">{{i.name}}</a>
                <div class="nav-w">
                    <div class="section-nav1">
                        <ul>
                            <li v-for="j in i.child"><a href="/index.php?m=chinese&c=index&a=cate&id={{j.id}}">{{j.name}}</a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <script type="text/javascript">
                var nav=new Vue({
                    el:"#nav",
                    data:{
                        cate:"",
                        cid:layoutInit.topCid,
                    },
                    computed:{
                        cate:function(){
                            var arr=layoutInit.cate;
                            var obj=new Object();
                            var obj={id:0,name:"首页",url:"/index.php?m=Chinese&c=Index"};
                            if(this.cid==0){
                                obj.class="active";
                            }
                            else{
                                obj.class="";
                            }
                            for (var i = arr.length - 1; i >= 0; i--) {
                                arr[i].url="/index.php?m=Chinese&c=Index&a=cate&id="+arr[i].id
                                if(arr[i].id==this.cid){
                                    arr[i].class="active";
                                }
                                else{
                                    arr[i].class="";
                                }
                            }
                            arr.unshift(obj);
                            return arr;
                        },
                    }
                })
            </script>
        </ul>
    </div>
    <div class="banner_bottom">
        <div class="product_list ">
            <div class="left" id="nav2">
                <div class="product_list_tit">{{currentCate.name}}</div>
                <ul class="p_list">
                    <li class="p_li" v-for="i in cate">
                        <a href="{{i.url}}">{{i.name}}</a>
                        <p v-for="j in i.child" style="font-weight: normal;">
                            <a href="/index.php?m=Chinese&c=Index&a=cate&id={{j.id}}" style="">{{j.name}}</a>
                        </p>
                    </li>
                    <li>
                        <div style="margin-left: 15px;">
                            <a href="{{list.url}}"><img style="width: 220px;" src="{{list.tbpic}}" alt=""></a>
                        </div>
                    </li>
                </ul>
            </div>
            <script type="text/javascript">
                var nav2=new Vue({
                    el:"#nav2",
                    data:{
                        cate:"",
                        cid:layoutInit.cid,
                        currentCate:"",
                        pic1:"",
                        list:"",
                    },
                    computed:{
                        currentCate:function() {
                            return layoutInit.currentCate;
                        },
                        cate:function(){
                            var arr=layoutInit.cate2;
                            for (var i = arr.length - 1; i >= 0; i--) {
                                arr[i].url="/index.php?m=Chinese&c=Index&a=cate&id="+arr[i].id
                                if(arr[i].id==this.cid){
                                    arr[i].class="tit";
                                }
                                else{
                                    arr[i].class="";
                                }
                            }
                            return arr;
                        },
                        pic1:function() {
                            return layoutInit.currentCate.pic2;
                        }
                        
                    },
                    methods:{
                        getChild:function() {
                            for(var i = nav2.cate.length - 1; i >= 0; i--) {
                                id=nav2.cate[i].id;
                                $.get("/index.php?m=chinese&c=index&a=getChildCate",{i:i,id:id},function (res) {
                                    nav2.cate[res.data.i].child=res.data.res;
                                },"json")
                            }
                        },
                        getList:function() {
                            $.get("/index.php?m=Chinese&c=List&a=getHotList",{mark:21,page:1},function(res) {
                                nav2.list=res.data[0]
                            },"json");
                        },
                    }
                })
                nav2.getList();
            </script>
<!--             </ul> -->
            <div class="p_show right" id="list">
                <div class="page_now"><span><a href="/index.php?m=Chinese&c=Index">首页</a></span><span>><a href="index.php?m=Chinese&c=Index&a=cate&id=2">{{currentCate.name}}</a></span><span v-if="currentCate2Mark==1" style="text-decoration: none;color: #676869;">>{{currentCate2.name}}</span></div>
                <div class="prod_warp one clear">
                    <div class="p_show_top">
                        <p v-if="currentCate2.name!=''">{{currentCate2.name}}</p>
                    </div>
                    <div style="border-bottom: 1px solid #595959 ">
                        <div class="news_warp">
                            <ul class="news">
                                <li v-for="i in list">
                                    <p class="left" style="font-size: 1px">■&nbsp;</p>
                                    <p class="n_name left"><a href="{{i.url}}" style="color: #818181;">{{i.title}}</a></p>
                                    <p class="right">{{i.date}}</p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="page"> 
                        <p class="page_link">
                            <span class="total">共: {{listNum}} 条</span>

                            <span @click="first">首页</span>
                            <span @click="pre">上一页</span>
                            <template v-if="pageNum <3">
                            <template v-for="i in pageNum">
                                <span v-if="i !=(curentPage-1)" class="page_link_a">{{i+1}}</span>
                                <span v-if="i ==(curentPage-1)" style="background-color: #09529f;color: #fff;" class="page_link_a" >{{i+1}}</span>
                                
                            </template>
                               
                            </template>
                            <template v-else>
                                <span v-if="curentPage>3" >...</span>
                                <span @click="page" data-page="{{curentPage-2}}" v-if="curentPage>2">{{curentPage-2}}</span>
                                <span @click="page" data-page="{{curentPage-1}}" v-if="curentPage>1">{{curentPage-1}}</span>
                                <span @click="page" style="background-color: #09529f;color: #fff;" data-page="{{curentPage}}">{{curentPage}}</span>
                                <span @click="page" data-page="{{parseInt(curentPage)+1}}" v-if="curentPage<(pageNum)">{{parseInt(curentPage)+1}}</span>
                                <span @click="page" data-page="{{parseInt(curentPage)+2}}" v-if="curentPage<(pageNum-1)">{{parseInt(curentPage)+2}}</span>
                                <span  style="line-height:10px;" v-if="curentPage<(pageNum-2)">...</span>
                            </template>
                            
                            <span @click="next">下一页</span>
                            <span @click="last">末页</span>
                        </p>
                    </div>
                </div>
                <script type="text/javascript">
                    var list=new Vue({
                            el:"#list",
                            data:{
                                list:"",
                                cid:layoutInit.cid,
                                currentCate:"",
                                currentCate2:"",
                                currentCate2Mark:1,
                                listNum:<?php echo ($listNum); ?>,
                                curentPage:1,
                                num:<?php echo ($num); ?>,//一页列表数量
                                pageNum:"",
                            },
                            computed:{
                                currentCate:function() {
                                    return layoutInit.currentCate;
                                },
                                currentCate2:function() {
                                    if(layoutInit.currentCate2==""){
                                        this.currentCate2Mark=0;
                                        return layoutInit.currentCate;
                                    }
                                    else{
                                        return layoutInit.currentCate2;
                                    }
                                    
                                },
                                pageNum:function() {
                                    return Math.ceil(this.listNum/this.num);
                                },
                            },
                            methods:{
                                getList:function() {
                                    $.get("/index.php?m=Chinese&c=List&a=getList",{cid:list.cid,page:list.curentPage},function(res) {
                                        list.list=res.data
                                    },"json");
                                },
                                url:function(event) {
                                    var id=event.currentTarget.dataset.id;
                                    var arr=list.list;
                                    for (var i = arr.length - 1; i >= 0; i--) {
                                        if(arr[i].id==id){
                                            window.location.href=arr[i].url;
                                        }
                                    }                                 
                                },
                                next:function() {
                                    if(list.curentPage<list.pageNum){
                                        list.curentPage=list.curentPage+1;
                                        list.getList();
                                    }
                                },
                                pre:function() {
                                    if(list.curentPage>1){
                                        list.curentPage=list.curentPage-1;
                                        list.getList();
                                    }
                                    
                                },
                                page:function(event) {
                                    list.getList();
                                    var page=event.currentTarget.dataset.page;
                                    list.curentPage=page;
                                },
                                first:function() {
                                    list.curentPage=1;
                                    list.getList();
                                },
                                last:function() {
                                    list.curentPage=list.pageNum;
                                    list.getList();
                                }
                            }
                        });
                        list.getList();
                </script>
            </div>
            <div style="clear: both"></div>
        </div>

    </div>




<div class="footer">
            <div class="footer_main" id="footer">
                <div class="foot_menu">
                    <ul v-for="i in list">
                        <li class="tit"><a href="/index.php?m=Chinese&c=Index&a=cate&id={{i.id}}">{{i.name}}</a></li>

                        <li v-for="f in i.child"><a href="/index.php?m=Chinese&c=Index&a=cate&id={{f.id}}" title="企业简介">{{f.name}}</a></li>
                        
                    </ul>
                    
                    <ul >
                        <li class="tit">互动社区</li>
                        <div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
                    </ul>
                    <div class="foot_er left"><p>微信二维码</p><img src="/Public/images/bottom_er.png"></div>
                    <script type="text/javascript">
                        var fList=new Vue({
                            el:"#footer",
                            data:{
                                list:"",
                            },
                            methods:{
                                getList:function(res) {
                                    $.get("/index.php?m=Chinese&c=index&a=getAllCate",{},function(res) {
                                        var arr=res.data;
                                        for (var i = arr.length - 1; i >= 0; i--) {
                                            arr[i].url="/index.php?m=Chinese&c=Index&a=cate&id="+arr[i].id
                                            if(arr[i].id==this.cid){
                                                arr[i].class="active";
                                            }
                                            else{
                                                arr[i].class="";
                                            }
                                        }
                                        fList.list=arr;
                                    },"json");
                                }
                            }

                        })
                        fList.getList();
                    </script>
                </div>
            </div>
            <div class="footer_con">
                <div class="foot_con clear">
                    <div class="foot_con_fl left">版权所有©2014 宁波德科自动门科技有限公司  浙B20091223009   </div>
                    <div class="foot_con_fr right">技术支持：青柯工作室</div>
                </div>
            </div>

        </div>

</div>
<script type="text/javascript">
    $(document).ready(function(){
        var change_fun=function(){
            var b_width=$(window).width();
            if(1400<=b_width&&b_width<=1920){
                var b_change="-"+((1903-b_width)/2).toString()+"px";
                //alert(b_change);
                $(".warp").css("left",b_change);
                document.body.style.overflowX="hidden";
                //$.body.style.overflowX="hidden";
            }
            else if(b_width<1400){
                //alert("太小了");
                $(".warp").css("left","-251px");
                document.body.style.overflowX="visible";
            }

        }
        change_fun();
        $(window).resize(function(){
            change_fun();
        });
        new App().init();
    });
</script>
</body>
</html>