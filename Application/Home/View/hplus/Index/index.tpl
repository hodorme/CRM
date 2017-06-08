<php>if(session('?uid')==null){header('Location:/CRM/index.php/Home/index/login');return false;}</php>
<!DOCTYPE html>
<html lang='zh-CN'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>{$modular}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="__IMG__/favicon.ico"/>
    <link href="__ADDONS__/layui/css/layui.css" rel="stylesheet">
    <link href="__ADDONS__/Hplus/css/bootstrap.min.css" rel="stylesheet">
    <link href="__ADDONS__/Hplus/css/font-awesome.min.css" rel="stylesheet">
    <link href="__ADDONS__/Hplus/css/animate.min.css" rel="stylesheet">
    <link href="__ADDONS__/Hplus/css/style.min.css" rel="stylesheet">
    <link href="__CSS1__/default.css" rel="stylesheet">
    <script src="__ADDONS__/Hplus/js/jquery.min.js"></script>
    <script src="__ADDONS__/Hplus/js/bootstrap.min.js"></script>
    <script src="__ADDONS__/Hplus/js/contabs.min.js"></script>
    <script src="__ADDONS__/Hplus/js/plugins/layer/layer.min.js"></script>
    <script src="__ADDONS__/Hplus/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="__ADDONS__/Hplus/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="__ADDONS__/Hplus/js/hplus.min.js"></script>
    <script src="__ADDONS__/layui/layui.js"></script>
    <script>
        var sUserAgent = navigator.userAgent.toLowerCase();
        var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
        var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
        var bIsMidp = sUserAgent.match(/midp/i) == "midp";
        var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
        var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
        var bIsAndroid = sUserAgent.match(/android/i) == "android";
        var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
        var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
        if (!(bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) ){
            //window.location ="/";
        }else{
            //移动端调用手机版页面
            //window.location ="wap";
        }
    </script>
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <input type="hidden" id="full" value="{$full}">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i> </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header" style="height:104px;background:rgb(0, 152, 132);">
                    <div class="profile-element animated bounceIn"><a href="/CRM/index.php/Home/"><img src="__IMG__/AEG.png" style="width:130px;height:66px;margin-top:17px;"></a></div>
                    <div class="logo-element animated bounceIn"><img src="__IMG__/AEG.png" width="50"></div>
                </li>
                <li> <a href="/CRM/index.php/Home/"> <i class="fa fa-home"></i> <span class="nav-label">Home</span></a></li>
                <!--
                ww_sys_menu表中flag值说明：
                flag=1:表示是功能组，仅用于展开功能项；
                flag=2:表示是功能项，点击有链接具体功能；
                by linjc 2016-4-29
                -->
                <volist name=":initMenu(0,'EQ','1')" id="ft">
                    <li> <a class="<neq name="ft['flag']" value="1">J_menuItem</neq>" href='/CRM/index.php/Home/{$ft.url}/'><i class='fa {$ft.icon}'></i> <span>{$ft.title}</span></a>
                        <ul class="nav nav-second-level">
                            <volist name=":initMenu($ft['id'],'EQ','1')" id="sd">
                                <li> <a class="<neq name="sd['flag']" value="1">J_menuItem</neq>" href='/CRM/index.php/Home/{$sd.url}/'><i class="fa {$sd.icon} <if condition='($sd["url"] eq "Expo") or ($sd["url"] eq "Customer")'> as </if>"></i> {$sd.title}
                                    <eq name="ft['flag']" value="1"><span class="fa arrow"></span></eq></a>
                                    <ul class="nav nav-third-level">
                                        <volist name=":initMenu($sd['id'],'EQ','1')" id="td">
                                            <li> <a class="<neq name="td['flag']" value="1">J_menuItem</neq>" href='/CRM/index.php/Home/{$td.url}/'><i class='fa {$td.icon}'></i>{$td.title}</a></li>
                                        </volist>
                                    </ul>
                                </li>
                            </volist>
                        </ul>
                    </li>
                </volist>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div style="width:70%;">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary "><i class="fa fa-bars"></i></a>
                    <form role="search" class="navbar-form-custom" method="post" action="" style="display: block">
                        <div class="form-group">
                            <input type="text" placeholder="Retrieve all clients..." class="form-control" id="searchtext" name="top-search">
                        </div>
                    </form>
                    <a class=" minimalize-styl-2 btn btn-info qksearch" href="javascript://">search</a>
                    <span class="minimalize-styl-2">
                        <span id="searchinfo"></span>
                        <a href="javascript://" class="searchact"></a>
                    </span>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li><a href="javascript:;" id="feedback" style="color:orange;">Feedback</a></li>
                    <li class="dropdown"> <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#"><img alt="image" class="img-circle" width="30" height="20" <if condition="$my['portrait']"> src="/crm{$my['portrait']}" <else/> src="/crm/Uploads/touxiang.jpg" </if>/> {$my['username']}({$my['zwidname']})<b class="caret"></b> </a>
                        <ul class="dropdown-menu animated fadeInRight">
                            <li><a class="J_menuItem" href="/CRM/index.php/Home/Users/profile">personal data</a> </li>
                            <li class="divider"></li>
                            <li><a href="/CRM/index.php/Home/index/logout">logout</a> </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row content-tabs">
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabRight" data-toggle="dropdown"><i class="fa fa-forward"></i></button>
            </div>
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i></button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content"> <a href="javascript:;" class="active J_menuTab" data-id="welcome">Home</a></div>
            </nav>
            <a href="/CRM/index.php/Home/index/logout" class="roll-nav roll-right J_tabExit"> <i class="fa fa-sign-out"></i> Logout</a><a/>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="content" width="100%" height="100%" src="/CRM/index.php/Home/index/welcome" frameborder="0" data-id="welcome" seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right">&copy; 2017 AEG CRM</div>
        </div>
    </div>
    <!--右侧部分结束-->
    <!--右侧边栏开始-->
    <div id="right-sidebar">
        <div class="sidebar-container">
            <div id="tab-1" class="tab-pane active">
                <div class="sidebar-title">
                    <h3><a href="{:U('Home/index/desk')}"> <i class="fa fa-comments-o"></i> 主题设置</a></h3>
                    <small><i class="fa fa-tim"></i> 你可以从这里选择和预览主题的布局和样式，这些设置会被保存在本地，下次打开的时候会直接应用这些设置。</small> </div>
                <div class="skin-setttings">
                    <div class="title">主题设置</div>
                    <div class="setings-item"> <span>收起左侧菜单</span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu">
                                <label class="onoffswitch-label" for="collapsemenu"> <span class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span> </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item"> <span>固定顶部</span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox" id="fixednavbar">
                                <label class="onoffswitch-label" for="fixednavbar"> <span class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span> </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item"> <span> 固定宽度 </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout">
                                <label class="onoffswitch-label" for="boxedlayout"> <span class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span> </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--右侧边栏结束-->
