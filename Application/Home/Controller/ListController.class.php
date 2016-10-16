<?php
namespace Home\Controller;
use Think\Controller;
class ListController extends Controller {
    public function index($id){
        $this->layoutInit();
    	$this->indexInit($id);
    	layout("Layout/layout");
        $tpl=D("Cate")->getTplByID($id);
        $this->display($tpl);
    }
    public function content($id)
    {
        $tpl=D("Cate")->getTplContentByID($id);
        $this->layoutInit();
        $this->contentInit($id);
        layout("Layout/layout");
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
        $this->assign("cateInfo",json_encode(D("Cate")->currentAlone($id)));
        $this->assign("list",json_encode(D("List")->cateList1($id)));
    }
    private function contentInit($id)
    {
        $this->assign("content",json_encode(D("List")->content($id)));
    }
}