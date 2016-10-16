<?php 


namespace Common\Model;

use Think\Model;
/**
* 
*/
class AloneModel extends Model
{

	private $_db="";
	private $_db1="";

	function __construct()
	{
		$this->_db=M('main');
		$this->_db1=M('alone');
	}
	//单页栏目列表（不包含内容）
	public function aloneList()
	{
		return M("cate")->where("tid=1")->select();
	}
	//添加单页内容
	public function addContent($main,$alone)
	{
		$m=$this->_db;
		$a=$this->_db1;
		$m->startTrans();//在第一个模型里启用就可以了，或者第二个也行
		$mid=$m->add($main);
		$res=$a->add($alone);
		if(!empty($res)){
			$m->commit();//成功则提交
			return revert(1,"添加成功");
		}else{
			$m->rollback();//不成功，则回滚
			return revert(0,"添加失败，数据库繁忙");;
		}
	}
	//删除内容
	public function delContent($cid)
	{
		$m=$this->_db;
		$a=$this->_db1;
		$m->startTrans();//在第一个模型里启用就可以了，或者第二个也行
		$mid=$m->where("cid=".$cid)->delete();
		$res=$a->where("cid=".$cid)->delete();
		if(!empty($res)){
			$m->commit();//成功则提交
			return true;
		}else{
			$m->rollback();//不成功，则回滚
			return false;
		}
	}
	//修改内容
	public function updateContent($main,$alone)
	{
		$m=$this->_db;
		$a=$this->_db1;
		$m->startTrans();//在第一个模型里启用就可以了，或者第二个也行
		$mid=$m->save($main);
		$res=$a->save($alone);
		if(!empty($res)){
			$m->commit();//成功则提交
			return revert(1,"更新成功");
		}else{
			$m->rollback();//不成功，则回滚
			return revert(0,"更新失败，字段没有变化");
		}
	}

	//前端方法

	//获取单页内容
	public function getAloneContent($where)
	{
		$res=$this->currentAloneContent($where);
		if($res==""){
			return revert(0,"获取内容失败");
		}
		else{
			return revert(1,"获取成功",$res);
		}
	}
	//获取当前单页内容
	public function currentAloneContent($where)		
	{
		$key=array_keys($where);
		foreach ($key as $k => $v) {
			$where1["main.".$v]=$where[$v];
		}
		$res= $this->_db->join(" alone a on a.cid=main.cid")->where($where1)->find();
		// echo $this->_db->getLastsql();
		// die();
		if(empty($res)){
			return "";
		}
		else{
			$res["date"]=date("Y-m-d H:i:s", $res["date"]);
			$res["content"]=$res["content"];//反转义
			return $res; 
		}
	}
	
}

