<?php 


namespace Common\Model;

use Think\Model;
/**
* 
*/
class CateModel extends Model
{

	private $_db="";

	function __construct()
	{
		$this->_db=M('cate');
	}
	//判断是否是列表栏目
	public function judgeCateList($where)
	{	
		//判断是否栏目类型
		$res=$this->getCate($where);
		$type=C("CATE_TYPE1");
		if($res["tid"]==$type["list"]){
			return revert(1,"该栏目是列表",$res);
		}
		else{
			return revert(0,"该栏目不是列表");
		}

	}
	/*
	 *获取所有子栏目id，拼装成字符串
	*/
	public function getChildID($id)
	{
		$res=$this->delChilde($id);
		$str="";
		foreach ($res as $key => $value) {
			$str=$str.$value["id"].",";
		}
		$newstr = substr($str,0,strlen($str)-1);
		return $newstr;
	}
	/*
	 *获取列表栏目的列表数
	*/
	public function getListNum($cid)
	{
		$res= $this->_db->where("id=".$cid)->find();
		return $res["list_num"];
	}
	public function getListNum1($where)
	{
		$res= $this->_db->where($where)->find();
		return $res["list_num"];
	}
	public function getTplContent($where)
	{
		$res= $this->_db->where($where)->find();
		return $res["tpl_content"];
	}
	//更改单页栏目是否有内容的标识
	public function updateContentMark($where,$data)
	{
		$res=$this->_db->where($where)->setField($data);
		if($res>0){
			return revert(1,"更新成功");
		}
		else{
			return revert(1,"更新失败，数据库繁忙");
		}
	}
	public function getCidByMark($mark)
	{
		$res= $this->_db->where("mark=".$mark)->find();
		if($res>0){
			return revert(1,"获取成功",$res["id"]);
		}
		else{
			return revert(0,"获取失败");
		}
	}
	//查询顶级栏目
	public function topCateList()
	{
		return $this->_db->alias("c")->join("type t on c.tid=t.tid ")->where("c.parent=0")->order("c.order1")->select();
	}
	//查询顶级栏目
	public function topCateList2($lang)
	{
		return $this->_db->alias("c")->join("type t on c.tid=t.tid ")->where("c.parent=0 and c.lang=".$lang ." and c.hide=1")->order("c.order1")->select();
	}
	/*
	 *底部导航
	*/
	public function topCateList1($lang)
	{
		return $this->_db->alias("c")->join("type t on c.tid=t.tid ")->where("c.parent=0 and c.hide=1 and c.bhide=1 and c.lang=".$lang)->order("c.order1")->select();
	}
	//添加栏目
	public function addCate($post)
	{
		return $this->_db->add($post);
	}
	//判断栏目标识是否存在
	public function cateMarkOnly($mark)
	{
		return $this->_db->where("mark=".$mark)->select();
	}
	//删除栏目
	public function del($id)
	{
		return $this->_db->where("id=".$id)->delete();
	}
	//查询栏目
	public function getCate($where)
	{			
		return $this->_db->where($where)->find();
	}
	//查询栏目
	public function getCate1($where)
	{			
		return $this->_db->where($where)->select();
	}
	//查询栏目
	public function getCate2($lang,$tid)
	{			
		return $this->_db->where("lang=".$lang." and tid=".$tid)->select();
	}
	//更新栏目
	public function updateCate($post)
	{
		return $this->_db->save($post);
	}
	//获取子栏目
	public function delChilde($id)
	{
		$where = array('parent' =>$id ,'hide'=>1, );
		return $this->_db->where($where)->order("order1 asc")->select();
	}
	//获取所有列表栏目
	public function cateList()
	{
		$cateConfig=C("CATE_TYPE");
		$tid="";
		foreach ($cateConfig as $key => $value) {
			if($value=="列表"){
				$tid=$key;
				break;
			}
		}
		return $this->_db->where("tid=".$tid)->select();
	}
	//根据条件获取列表
	public function cateList1($where)
	{
		return $this->_db->where($where)->select();
	}

	//以下方法用于前端页面
	//顶级导航
	public function topNav()
	{
		return $this->_db->alias("c")->join("type t on c.tid=t.tid ")->where("c.parent=0 and c.hide=1")->order("c.order1")->select();
	}
	//顶级导航
	public function topNav1($lang)
	{
		return $this->_db->alias("c")->join("type t on c.tid=t.tid ")->where("c.parent=0 and c.hide=1 and c.lang=".$lang)->order("c.order1")->select();
	}
	//导航
	public function nav()
	{
		$cateList=$this->topNav();
		$cateList=childCate1($cateList);
		return $cateList;
	}
	//子菜单
	public function subMenu($id)
	{
		$id=topNode($id);
		$res=$this->_db->where("parent=".$id)->select();
		return childCate1($res);
	}
	//获取当前栏目信息
	public function currentAlone($id)
	{
		return $this->_db->where("id=".$id)->find();
	}
	//获取当前栏目显示内容的页面字段
	public function getTplByID($id)
	{
		$res=$this->_db->field("tpl_list")->where("id=".$id)->find();
		return $res["tpl_list"];
	}
	public function getTplContentByID($id)
	{
		// $id=D("List")->getCid($id);
		$res=$this->_db->field("tpl_content")->where("id=".$id)->find();
		return $res["tpl_content"];
	}
}