<script>
    function refreshFrame(){
        $('.J_iframe').attr('src', $('.J_iframe').attr('src'));
    }
    function nb(url,title){
        //alert(url);
        ///*
        var o = url,
        //var l = title,
                m = $(this).data("index"),
                l = $.trim($(this).text()),
                k = true;
        if (o == undefined || $.trim(o).length == 0) {
            return false
        }
        $(".J_menuTab").each(function() {
            if ($(this).data("id") == o) {
                if (!$(this).hasClass("active")) {
                    $(this).addClass("active").siblings(".J_menuTab").removeClass("active");
                    g(this);
                    $(".J_mainContent .J_iframe").each(function() {
                        if ($(this).data("id") == o) {
                            $(this).show().siblings(".J_iframe").hide();
                            return false
                        }
                    })
                }
                k = false;
                return false
            }
        });
        if (k) {
            var p = '<a href="javascript:;" class="active J_menuTab" data-id="' + o + '">' + title + ' <i class="fa fa-times-circle"></i></a>';
            $(".J_menuTab").removeClass("active");
            var n = '<iframe class="J_iframe" name="iframe' + m + '" width="100%" height="100%" src="' + o + '" frameborder="0" data-id="' + o + '" seamless></iframe>';
            $(".J_mainContent").find("iframe.J_iframe").hide().parents(".J_mainContent").append(n);
            $(".J_menuTabs .page-tabs-content").append(p);
            g($(".J_menuTab.active"))
        }
        return false
        //*/
        //$(".J_menuTabs").append("<div class='page-tabs-content'> <a href='javascript:;' class='active J_menuTab data-id='"+url+"'>"+title+"</a> </div>");
        //$(".J_iframe").attr("src",url);
    }
    //全库搜索
    $(".qksearch").click(function(){
        var searchtext = $("#searchtext").val();
        $.ajax({
            url: "{:U('Home/Index/qksearch')}?searchtext="+searchtext,
            dataType: 'json',
            type: 'POST',
            success: function (res) {
                if (res.code == 1) {
                    $("#searchinfo").text(res.title);
                    $(".searchact").text(res.searchact);
                    $(".searchact").attr('id',res.searchid);
                } else {
                    $("#searchinfo").text(res.title);
                    $(".searchact").text(res.searchact);
                    $(".searchact").attr('id',res.searchid);
                }
            }, error: function (error) {
                layer.msg('请求错误', {icon: 2});
                console.log(error);
            }
        });
    });
    $(document).on("click","#searchasee",function(){
        var searchtext = $("#searchtext").val();
        window.open("{:U('Home/Fullcustomer/index')}?title="+searchtext,"_blank")
    });
    $(document).on("click","#searchadd",function(){
            layer.open({
                skin: 'layui-layer-lan', //默认皮肤
                type:2,
                title:'Add customer', //标题
                zIndex:99999999,
                offset: '100px',
                area: ['65%', '80%'], //宽高
                shade: 0.8,//遮罩
                zIndex:1,
                content: '{:U('Home/Customer/add')}'
            });
    });
    $(document).on("click","#feedback",function(){
        layer.open({
            skin: 'layui-layer-lan', //默认皮肤
            type:2,
            title:'Add Feedback', //标题
            zIndex:99999999,
            offset: '100px',
            area: ['65%', '80%'], //宽高
            shade: 0.8,//遮罩
            zIndex:1,
            content: '{:U('Home/Feedback/add')}'
        });
    });
</script>
</body>
</html>
