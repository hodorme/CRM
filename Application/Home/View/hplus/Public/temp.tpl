<php>if(session('?uno')==null){header('Location:/CRM/index.php/Home/index/login');}</php>
<!DOCTYPE html>
<html lang='zh-CN'>
<head>
<meta charset='utf-8'>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<title>{$modular}</title>
<link rel='icon' href='/favicon.ico'>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href='//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css'rel='stylesheet' />
<link href='//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.css' rel='stylesheet' />
<link href='//cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet' />
<link href='__ADDONS__/Bootstrap/css/bootstrap.min.css' rel='stylesheet' />
<link href='__ADDONS__/Bootstrap/css/bootstrap-theme.css' rel='stylesheet' />
<link href='__ADDONS__/Bootstrap/css/bootstrap-select.css' rel='stylesheet' />
<link href='__ADDONS__/AdminLTE/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />
<link href='__ADDONS__/AdminLTE/dist/css/AdminLTE.min.css' rel='stylesheet' type='text/css' />
<link href='__ADDONS__/AdminLTE/dist/css/skins/_all-skins.min.css' rel='stylesheet' type='text/css' />
<link href='__ADDONS__/AdminLTE/plugins/morris/morris.css' rel='stylesheet' type='text/css' />
<link href='__CSS__/2015.css' rel='stylesheet' type='text/css' />
<link href='__CSS__/adm.css' rel='stylesheet' type='text/css' />
<link href='__CSS__/animate.css' rel='stylesheet' type='text/css' />
<link href='__CSS1__/default.css' rel='stylesheet' type='text/css' />
<link href="__ADDONS__/Hplus/css/bootstrap.min.css" rel="stylesheet">
<link href="__ADDONS__/Hplus/css/font-awesome.min.css" rel="stylesheet">
<link href="__ADDONS__/Hplus/css/animate.min.css" rel="stylesheet">
<link href="__ADDONS__/Hplus/css/style.min.css" rel="stylesheet">
<link href="__CSS1__/default.css" rel="stylesheet">
<script src='__JS__/data.js'></script>
<script src='__JS__/wwcms.js'></script>
<script src='/Wwedit/kindeditor.js'></script>
<script src='/Wwedit/lang/zh_CN.js'></script>
<script src='__ADDONS__/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js'></script>
<script src='__ADDONS__/AdminLTE/plugins/datatables/jquery.dataTables.min.js'></script>
<script src='__ADDONS__/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'></script>
<script src='__ADDONS__/AdminLTE/plugins/fastclick/fastclick.min.js'></script>
<script src='__ADDONS__/AdminLTE/dist/js/demo.js'></script>
<script src='__ADDONS__/AdminLTE/dist/js/app.min.js'></script>
<script src='__ADDONS__/Bootstrap/js/bootstrap.min.js'></script>
<script src='__ADDONS__/Bootstrap/js/bootstrap-select.js'></script>
<!--[if lt IE 9]>
        <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
        <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
    <![endif]-->
<script>
$(function () { 
  //$('#myModal').modal({
  //  keyboard: true
  //})
});
</script>
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i> </div>
    <div class="sidebar-collapse">
      <ul class="nav" id="side-menu">
        <block name="side-menu"></block>
      </ul>
    </div>
  </nav>
  <div id="page-wrapper" class="gray-bg">
    <div class="row content-tabs">
      <nav class="page-tabs J_menuTabs">
        <div class="page-tabs-content"> <a href="javascript:;" class="active J_menuTab" data-id="list"><block name="catalog"></block></a> </div>
      </nav>
    </div>
    <div class="row J_mainContent" id="content-main">
      <block name="main"></block>
    </div>
    <div class="footer">
      <div class="pull-right">&copy; 2016 志扬国际</div>
    </div>
  </div>
<script src="__ADDONS__/Hplus/js/jquery.min.js"></script> 
<script src="__ADDONS__/Hplus/js/bootstrap.min.js"></script> 
<script src="__ADDONS__/Hplus/js/contabs.min.js"></script> 
<script src="__ADDONS__/Hplus/js/plugins/layer/layer.min.js"></script> 
<script src="__ADDONS__/Hplus/js/plugins/pace/pace.min.js"></script>
<script src="__ADDONS__/Hplus/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="__ADDONS__/Hplus/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="__ADDONS__/Hplus/js/hplus.min.js"></script>
<script>
alert($('#top-search', window.parent.document).val());
</script>
</body>
</html>