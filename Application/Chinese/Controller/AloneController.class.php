<?php
namespace Chinese\Controller;
use Think\Controller;
class AloneController extends Controller {
    //获取当前栏目下的内容
    public function getAloneContent()
    {
        $cid=I("get.cid");
        $mark=I("get.mark");
        if(empty($cid)){
            $res=D("Cate")->getCidByMark($mark);
            $cid=$res["data"];
        }
        $res=$this->hasChild($cid);
        if($res["status"]==1){
            $cid=$res["data"]["id"];
        }
        $res=D("Alone")->getAloneContent(array('cid' => $cid, ));
        show($res["status"],$res["message"],$res["data"]);
    }
    //根据标识获取任意栏目下的标识
    public function getAloneContentByMark()
    {
        $cid=I("get.cid");
        $res=D("Alone")->getAloneContent($cid);
        show($res["status"],$res["message"],$res["data"]);
    }
    private function layoutInit($cid=0)
    {
        $this->assign("cid",json_encode($cid));
    	$this->assign("cate",json_encode(D("Cate")->topNav()));
    }
    /*
     判断是否有子栏目
    */
    private function hasChild($cid)
    {
        $res=D("Cate")->getCate(array('parent' =>$cid ,'hide'=>1 ));
        if(empty($res)){
            return revert(0,"没有子栏目");
        }
        else{
            return revert(1,"有子栏目",$res);
        }
    }
}