<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
    public function Login(){
    	$this->display();
    }
    public function doLogin()
    {
    	$name=I("post.name");
    	$pwd=I("post.pwd");
    	$autoLogin=I("post.autoLogin");
    	$admin=D("User")->getUserByName($name);
    	if(empty($admin)){
    		show(0,"用户名不存在");
    	}
    	else{
    		if ($admin["pwd"]==$pwd) {
    			if($autoLogin==true){
    				cookie('admin',$admin,7*24*3600);
    			}
    			session("admin",$admin);
    			show(1,"登录成功");
    		}
    		else{
    			show(0,"密码错误");
    		}
    	}
    }
    public function Index()
    {
    	if(empty(session("admin"))){
    		header("Content-type: text/html; charset=".C('DEFAULT_CHARSET'));
			$this->redirect("Admin/Login", array(),1,'请先登录');
    	}

    	$this->assign("user",json_encode(session("admin")));
		$this->display();    	
    }
    public function userExit()
    {
    	session("admin",null);
    	cookie("admin",null);
    	show(1,"注销成功");
    }
}