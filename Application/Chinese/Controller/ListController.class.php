<?php
namespace Chinese\Controller;
use Think\Controller;
class ListController extends Controller {
    public function getList()
    {
        //根据栏目id，获取列表
        $mark=I("get.mark");
        $cid=I("get.cid");
        $order=empty(I("get.order"))?"desc":I("get.order");
        $page=I("get.page");
        if(empty($mark)&&empty($cid)){
            show(0,"参数错误");
        }
        if(empty($cid)){
            $res=D("Cate")->getCidByMark($mark);
            $cid=$res["data"];
        }
        $res=D("Cate")->judgeCateList(array('id' =>$cid , ));
        if($res["status"]==1){
            $num=D("Cate")->getListNum($cid);
            D("List")->updateCid($cid);
            $str=D("List")->getCid1($cid);
            $str=$str.$cid;

            $where["cid"] = array('exp', 'IN('.$str.')' );
            $res=D("List")->getList($where,$page,$num,$order);
            foreach ($res as $key => $value) {
                $res[$key]["date"]=date("Y-m-d",$value["date"]);
            }
            if(empty($res)){
                show(0,"数据获取失败，请稍后再试");
            }
            else{
                show(1,"获取成功",$res);
            }
            
        }
        else{
            show(0,"获取失败,该栏目不是列表");
        }
    }
    public function getListContent()
    {
        $mid=I("get.mid");
        $res=D("List")->getList(array('main.id' =>$mid , ));
        show(1,"获取成功",$res[0]);
    }
    public function getHotList()
    {
        //根据栏目id，获取列表
        $mark=I("get.mark");
        $cid=I("get.cid");
        $order=empty(I("get.order"))?"desc":I("get.order");
        $page=I("get.page");
        if(empty($mark)&&empty($cid)){
            show(0,"参数错误");
        }
        if(empty($cid)){
            $res=D("Cate")->getCidByMark($mark);
            $cid=$res["data"];
        }
        $res=D("Cate")->judgeCateList(array('id' =>$cid , ));
        if($res["status"]==1){
            $res=$this->getChildId($cid);

            $num=D("Cate")->getListNum($cid);
            $where['cid']  = array('exp',' IN ('.$res.') ');
            $where['hot']  = array('exp',' = 1');
            $res=D("List")->getList($where,$page,$num,$order);
            foreach ($res as $key => $value) {
                $res[$key]["date"]=date("Y-m-d",$value["date"]);
            }
            if(empty($res)){
                show(0,"数据获取失败，请稍后再试");
            }
            else{
                show(1,"获取成功",$res);
            }
            
        }
        else{
            show(0,"获取失败,该栏目不是列表");
        }
    }
    private function getChildId($cid)
    {
        $res=D("Cate")->getChildID($cid);
        return $res;
    }
    private function layoutInit($cid=0)
    {
        $this->assign("cid",json_encode($cid));
    	$this->assign("cate",json_encode(D("Cate")->topNav()));
    }
}