<?php
return array(
	//'配置项'=>'配置值'
//    "SHOW_PAGE_TRACE"=>true,
	'LOAD_EXT_CONFIG'=>'db',
	'URL_CASE_INSENSITIVE' =>true,
    'URL_MODEL'=>0,
    'MODULAR'=>array(
		    	'1' =>"alone" , 
		    	'2' =>"list" , 
		    	),
    'TPL_LIST'=>array(
				'1' =>"list_alone" , 
				'2' =>'list_list'
				),//默认栏目列表页面配置
    'TPL_CONTENT'=>array(
				'1' =>"alone_content" , 
				'2' =>'list_content'
				),//默认栏目内容页面配置
    'CATE_TYPE'=>array(
		    	'1' =>'单页' , 
		    	'2' =>'列表' , 
		    	),//栏目类型
    'CATE_TYPE1'=>array(
		    	'alone' =>1 , 
		    	'list' =>2 , 
		    	),//类型标识
    // 'LANG'=>0,
);