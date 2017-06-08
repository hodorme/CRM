<php>if(session('?uid')==null){header('Location:/CRM/index.php/Home/index/login');return false;}</php>
<!DOCTYPE html>
<html lang='zh-CN'>
<head>
<meta charset='utf-8'>
<title>{$modular}</title>
<link rel='icon' href='/favicon.ico'>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href="__ADDONS__/layui/css/layui.css" rel="stylesheet">
<link href="__ADDONS__/Hplus/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
<link href="__ADDONS__/Hplus/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
<link href="__ADDONS__/Hplus/css/animate.min.css" rel="stylesheet">
<link href="__ADDONS__/Hplus/css/style.min862f.css?v=4.1.0" rel="stylesheet">
<link href='__CSS1__/wwhplus.css' rel='stylesheet' type='text/css' />
<script src="__ADDONS__/layui/layui.js"></script>
<script src="__ADDONS__/Hplus/js/jquery.min.js"></script>
<!--[if lt IE 9]>
<script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
	<block name="main">内容</block>
</div>
<script>
</script>
</body>
</html>