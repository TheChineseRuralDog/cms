<?php
namespace Admin\Controller;
use Think\Controller;
class BannerController extends Controller {
    public function BannerList()
    {
        $res=D("Banner")->getList("");
        $this->assign("list",json_encode($res["data"]));
        $this->display();
    }
    public function bannerAdd()
    {
        $this->display();
    }
    public function doAddBanner()
    {
        $form=I("post.form","",false);
        $mark=$form["mark"];
        $res=D("Banner")->markUnique(array('mark' =>$mark , ));
        if($res["status"]==1){
            $res=D("Banner")->add($form);
            show($res["status"],$res["message"],$res["data"]);
        }
        else{
            show($res["status"],$res["message"],$res["data"]);
        }
        
    }

    public function del()
    {
        $bid=I("get.bid");
        $res=D("Banner")->del(array('id' =>$bid , ));
        $res1=D("Banner")->delImg(array('bid' =>$bid , ));
        show($res["status"],$res["message"],$res["data"]);
    }
    public function update()
    {
        $bid=I("get.bid");
        $res=D("Banner")->getList( array('id' =>$bid , ));
        $this->assign("banner",json_encode($res["data"][0])); 
        $this->display();
    }
    public function doUpdateBanner()
    {
        $form=I("post.form","",false);
        $res=D("Banner")->update($form);
        show($res["status"],$res["message"],$res["data"]);
    }
    public function img()
    {
        $bid=I("get.bid");
        $res=D("Banner")->getImg(array('bid' =>$bid , ));
        $this->assign("imgList",json_encode($res["data"])); 
        $this->assign("bid",json_encode($bid)); 
        $this->display();
    }
    public function imgAdd()
    {
        $bid=I("get.bid");
        $this->assign("bid",json_encode($bid)); 
        $this->display();
    }
    public function doAddImg()
    {
        $form=I("post.form");
        $res=D("Banner")->addImg($form);
        show($res["status"],$res["message"],$res["data"]);
    }
    public function doUpdateImg()
    {
        $form=I("post.form","",false);
        $res=D("Banner")->updateImg($form);
        show($res["status"],$res["message"],$res["data"]);
    }
    public function imgUpdate()
    {
        $id=I("get.id");
        $res=D("Banner")->getImg(array('id' =>$id , ));
        $this->assign("form",json_encode($res["data"][0]));
        $this->display();
    }
    public function delImg()
    {
        $id=I("get.id");
        $res=D("Banner")->delImg(array('id' =>$id , ));
        show($res["status"],$res["message"],$res["data"]);
    }
    public function ajaxGetImgList()
    {
        $bid=I("get.bid");
        $res=D("Banner")->getImg(array('bid' =>$bid , ));
        show(1,"获取成功",$res["data"]);
    }
}