<?php
namespace English\Controller;
use Think\Controller;
class IndexController extends Controller {
    private $_lang=1;
    public function index(){
    	$this->layoutInit();
    	// layout("Layout/layout");
        $this->display();
    }
    public function cate()
    {
    	$id=I("get.id");
    	$tplList=D("Cate")->getTplByID($id);
    	$this->layoutInit($id);
        $this->display($tplList);
    }
    public function listContent()
    {
        $mid=I("get.mid");
        $res=D("List")->getCid( array('id' =>$mid , ));
        $id=$res["cid"];
        $tplContent=D("Cate")->getTplContentByID($id);
        $res=D("List")->getList( array('main.id' =>$mid , ));
        $res[0]["date"]=date('Y-m-d',$res["date"]);
        $this->layoutInit($id);
        // layout("Layout/layout");
        $this->assign("content",json_encode($res[0]));
        $this->assign("currentList",json_encode($res));
        $this->assign("mid",json_encode($mid));
        $this->display($tplContent);
    }
    public function addCommtents()
    {
        $form=I("post.form");
        $res=D("Comments")->add($form);
        show($res["status"],$res["message"],$res["data"]);
    }
    public function getComments()
    {
        $mid=I("get.mid");
        $res=D("Comments")->getList(array('mid' =>$mid , ));
        show($res["status"],$res["message"],$res['data']);
    }
    public function getBanner($mark)
    {
        $res=D("Banner")->getBid(array('mark' => $mark, ));
        $id=$res["data"]["id"];
        $res=D("Banner")->getImg(array('bid' =>$id , ));
        show($res["status"],$res["message"],$res["data"]);
    }
    private function layoutInit($cid=0)
    {
        if($cid==0){
            $this->assign("cate2",json_encode(""));
            $this->assign("topCid",json_encode(0));
        }
        else{
            $res=D("Cate")->judgeCateList(array('id' =>$cid , ));
            if($res["status"]==1){
                $num=D("Cate")->getListNum($cid);

                D("List")->updateCid($cid);
                $str=D("List")->getCid1($cid);
                $str=$str.$cid;
                $where["cid"] = array('exp', 'IN('.$str.')' );
                $listNum=D("List")->count($where);

                $this->assign("num",json_encode($num));
                $this->assign("listNum",json_encode($listNum));
            }
            $topCid=topNode($cid);
            $this->assign("topCid",json_encode($topCid));
            $cate2=D("Cate")->delChilde($topCid);
        }
        foreach ($cate2 as $key => $value) {
            $cate2[$key]["child"]=D("Cate")->delChilde($value["id"]);
        }
        $this->assign("cate2",json_encode($cate2));
        $this->assign("cid",json_encode($cid));
        $res=D("Cate")->topNav1($this->_lang);
        foreach ($res as $key => $value) {
            
            $res[$key]["child"]=D("Cate")->delChilde($value["id"]);
        }
        $this->assign("cate",json_encode($res));

    }
    public function getAllCate()
    {
        $topCate=D("Cate")->topCateList1();
        $list=childCate2($topCate);
        show(1,"获取成功",$list);
    }
    //根据栏目id，获取该栏目下的子栏目
    public function getChildCate()
    {
        $id=I("get.id");
        $i=I("get.i");
        $res=D("Cate")->delChilde($id);
        $return = array('i' =>$i ,'res'=>$res );
        show(1,"获取成功",$return);
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