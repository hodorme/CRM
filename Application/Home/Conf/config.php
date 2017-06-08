<?php
return array(
	'DB_TYPE' => 'sqlsrv', // 数据库类型
	'DB_HOST' => '192.168.1.188', // 服务器地址
//	'DB_HOST' => '47.52.30.103', // 服务器地址
//    'DB_NAME' => 'sq_exhEip', // 数据库名
	 'DB_NAME' => 'AEGCRM', // 数据库名
	'DB_USER' => 'sa', // 用户名
	'DB_PWD' => 'JRadmin123', // 密码/
//	'DB_PWD' => 'sa', // 密码
	'DB_PORT' =>'1433',//数据库 允许全部访问的端口
	'DB_PREFIX' => 'AEG_', // 数据库表前缀
	'DB_CHARSET'=> 'utf8', // 字符集
	//*/
	//'URL_PATHINFO_DEPR'=>'_',
	'TMPL_TEMPLATE_SUFFIX'=>'.tpl', //设置默认后缀
	'DEFAULT_THEME'  =>'hplus', // 设置默认的模板主题
	//默认错误跳转对应的模板文件
	//'TMPL_ACTION_ERROR' => THINK_PATH . 'dispatch_jump',
	//默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => THINK_PATH . 'dispatch_jump',
	//'URL_HTML_SUFFIX'=>'shtml',
	//'TMPL_FILE_DEPR' => '_', //配置模板的目录层次
	'TMPL_PARSE_STRING' => array(
		'__STATIC__' => __ROOT__ . '/Public/static', //静态文件
		'__ADDONS__' => __ROOT__ . '/Public/Addons', //插件目录
		'__IMG__'    => __ROOT__ . '/Public/Images', //图片目录
		'__CSS__'    => __ROOT__ . '/Public/Css', //CSS目录
		'__JS__'     => __ROOT__ . '/Public/Js', //JS目录
		'__IMG1__'    => __ROOT__ . '/Application/Home/View/hplus/images', //图片目录
		'__CSS1__'    => __ROOT__ . '/Application/Home/View/hplus/css', //CSS目录
		'__AJAX__'    => __ROOT__ . '/Application/Home/View/hplus/Ajax', //CSS目录
		'__THISURL__'    => __ROOT__ . '/index.php/Home/', //CSS目录
	),
);





