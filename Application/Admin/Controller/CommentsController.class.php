<?php
namespace Admin\Controller;
use Think\Controller;
class CommentsController extends Controller {
    public function commentList(){
        $this->assign("list",json_encode(D("Comments")->getList()));
    	$this->display();
    }
    public function del()
    {
        $id=I("get.id");
        $res=D("Comments")->del( array('id' =>$id , ));
        show($res["status"],$res["message"]);
    }
    public function showContent()
    {
        $id=I("get.id");
        $res=D("Comments")->getContent(array('id' =>$id , ));
        $this->assign("content",($res["data"]));
        $this->display();
    }
}