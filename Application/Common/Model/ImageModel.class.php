<?php 


namespace Common\Model;

use Think\Model;
/**
* 
*/
class ImageModel extends Model
{

	private $_uploadObj="";
	private $_uploadImageData="";
	const UPLOAD='upload';

	function __construct()
	{
		$this->_uploadObj=new \Think\Upload();
		$this->_uploadObj->rootPath="./".self::UPLOAD."/";
		$this->_uploadObj->saveRule='uniqid';//设置上传头像命名规则
		$this->_uploadObj->allowExts =array('jpg','png','jpeg','gif');//设置上传图片的后缀
		$this->_uploadObj->uploadReplace  =true; //同名则替换
		$this->_uploadObj->thumbRemoveOrigin   =true; //生成缩略图后是否删除原
		$this->_uploadObj->autoSub    =true;  //是否使用子目录保存上传文
		$this->_uploadObj->subType     ='date';   //子目录创建方式，默认为hash，可以设置为hash或者date 
		$this->_uploadObj->dateFormat      ='Ymd';   //子目录方式为date的时候指定日期格式   
	}
	public function uploadImg()
	{
		$res=$this->_uploadObj->upload();
		if($res){
			// rerutn "/".self::UPLOAD."/".$res['upload']['savepath'].$res['upload']['savename'];
			return "/".self::UPLOAD."/".$res["tbpic"]["savepath"].$res["tbpic"]["savename"];
		}
	}

}

