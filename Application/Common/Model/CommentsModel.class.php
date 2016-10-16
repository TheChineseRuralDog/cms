<?php 


namespace Common\Model;

use Think\Model;
/**
* 
*/
class CommentsModel extends Model
{

	private $_db="";
	private $join="";
	private $joinMain="";

	function __construct()
	{
		$this->_db=M('comments');
		$this->join="main";
		$this->joinMain="comments";
	}
	public function add($data)
	{
		$res=$this->_db->add($data);
		if(empty($res)){
			return revert(0,"添加失败，数据库繁忙");
		}
		else{
			return revert(1,"评论成功");
		}
	}
	public function getList($where)
	{
		$res=$this->_db->where($where)->select();
		if(empty($res)){
			return revert(0,"获取失败，数据库繁忙");
		}
		else{
			return revert(1,"获取成功",$res);
		}
	}
	// public function getList($order="desc",$where="",$page=1,$num=20)
	// {
	// 	return $this->_db->join($this->join." c on ".$this->joinMain.".mid=c.id")->where($where)->page($page,$num)->order($this->joinMain.".id ".$order)->select();
	// }
	// public function del($where)
	// {
	// 	if($_db->where($where)->delete()>0){
	// 		return revert(1,"删除成功");
	// 	}
	// 	else{
	// 		return revert(0,"删除失败");
	// 	}
	// }
	// public function getContent($where)
	// {
	// 	$res=$this->_db->where($where)->find();
	// 	if(empty($res)){
	// 		return revert(0,"获取失败,请稍后再试");
	// 	}
	// 	else{
	// 		return revert(1,"获取成功",$res["content"]);
	// 	}
	// }
}

