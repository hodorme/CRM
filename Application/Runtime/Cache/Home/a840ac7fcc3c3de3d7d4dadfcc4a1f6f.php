<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AEG_CRM 1.0</title>
    <meta name="keywords" content="3">
    <meta name="description" content="2">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/CRM/Public/Addons/Hplus/css/bootstrap.min.css" rel="stylesheet">
    <link href="/CRM/Public/Addons/Hplus/css/font-awesome.min.css" rel="stylesheet">
    <link href="/CRM/Public/Addons/Hplus/css/animate.min.css" rel="stylesheet">
    <link href="/CRM/Public/Addons/Hplus/css/style.min.css" rel="stylesheet">
    <link href="/CRM/Public/Addons/Hplus/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">
<div class="middle-box text-center loginscreen  animated fadeInDown">
    
        <div>
            <div id="imgbox" style="width:300px;height:151px;;margin-top:90px;margin-bottom:30px;">
                <img src="/CRM/Public/Images/logo.png" alt=""style="width:300px;height:151px;">
            </div>
            <h3 style='color:#3b3735;margin-bottom:20px;'>Welcome To the brand new AEG-CRM</h3>
            <form class="m-t" action='' method='post'>
                <div class="form-group">
                    <input name="uno" type="uno" class="form-control" placeholder="Name ID" required="">
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b loading">Login</button>
            </form>
        </div>
    
</div>
<script src="/CRM/Public/Addons/Hplus/js/jquery.min.js"></script>
<script src="/CRM/Public/Addons/Hplus/js/bootstrap.min.js"></script>
<script src="/CRM/Public/Addons/Hplus/js/plugins/sweetalert/sweetalert.min.js"></script>
<script>
    $(function(){
        $('#tijiao').click(function () {
            swal({
                title: "您确定要删除这条信息吗",
                text: "删除后将无法恢复，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "删除",
                closeOnConfirm: false
            }, function () {
                swal("删除成功！", "您已经永久删除了这条信息。", "success");
            });
        });
    });
</script>
</body>
</html>