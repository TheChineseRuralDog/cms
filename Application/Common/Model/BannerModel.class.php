<?php 


namespace Common\Model;

use Think\Model;
/**
* 
*/
class BannerModel extends Model
{

	private $_db="";
	private $_img="";
	private $_dbName="";
	private $_imgName="";

	function __construct()
	{
		$this->_db=M('banner');
		$this->_img=M('img');
		$this->_dbName="banner";
		$this->_imgName="img";
	}

	public function getImg($where,$page=1,$num=10,$order="asc")
	{
		$res= $this->_img->where($where)->page($page,$num)->order("sort ".$order)->select();
		if(empty($res)){
			return revert(0,"获取失败");
		}
		else{
			return revert(1,"获取成功",$res);
		}
	}
	public function getList($where,$page=1,$num=10,$order="desc")
	{
		$res= $this->_db->where($where)->page($page,$num)->order("id ".$order)->select();
		if(empty($res)){
			return revert(0,"获取失败");
		}
		else{
			return revert(1,"获取成功",$res);
		}
	}
	public function add($form)
	{
		$res=$this->_db->add($form);
		if(empty($res)){
			return revert(0,"添加失败");
		}
		else{
			return revert(1,"添加成功",$res);
		}
	}
	public function addImg($form)
	{
		$res=$this->_img->add($form);
		if(empty($res)){
			return revert(0,"添加失败");
		}
		else{
			return revert(1,"添加成功",$res);
		}
	}
	public function updateImg($form)
	{
		$res=$this->_img->save($form);
		if(empty($res)){
			return revert(0,"添加失败,没有更新项");
		}
		else{
			return revert(1,"添加成功",$res);
		}
	}
	public function update($form)
	{
		$res=$this->_db->save($form);
		if(empty($res)){
			return revert(0,"更新失败");
		}
		else{
			return revert(1,"更新成功",$res);
		}
	}
	public function markUnique($where)
	{
		$res=$this->getList($where);
		if($res["status"]==0){
			return revert(1,"标识唯一");
		}
		else{
			return revert(0,"标识已存在");
		}
	}
	public function del($where)
	{
		$res=$this->_db->where($where)->delete();
		if(empty($res)){
			return revert(0,"删除失败");
		}
		else{
			return revert(1,"删除成功",$res);
		}
	}
	public function delImg($where)
	{
		$res=$this->_img->where($where)->delete();
		if(empty($res)){
			return revert(0,"删除失败");
		}
		else{
			return revert(1,"删除成功",$res);
		}
	}
	public function getBid($where)
	{
		$res=$this->_db->field("id")->where($where)->find();
		if(empty($res)){
			return revert(0,"获取失败，服务器繁忙");
		}
		else{
			return revert(1,"获取成功",$res);
		}
	}
}

