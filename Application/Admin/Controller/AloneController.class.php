<?php
namespace Admin\Controller;
use Think\Controller;
class AloneController extends Controller {
    public function aloneList(){
    	$this->assign("list",json_encode(D("Alone")->aloneList()));
    	$this->display();
    }
    public function addContent()
    {
    	$id=I("get.id");
    	$name=I("get.name");
    	$this->assign("id",$id);
    	$this->assign("name",$name);
    	$this->display();
    }
    public function doAddContent()
    {
        $cid=I("post.main")["cid"];
    	$main=I("post.main");
    	$alone=I("post.alone","",false);
    	$main["date"]=time();
        $res=D("Alone")->addContent($main,$alone);
        if($res["status"]==1){
            if(D("Alone")->addContent($main,$alone)){
                $res1=D("Cate")->updateContentMark(array('id' =>$cid , ), array('is_content' => 1, ));
                if($res1["status"]==1){
                    show($res["status"],$res["message"]);
                }
                else{
                    show($res1["status"],$res1["message"]);
                }
            }
            else{
                show($res["status"],$res["message"]);
            }
        }

    }
    public function del()
    {
        $cid=I("get.cid");
        if(D("Alone")->delContent($cid)){
             M("Cate")->where("id=".$cid)->setField("is_content",0);
             show(1,"删除成功");
        }
        else{
            show(0,"删除失败");
        }
    }
    public function update()
    {
        $cid=I("get.cid");
        $name=I("get.name");
        $this->assign("name",$name);
        $this->assign("main",json_encode(M("main")->where("cid=".$cid)->find()));
        $this->assign("alone",json_encode(M("alone")->where("cid=".$cid)->find()));
        $this->display();
    }
    public function doUpdate()
    {
        $cid=I("post.main")["cid"];
        $main=I("post.main");
        $alone=I("post.alone","",false);
        $res=D("Alone")->updateContent($main,$alone);
        show($res["status"],$res["message"]);
    }
}