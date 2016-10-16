<?php 


namespace Common\Model;

use Think\Model;
/**
* 
*/
class ListModel extends Model
{

	private $_db="";
	private $_db1="";
	private $join="";
	private $joinMain="";
	private $str="";

	function __construct()
	{
		$this->_db=M('main');
		$this->_db1=M('list_content');
		$this->join="list_content";
		$this->$joinMain="main";
	}
	public function getCid($where)
	{
		return $this->_db->field("cid")->where($where)->find();
	}
	/*
	 *根据栏目id获取列表
	 *$page  页码
	 *$num  每一页所含个数
	 *$order 1 降序 0 升序
	*/
	public function getList($where,$page=1,$num=10,$order="desc")
	{
		return $this->_db->join("list_content c on main.id=c.mid")->where($where)->page($page,$num)->order("c.order ".$order)->select();
		// echo $this->_db->getLastsql();
	}
	/*
	 *獲取列表總數
	*/
	public function count($where)
	{
		 // $this->_db->where($where)->count();
		 // echo $this->getLastsql();
		 // die();
		return $this->_db->where($where)->count();
	}
	/*
	 *更新列表内容，同时更新计算的字段
	*/
	public function updateListContent($main,$list)
	{
		$mid=$main["id"];
		$res=$this->updateList($main,$list);
		$res1=$this->updateField(array('id' =>$mid , ),array('url' =>"?m=chinese&c=index&a=listContent&mid=".$mid , ));
		if($res["status"]==0&&$res1["status"]==0){
			return revert(0,"修改失败");
		}
		else{
			return revert(1,"修改成功");
		}
	}
	/*
	 *更新要获取的列表cid
	*/
	public function updateCid($cid)
	{
		$res=D("Cate")->delChilde($cid);
		if(empty($res)){
			return "";
		}
		else{
			foreach ($res as $key => $value) {
				if($value["tid"]==2){
	                $this->str=$this->str.$value["id"].",";
	                $this->updateCid($value["id"]);
				}
            }
		}
	}
	public function getCid1()
	{
		return $this->str;
	}
	public function updateField($where,$arr)
	{
		$res=$this->_db->where($where)->setField($arr);
		if($res==true){
			return revert(1,"数据库修改成功");
		}
		else{
			return revert(0,"数据库修改失败");
		}
	}
	public function getListC($cid="",$lang=0)
	{
		if(empty($cid)||$cid==0){
			$cate=D("Cate")->getCate2($lang,2);
			$str="";
			foreach ($cate as $key => $value) {
				$str=$str.$value["id"].",";
			}
			$str=substr($str, 0,-1);
			return $this->_db->alias("m")->join("cate on m.cid=cate.id")->field("m.id,cate.name,m.author,m.title")->where("m.cid in (".$str.")")->select();
		}
		else{
			return $this->_db->alias("m")->join("cate on m.cid=cate.id")->field("m.id,cate.name,m.author,m.title")->where("m.cid=".$cid)->select();
		}
		// echo $this->_db->getLastsql();
	}
	
	public function addList($main,$list)
	{
		$m=$this->_db;
		$a=$this->_db1;
		$mid=$m->add($main);
		$list["mid"]=$mid;
		$res=$a->add($list);
		if(!empty($res)){
			return revert(1,"添加成功",$mid);
		}
		else{
			return revert(0,"数据库添加失败");
		}
	}
	public function del($mid)
	{
		$m=$this->_db;
		$l=$this->_db1;
		$m->startTrans();//在第一个模型里启用就可以了，或者第二个也行
		$m->where("id=".$mid)->delete();
		$res=$l->where("mid=".$mid)->delete();
		if(!empty($res)){
			$m->commit();//成功则提交
			return true;
		}else{
			$m->rollback();//不成功，则回滚
			return false;
		}
	}
	public function getListMainByMid($mid)
	{
		return $this->_db->where("id=".$mid)->find();
	}
	public function getListContentByMid($mid)
	{
		return $this->_db1->where("mid=".$mid)->find();
	}
	public function updateList($main,$list)
	{
		$m=$this->_db;
		$a=$this->_db1;
		$m->startTrans();//在第一个模型里启用就可以了，或者第二个也行
		$mid=$m->save($main);
		$res=$a->save($list);
		if(!empty($res)||!empty($mid)){
			$m->commit();//成功则提交
			return revert(1,"数据库修改成功",$mid);
		}else{
			$m->rollback();//不成功，则回滚
			return revert(0,"数据库修改失败");
		}
	}

	//前端页面
	//获取当前栏目下列表，当前栏目下有列表，显示当前栏目下的列表，若无，则显示所有子栏目下的列表
	public function cateList1($cid)
	{
		$list = array();
		$res=$this->_db->join("list_content c on main.id=c.mid")->where("main.cid=".$cid)->select();
		if(empty($res)){
			$subCate=D("Cate")->delChilde($cid);
			foreach ($subCate as $key => $value) {
				$res=$this->_db->join("list_content on main.id=list_content.mid")->where("main.cid=".$value["id"])->select();
				array_push($list, $res);
			}
			foreach ($list as $key => $value) {
				$res[$key]["url"]="index.php?m=Home&c=List&a=content&id=".$value["mid"];
			}
			return $list;
		}
		else{
			foreach ($res as $key => $value) {
				$res[$key]["url"]="index.php?m=Home&c=List&a=content&id=".$value["mid"];
			}
			return $res;
		}
	}
	// //获取栏目ID
	// public function getCid($id)
	// {
	// 	$res= $this->_db->field("cid")->where("id=".$id)->find();
	// 	return $res["cid"];
	// }
	//获取当前内容
	public function content($id)
	{
		$res=$this->_db->alias("m")->join("list_content c on m.id=c.mid")->where("m.id=".$id)->find();
		return $res;
	}
}

