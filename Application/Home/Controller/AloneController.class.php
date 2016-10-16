<?php
namespace Home\Controller;
use Think\Controller;
class AloneController extends Controller {
    public function index($id){
        $this->layoutInit();
    	$this->indexInit($id);
    	layout("Layout/layout");
        $tpl=D("Cate")->getTplByID($id);
        $this->display($tpl);
    }
    private function layoutInit()
    {
    	$this->assign("topNav",json_encode(D("Cate")->topNav()));
    	$this->assign("nav",json_encode(D("Cate")->nav()));
    }
    private function indexInit($id)
    {
        $this->assign("subMenu",json_encode(D("Cate")->subMenu($id)));
        $this->assign("aloneInfo",json_encode(D("Cate")->currentAlone($id)));
        $this->assign("aloneContent",json_encode(D("Alone")->currentAloneContent($id)));
    }
}