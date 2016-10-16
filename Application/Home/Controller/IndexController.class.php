<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$this->layoutInit();
    	layout("Layout/layout");
        $this->display();
    }
    private function layoutInit()
    {
    	$this->assign("topNav",json_encode(D("Cate")->topNav()));
    	$this->assign("nav",json_encode(D("Cate")->nav()));
    }
}