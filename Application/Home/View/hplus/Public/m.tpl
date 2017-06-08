<php>if(session('?uno')==null){header('Location:/CRM/index.php/Home/index/login');}</php>
<!DOCTYPE html>
<html lang='zh-CN'>
<head>
<meta charset='utf-8'>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<title>{$modular}</title>
<link rel='icon' href='/favicon.ico'>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
<link href='//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css'rel='stylesheet' type='text/css' />
<link href='//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.css' rel='stylesheet' type='text/css' />
<link href='//cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css' type='text/css' />
<link href='__ADDONS__/Bootstrap/css/bootstrap.min.css' rel='stylesheet' />
<link href='__ADDONS__/Bootstrap/css/bootstrap-theme.css' rel='stylesheet' />
<link href='__ADDONS__/Bootstrap/css/bootstrap-select.css' rel='stylesheet' />
<link href='__ADDONS__/AdminLTE/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />
<link href='__ADDONS__/AdminLTE/plugins/datatables/jquery.dataTables.css' rel='stylesheet' type='text/css' />
<link href='__ADDONS__/AdminLTE/dist/css/AdminLTE.min.css' rel='stylesheet' type='text/css' />
<link href='__ADDONS__/AdminLTE/dist/css/skins/_all-skins.min.css' rel='stylesheet' type='text/css' />
<link href='__ADDONS__/AdminLTE/plugins/morris/morris.css' rel='stylesheet' type='text/css' />
<link href='__CSS__/2015.css' rel="stylesheet" type='text/css' />
<link href='__CSS__/adm.css' rel="stylesheet" type='text/css' />
<link href='__CSS__/animate.css' rel="stylesheet" type='text/css' />
<link href='__CSS1__/default.css' rel="stylesheet" type='text/css' />
<link href="http://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.css" rel="stylesheet" type='text/css' />
<link href="__CSS1__/m.css" rel="stylesheet" type='text/css' />
<script src="http://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script src='__ADDONS__/Layer/layer.js'></script>
<script src="__ADDONS__/laypage/laypage.js"></script>
<script>
$(function () {
    /*刷新*/
    $("#btnRefresh").click(function(){
        location.reload();
    });
    /*删除提醒*/
    function _delconfig() {
        layer.msg('你确定要删除？', {
            time: 0 //不自动关闭
            ,btn: ['确认删除', '不删了']
            ,yes: function(index){
                $('#czid').val('');
                layer.close(index);
            }
        });
    }
    /*父层传值*/
    $(".taburl").click(function()
    {
        location.href=$(this).attr("url");
        var title=$(this).attr("title");
        parent.nb($(this).attr("url"),$(this).attr("title"));  //开启新的tab
    });
    /*查看*/
    $("#viewFun").click(function()
    {
        var czid = $("#czid").val();
        var url = $(this).attr("url");
        if(czid=='') {
            alert('请选择要查看的行');
        }else{
            window.open(url+"?viewid="+czid,"_self");
        }
    });
});
</script>
</head>
<body>
<div data-role="panel" id="myPanel">
    <h2>栏目</h2>
    <ul>
        <li><a href='__MYURL__List/?classid=7'>栏目1</a> </li>
    </ul>
</div>
<block name="header"></block>
<div data-role="main" class="ui-content">
    <block name="main">内容</block>
    <br><br><br>
</div>
<div data-role="footer" class="floatbar">
    <div data-role="navbar" class="menu">
        <ul>
            <li><a href="__MYURL__Member/shoppingcart"><i class="fa fa-check-square-o"></i> 任务中心</a></li>
            <li><a href="__MYURL__Member/order"><i class="fa fa-skyatlas"></i> 客户服务</a></li>
            <li><a href="__MYURL__Member"><i class="fa fa-street-view"></i> 个人中心</a></li>
        </ul>
    </div>
</div>
</body>
</html>