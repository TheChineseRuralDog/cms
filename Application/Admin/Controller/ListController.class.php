<?php
namespace Admin\Controller;
use Think\Controller;
class ListController extends Controller {
    public function listList()
    {
        // $this->assign("cateList",json_encode(D("Cate")->cateList()));
        $this->display();
    }
    public function getList()
    {
        $cid=I("get.cid");
        $lang=I("get.lang");
        $str="";
        if($lang==1){
            $str="英文";
        }
        else{
            $str="中文";
        }
        $res=D("List")->getListC($cid,$lang);
        if (empty($res)) {
            show(0,$str."网站下没有列表，请先添加");
        }
        else{
            show(1,$str."列表获取成功",$res);
        }
    }
    public function listAdd()
    {
        $this->assign("cateList",json_encode(D("Cate")->cateList()));
        $this->display();
    }
    public function cateList()
    {
        $lang=I("get.lang");
        $str="";
        if($lang==1){
            $str="英文";
        }
        else{
            $str="中文";
        }
        $res=D("Cate")->getCate2($lang,2);
        if (empty($res)) {
            show(0,$str."网站下没有栏目，请先添加");
        }
        else{
            show(1,$str."栏目列表获取成功",$res);
        }
    }
    /*
     *上传栏目缩略图
    */
    public function doUpload()
    {
        $tbpic=I("get.tbpic");
        if(!empty($tbpic)){
            unlink(".".$tbpic);
        }
        $upload=D("Image");
        $res=$upload->uploadImg();
        echo $res;
    }
    public function addList()
    {
        $main=I("post.main");
        $main["date"]=time();
        $res=D("Cate")->getTplContent(array('id' =>$main["cid"] , ));
        $list=I("post.list","",false);
        $res=D("List")->addList($main,$list);
        if($res["status"]==1){
            $mid=$res["data"];
            D("List")->updateField(array('id' =>$mid,),array('url' => "?m=chinese&c=index&a=listContent&mid=".$mid, ));
            show(1,"添加成功");
        }
        else{
            show(0,"添加失败");
        }
    }
    public function del()
    {
        $mid=I("get.mid");
        if(D("List")->del($mid)){

            show(1,"删除成功");
        }
        else{
            show(0,"删除失败");
        }
    }
    public function update()
    {
        $mid=I("get.mid");
        // dump($mid);
        // dump(D("List")->getListMainByMid($mid));
        // die();
        $this->assign("listMain",json_encode(D("List")->getListMainByMid($mid)));
        $this->assign("listContent",json_encode(D("List")->getListContentByMid($mid)));
        $this->assign("cateList",json_encode(D("Cate")->cateList()));
        $this->display();
    }
    public function doUpdate()
    {
        $main=I("post.main");
        $list=I("post.list","",false);
        $main["time"]=time();
        $res=D("List")->updateListContent($main,$list);
        if($res["status"]==1){
            show(1,"修改成功");
        }
        else{
            show(0,$res["message"]);
        }
    }
}