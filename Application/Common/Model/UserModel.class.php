<?php 


namespace Common\Model;

use Think\Model;
/**
* 
*/
class UserModel extends Model
{

	private $_db="";

	// protected $_validate =array(
 //        array('name','require','用户名必须'),
 //        array('name','','用户名已存在!',0,'unique',1),
 //        array('email','email','email格式错误'),
 //    );
	function __construct()
	{
		$this->_db=M('admin');
	}
	//根绝用户名获取用户信息
	public function getUserByName($name){
		$where = array('name' =>$name , );
		$res=$this->_db->where($where)->find();
		return $res;
	}
	//添加用户
	public function addUser($user)
	{
		return $this->_db->add($user);
	}
	//根据id获取用户信息
	public function getPostInfoByUid($id)		
	{
		$postInfo["count"]=M("post")->where("uid=".$id)->count();
		return $postInfo;
	}
	//修改用户信息
	public function doEditorUserInfo($id,$post)
	{
		return $this->_db->where("id=".$id)->setField($post);
	}
	//保存用户头像
	public function saveHeadImg($headImg,$id)
	{
		return $this->_db->where("id=".$id)->setField(array('headImg' => $headImg, ));
	}
	//验证用户名是否唯一
	public function UserUnique($name)
	{
		if($this->_db->where("name=".$name)->find()){
			return false;
		}
		else{
			return true;
		}
	}
}

