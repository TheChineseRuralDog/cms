<?php
namespace Admin\Controller;
use Think\Controller;
class CateController extends Controller {
    public function cateList(){
    	// $topCate=D("Cate")->topCateList();
    	// $list=childCate($topCate);
    	// $this->assign("list",json_encode($list));
    	$this->display();
    }
    public function getCate($lang=0)
    {
        $topCate=D("Cate")->topCateList2($lang);
        $list=childCate($topCate);
        if(empty($list)){
            show(0,"栏目为空，请先添加栏目","");
        }
        else{
            show(1,"获取成功",$list);
        }
    }
    public function cateAdd(){
        $id=I("get.id");
        if(empty($id)){
            $this->assign("parent",0);
        }
        else{
            $res=D("Cate")->getCate(array('id' =>$id , ));
            $this->assign("parent",json_encode($id));
            $this->assign("parentName",$res["name"]);
            $this->assign("parentMark",$res["mark"]);
        }
    	$this->assign("cateType",json_encode(M("type")->select()));
    	$this->assign("tplList",json_encode(C('TPL_LIST')));
    	$this->assign("tplContent",json_encode(C('TPL_CONTENT')));
    	$this->display();
    }
    public function doCateAdd()
    {
        $post=I("post.");
        $res=D("Cate")->cateMarkOnly(I("post.mark"));
        if(!empty($res)){
            show(0,"标识已存在");
            return;
        }
        $res=D("Cate")->addCate($post);
        if($res>0){
            show(1,"添加成功");
        }
        else{
            show(0,"添加失败");
        }
    }
    public function del()
    {
        $id=I("get.id");
        if(empty($id)){
            show(0,"参数错误");
        }
        else{
            $res=D("Cate")->delChilde($id);
            if(!empty($res)){
                show(0,"请先删除当前目录下的子栏目");
                return;
            }
            $res=D("Cate")->del($id);
            if(empty($res)){
                show(0,"删除失败");
            }
            else{
                show(1,"删除成功");
            }
        }
    }
    public function update()
    {
        $id=I("get.id");
        $res=D("Cate")->getCate(array('id' =>$id , ));
        $this->assign("form",json_encode($res));
        $this->assign("cateType",json_encode(M("type")->select()));
        $this->assign("tplList",json_encode(C('TPL_LIST')));
        $this->assign("tplContent",json_encode(C('TPL_CONTENT')));
        $this->display();
    }
    public function doUpdate()
    {
        $post=I("post.");
        $res=D("Cate")->updateCate($post);
        if($res>0){
            show(1,"更新成功");
        }
        else{
            show(0,"更新失败");
        }
    }
}