<?php

	//返回信息
	function show($status,$message,$data=''){
		$result = array(
			'status' =>$status , 
			'message' =>$message , 
			'data' =>$data , 
		);
		exit(json_encode($result));
	}
    //模型返回犯法
    function revert($status,$message,$data='')
    {
        $result = array(
            'status' =>$status , 
            'message' =>$message , 
            'data' =>$data , 
        );
        return $result;
    }

	//核对验证码
	function check_verify($code,$id=""){
	    $verify=new \Think\Verify();
	    return $verify->check($code,$id);
	}
	//返回登录用户信息
	function userInfo(){
        if(empty(session("userInfo"))){
            return json_encode("");
        }
        else{
           return json_encode(session("userInfo"));
        }
    }
    //更新用户session
    function updateUserInfoSession($id="")
    {
    	if(empty($id)){
            $userInfo=session("userInfo");
    		$id=$userInfo["id"];
    	}
    	$userInfo=M("user")->where("id=".$id)->find();
    	session("userInfo",$userInfo);
    }
    //循环找当前栏目节点的子节点
    function childCate($cate)
    {
        if(empty($cate)){
            return null;
        }
        foreach ($cate as $key => $value) {
            $res=M("cate")->alias("c")->join("type t on c.tid=t.tid ")->where("c.parent=".$value["id"])->order("c.order1")->select();
            $cate[$key]["child"]=childCate($res);
        }
        return $cate;
    }
    //循环找当前栏目节点的子节点,隐藏不显示
    function childCate2($cate)
    {
        if(empty($cate)){
            return null;
        }
        foreach ($cate as $key => $value) {
            $res=M("cate")->alias("c")->join("type t on c.tid=t.tid ")->where("c.parent=".$value["id"]." and c.hide=1")->order("c.order1")->select();
            $cate[$key]["child"]=childCate($res);
        }
        return $cate;
    }
    //循环找当前栏目节点的子节点,并修改成前端页面可以使用的
    function childCate1($cate)
    {
        if(empty($cate)){
            return null;
        }
        foreach ($cate as $key => $value) {
            $res=M("cate")->alias("c")->join("type t on c.tid=t.tid ")->where("c.parent=".$value["id"])->order("c.order1")->select();
            foreach ($res as $k => $v) {
                $res[$k]["url"]="index.php?m=Home&c=".C('MODULAR')[$v["tid"]]."&a=index&id=".$v["id"];
            }
            $cate[$key]["child"]=childCate1($res);
        }
        return $cate;
    }
    //找到顶级节点
    function topNode($id)
    {      
        $res=M("cate")->where("id=".$id)->find();
        if($res["parent"]==0){
            return $id;
        }
        else{
            return topNode($res["parent"]);
        }
    }
    //上一级节点
    function lastNode($cid)
    {
        $res=M("cate")->where("id=".$cid)->find();
        return $res["parent"];
    }
?>