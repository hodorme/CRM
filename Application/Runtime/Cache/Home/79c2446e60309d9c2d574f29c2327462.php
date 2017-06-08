<?php if (!defined('THINK_PATH')) exit(); if(session('?uid')==null){header('Location:/CRM/index.php/Home/index/login');return false;} ?>
<!DOCTYPE html>
<html lang='zh-CN'>
<head>
<meta charset='utf-8'>
<title><?php echo ($modular); ?></title>
<link rel="shortcut icon" href="/CRM/Public/Images/favicon.ico"/>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href='/CRM/Public/Addons/Bootstrap/css/font-awesome.min.css' rel='stylesheet' type='text/css' />
<link href='/Public/Addons/AdminLTE/dist/css/AdminLTE.min.css' rel='stylesheet' type='text/css' />
<link href='/CRM/Public/Addons/AdminLTE/dist/css/AdminLTE.min.css' rel='stylesheet' />
<link href="/CRM/Public/Addons/layui/css/layui.css" rel="stylesheet">
<link href='/CRM/Application/Home/View/hplus/css/ww2.0.css' rel='stylesheet' type='text/css' />
<script src='/CRM/Public/Js/wwcms.js'></script>
<script src='/CRM/Public/Addons/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js'></script>
<script src='/CRM/Public/Addons/AdminLTE/plugins/datatables/jquery.dataTables.min.js'></script>
<script src='/CRM/Public/Addons/Bootstrap/js/bootstrap.min.js'></script>
<script src='/CRM/Public/Addons/layui/layui.js'></script>
<script src='/CRM/Public/Addons/Laydate/laydate.js'></script>
<script src='/CRM/Public/Addons/tableExport/tableExport.js'></script>
<script>
/**
 my.js
 依赖layui的全部模块
 /**/
layui.use(['layer', 'laytpl', 'laypage', 'laydate'],function(){
    var layer = layui.layer
    ,laytpl = layui.laytpl
    ,laypage = layui.laypage
    ,laydate = layui.laydate
});
// **/
//规范公用-----------------------------------------------------------------------------------------------------------------
/*响应批量删除公用方法
* table是响应刷新的DT表格命名，如果空的话执行刷新父页面
* inputname是获取的操作id复选框name
* by wf 2016.12.5
* */
function _delMore(table,inputname) {
    var czid="";
    $("input[name='"+inputname+"']:checked").each(function (i, n) {
        if(i==0){
            douhao="";
        }else{
            douhao=",";
        }
        czid+=douhao+$(n).val();
    });
    if(!czid) {
        layer.msg('Select Line');
        return false;
    }else{
        layer.confirm('确认删除吗？', {
            title:false
            ,closeBtn:false
            ,btn: ['确认','取消'] //按钮
        }, function() {
            $.ajax({
                url: "?act=del&czid=" + czid,
                type: "post",
                success: function (res) {
                    if (res.code == 1) {
                        layer.msg(res.msg, {icon: res.code});
                        if(table){
                            table.ajax.reload(null, false);
                        }else{
                            parent.location.reload();
                        }
                    } else {
                        layer.msg(res.msg, {icon: res.code});
                    }
                }, error: function (error) {
                    layer.msg('请求错误', {icon: 2});
                    console.log(error);
                }
            });
        });
        $('#czid').val('');
    }
}
/*响应table列表页公用方法
 * table是响应刷新的DT表格命名，如果空的话执行刷新父页面
 * by wf 2016.12.5
 * */
function _layerOpenNew(url,title,wsize,hsize,table) {
    layer.open({
        skin: 'layui-layer-lan', //默认皮肤
        type:2,
        title:title, //标题
        area: [wsize, hsize], //宽高
        //closeBtn:false,
        shade: 0.5,//遮罩
        zIndex:1,
        maxmin: true,  //最大最小化
        scrollbar: false,
        //content: [url,'no']
        content: [url],
        end: function() {
            $('#czid').val('');
            if(table){
                table.ajax.reload(null, false);
            }
        }
    });
}
/*响应弹出新窗口*/
function _view(url) {
    var czid=$("#czid").val();
    if(czid=='') {
        layer.msg('请选择要查看的行', function(){});
        return false;
    }else{
        window.open(url+"?czid="+czid,"_blank");
    }
}
//规范公用 by wf 2016.12.5-----------------------------------------------------------------------------------------------------------------
$(function () {
    //规范公用 by wf 2016.12.5-----------------------------------------------------------------------------------------------------------------
    //按钮-页面刷新
    $(".refreshBtn").click(function(){
        location.reload();
    });
    //按钮-弹窗关闭
    $(".closeBtn").click(function(){
        var index=parent.layer.getFrameIndex(window.name); //获取窗口索引
        parent.layer.close(index);
    });
    //查看会员信息
    $(document).on("click",".mviewBtn",function(){
        var czid=$(this).attr("id");
        _layerOpen('../Member/add?czid='+czid+"&list=expoview",'查看会员信息','','');
    });
    //查看用户信息
    $(document).on("click",".uviewBtn",function(){
        var czid=$(this).attr("id");
        _layerOpen('../Users/view?czid='+czid,'查看用户信息','','');
    });
    //规范公用 by wf 2016.12.5-----------------------------------------------------------------------------------------------------------------

    //下面的代码都是垃圾-----------------------------------------------------------------------------------------------------------------
    $(".tbExbtn").click(function(){
        var extype=$(this).attr("extype");
        var tab=$(this).attr("tab");
        $(tab).tableExport({type:extype,escape:'false'});
    });
    /*刷新*/
    $("#btnRefresh").click(function(){
        location.reload();
    });
    $("#closeFun").click(function(){
        var index=parent.layer.getFrameIndex(window.name); //获取窗口索引
        //parent.location.reload();
        //parent.layer.msg('已关闭');
        parent.layer.close(index);
    });
    //别删了,大哥.有用!!!!!!!!  by  jn
    $("#closeRefresh").click(function(){
         var index=parent.layer.getFrameIndex(window.name); //获取窗口索引
         parent.location.reload();
         parent.layer.msg('已关闭');
         parent.layer.close(index);
     });
    $("#refreshBtn").click(function(){
        location.reload();
    });
    $("#closeBtn").click(function(){
        var index=parent.layer.getFrameIndex(window.name); //获取窗口索引
        parent.layer.close(index);
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
	 /*id全选反选*/
    $(document).on("click",".SelectAllId",function(){
        var sname=$(this).attr('sname');
        if($(this).is(':checked')){
            $("input[name='"+sname+"']").prop("checked",true);
            var str="";
            $("input[name='"+sname+"']:checked").each(function(i){
                if(0==i){
                    str = $(this).val();
                }else{
                    str += (","+$(this).val());
                }
            });
            $('#czid').val(str);
        }else{
            $("input[name='"+sname+"']").prop("checked",false);
            $('#czid').val("");
        }
    });
    $("#searchFun").click(function(){
        var dname=$(this).attr("dname");
        layer.open({
            type: 1,
            title: '高级查询',
            closeBtn: 0,
            area: '516px',
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: $('#FullSearch')
        });
    });
	/*弹窗选择*/
    $(document).on("click",".selectOpen",function(){
        var url=$(this).attr('url');   		//调用模块地址
		var what=$(this).attr('what');  	//多选还是单选
		var iname=$(this).attr('iname');   	//回调input的name
		var iexpoid=$(this).attr('iexpoid');   	//回调input的ID
		var icid=$(this).attr('icid');   	//回调input的ID
		var iid=$(this).attr('iid');   	//回调input的ID
		var iiexpo=$("#expoid").val();   	//获取搭建销售订单
		layer.open({
			skin: 'layui-layer-lan', //默认皮肤
			type: 2,
			title: false, //标题
			closeBtn:0,
			area: ['90%', '90%'], //宽高
			shade: 0.8,
			zIndex:1,
			scrollbar: false,
			content: "/index.php/Home/"+url+"/toselect?what="+what+"&iname="+iname+"&iexpoid="+iexpoid+"&icid="+icid+"&iid="+iid+"&iiexpo="+iiexpo,
            end: function(){
                $(".footerbtn").show();
            }
		});
	});
});
$(document).on("click",".showOrHide",function(){
    var where=$(this).attr('where');
    $("#"+where).slideToggle();
    var what=$(this).children("i").attr('class');
    if(what=='fa fa-minus-square'){
        $(this).children("i").attr('class','fa fa-plus-square');
        $("input[name='"+where+"']").val(0);
    }else{
        $(this).children("i").attr('class','fa fa-minus-square');
        $("input[name='"+where+"']").val(1);
    }
});
/*刷新表单*/
function resetFrom() {
    $('form').each(function (index) {
        $('form')[index].reset();
    });
}
//自定义搜索
function _customSearch(tab){
        //下拉自定义搜索
    $('.sselect').on('keyup click', function () {
        var thisval=$(this).find("option:selected").val();
        var col=$(this).attr('col');
        if(thisval){
            tab.column(col).search(thisval).draw();
        }else{
            tab.column(col).search("").draw();
        }
    });
    //输入框自定义搜索
    $('.sbtn').bind('input propertychange', function() {
        var thisval=$(this).val();
        var col=$(this).attr('col');
        if(thisval){
            tab.column(col).search(thisval).draw();
        }else{
            tab.column(col).search("").draw();
        }
    });
    //自动添加序号
    tab.on('order.dt search.dt', function () {
        tab.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        });
    }).draw();
}
/*响应删除公用方法*/
function _del(table,xzid) {
    var czid = '';
    $("input[name='"+xzid+"']:checked").each(function (i, n) {
        if (i == 0) {
            douhao = "";
        } else {
            douhao = ",";
        }
        czid += douhao + $(n).val();
    });
    if(!czid) {
        layer.msg('Select Line', function(){});
        return false;
    }else{
        layer.confirm('Confirm delete?', {
            btn: ['Yes','No'], //按钮
            title:"information"
        }, function() {
            $.ajax({
                url: "?act=del&czid=" + czid,
                type: "post",
                success: function (res) {
                    if (res.code == 1 && (res.error == 1 || !res.error)) {
                        resetFrom();
                        layer.msg('Delete success', {icon: res.code});
                        table.ajax.reload(null, false);
                    } else if(res.code == 1 && res.error){
                        layer.msg(res.error, {icon: 2});
                    } else {
                        layer.msg(res.msg, {icon: res.code});
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
        });
        $('#czid').val('');
    }
}
/*响应单个删除公用方法*/
function _singledel(table) {
    var czid = $("#czid").val();
    if(!czid) {
        layer.msg('请选择行', function(){});
        return false;
    }else{
        layer.confirm('确认删除吗？', {
            btn: ['确认','取消'] //按钮
        }, function() {
            $.ajax({
                url: "?act=del&czid=" + czid,
                type: "post",
                success: function (res) {
                    if (res.code == 1) {
                        resetFrom();
                        layer.msg(res.msg, {icon: res.code});
                        table.ajax.reload(null, false);
                    } else {
                        layer.msg(res.msg, {icon: res.code});
                    }
                }, error: function (error) {
                    layer.msg('请求错误', {icon: 2});
                    console.log(error);
                }
            });
        });
        $('#czid').val('');
    }
}
//表单验证主程序
function _inputcheck() {
    var count=0;
    $(".required").each(function(){
        //判断元素类型是input还是select
        var isinput=$(this).attr('type');
        var txtval="";
        if(isinput) {
            txtval=$(this).val();
        }else{
            //获取select选中值
            txtname=$(this).attr('name');
            txtval=$("#"+txtname+" option:selected").val();
        }
        //如果值是空的则弹出信息
        if (!txtval) {
            var placeholder = $(this).attr('placeholder');
            if (!placeholder) {
                var placeholder = "当前字段不能为空";
            };
            layer.msg(placeholder);
            $(this).focus();
            count++;
            //return false;
        }
    });
    //输出判断结果
    if(count==0){
        return true;
    }else{
        return false;
    }
}
/*响应查看*/
function _viewLayer(url,title) {
    var czid=$("#czid").val();
    if(czid=='') {
        layer.msg('请选择要查看的行', function(){});
        return false;
    }else{
        layer.open({
            skin: 'layui-layer-lan', //默认皮肤
            type: 2,
            title: title, //标题
            area: ['90%', '90%'], //宽高
            shade: 0.8,
            zIndex:1,
            content: url+"?czid="+czid
        });
    }
}
/**
* 参数说明：ur=弹窗路径 title=窗体标题，wsize=弹窗宽度，hsize=弹窗高度
* @by watson 2016-10-12
* 响应弹窗添加和修改
*/
function _layerOpen(url,title,wsize,hsize) {
    if (!wsize) {
        wsize = '90%';
    }
    if (!hsize) {
        hsize = '90%';
    }
    layer.open({
        skin: 'layui-layer-lan', //默认皮肤
        type:2,
        title:title, //标题
        area: [wsize, hsize], //宽高
        //closeBtn:false,
        shade: 0.5,//遮罩
        zIndex:1,
        maxmin: true,  //最大最小化
        scrollbar: false,
        //content: [url,'no']
        content: [url]
    });
}
//响应单击选择
function _tableClick(tab,iname){
    tab.on('click','tbody tr',function () {
        if($(this).text()!='暂无数据') {
            var czid = $(this).find("td:last").text();
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $(this).find("input").prop("checked", false);
            }else{
                $(this).addClass('selected');
                $(this).find("input").prop("checked", true);
            }
            var czid='';
            $("input[name='"+iname+"[]']:checked").each(function (i, n) {
                if(i==0){
                    douhao="";
                }else{
                    douhao=",";
                }
                czid+=douhao+$(n).val();
            });
            $('#czid').val(czid);
        }
    });
}
</script>
</head>
<body id="Bstyle" class='skin-blue sidebar-collapse sidebar-mini'>
<!-- 框架开始 -->
  <!-- 正文 -->
  <section class='content'>
    <div id="tishi"></div>
    <div class="row">
        <div class="col-xs-12">
          
          
    <input type="hidden" value="<?php echo ($czid); ?>" id="qyid">
    <input type="hidden" id="czid" checked>
    <div class="form-inline pull-right">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="管理按钮">
            <button type="button" id="editFun" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Edit</button>
            <?php if($view['classid'] != '1859' ): ?><button type="button" u="Customer/addgongxiang" wsize="60%" hsize="60%" class="btn btn-primary dropdown-toggle ExpoOperations" data-toggle="dropdown">Turn to Share</button>
                <?php else: ?>
                <button type="button" id="addziji" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Move to My Account</button><?php endif; ?>
            <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i></button>
        </div>
    </div>
    <div class="TitleOne showOrHide" where="ExpoView"><i class="fa fa-minus-square"></i>&nbsp;&nbsp;<?php echo ($view["title"]); ?></div><?php echo ($view["product"]); ?>
    <table class="table table-striped table-bordered hover" id="ExpoView">
        <tr>
            <td width="15%" align="right"><strong>Company Name</strong></td>
            <td width="35%"><?php echo ($view["title"]); ?></td>
            <td width="15%" align="right"><strong>Acct. Manager</strong></td>
            <td><?php echo ($view["username"]); ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Country</strong></td>
            <td>
                <?php echo ($view["s1name"]); ?>
                <?php if($view['s2name']): ?>- <?php echo ($view["s2name"]); endif; ?>
            </td>
            <td align="right"><strong>Industry</strong></td>
            <td><?php echo ($view["industryname"]); ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Business Nature</strong></td>
            <td><?php echo ($view["businessname"]); ?></td>
            <td align="right"><strong>Type</strong></td>
            <td><?php echo ($view["typename"]); ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Language</strong></td>
            <td><?php echo ($view["languagename"]); ?></td>
            <td align="right"><strong>Brand</strong></td>
            <td><?php echo ($view["brand"]); ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Data Sources</strong></td>
            <td><?php echo ($view["sourcename"]); ?></td>
            <td align="right"><strong>Detailed Source Information</strong></td>
            <td><?php echo ($view["sourcedetails"]); ?></td>
        </tr>
        <tr>
            <td align="right" valign="top"><strong>Detailed Address</strong></td>
            <td><?php echo ($view["address"]); ?></td>
            <td align="right"><strong>Last Contact Time</strong></td>
            <td><?php echo ($view["updatedtime"]); ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Zip Code</strong></td>
            <td><?php echo ($view["ame"]); ?></td>
            <td align="right"><strong>Web</strong></td>
            <td><a href="http://<?php echo ($view["website"]); ?>" target="_black"><?php echo ($view["website"]); ?></a></td>
        </tr>
        <tr>
            <td align="right"><strong>Company Background</strong></td>
            <td colspan="3"><?php echo ($view["memo"]); ?></td>
        </tr>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
            <button class="btn btn-sm btn-success ExpoOperations" u="Customer/addlianxiren" title="Add a Contact" where="lianxiren"  wsize="60%" hsize="80%"><i class="fa fa-plus-circle"></i> Add a Contact</button>
            <button class="btn btn-sm btn-danger delFun" where="lianxiren"><i class="fa fa-remove "></i> Delete Contact</button>
        </div><b>Contact information</b>
    </div>
    <table id="ListLianxiren" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th>No.</th>
            <th>Primary Contact</th>
            <th>Full Name</th>
            <th>Department</th>
            <th>Position</th>
            <th>Contact Number</th>
            <th>Mobile Phone</th>
            <th>Fax</th>
            <th>Email</th>
            <th>Operation</th>
            <th>ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
            <button class="btn btn-sm btn-success" id="tjlxr"><i class="fa fa-plus-circle"></i> Add contact record</button>
        </div><b>Contact Record</b>
    </div>
    <table id="ListLianxiJilu" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th>No.</th>
            <th>Next Contact Time</th>
            <th width="30%">Notes</th>
            <th>Contacting method</th>
            <th>Position</th>
            <th>Contact Object</th>
            <th>Record Date</th>
            <th>Note-Taker</th>
            <th>ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
            <button class="btn btn-sm btn-success" id="addintention"><i class="fa fa-plus-circle"></i>Turn to lead</button>
        </div><b>Lead</b>
    </div>
    <table id="ListOrdersYxd" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th width="5%">No.</th>
            <th width="2%"><input class=SelectAllId type=checkbox sname="yxid[]"></th>
            <th width="13%">Company Name</th>
            <th width="6%">Country</th>
            <th width="13%">Expo</th>
            <th width="5%">Close Probability</th>
            <th width="10%">Est. Close Date</th>
            <th width="5%">Size</th>
            <th width="8%">Last Contact Time</th>
            <th width="6%">Acct. Manager</th>
            <th width="5%">Status</th>
            <th width="5%">Operation</th>
            <th width="3%">ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
        </div><b>Order</b>
    </div>
    <table id="ListOrders" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th width="5%">No.</th>
            <th width="3%"><input class=SelectAllId type=checkbox sname="id[]"></th>
            <th width="15%">Company Name</th>
            <th width="15%">Expo</th>
            <th width="8%">Country</th>
            <th width="8%">Actual price</th>
            <th width="5%">Size</th>
            <th width="10%">Booth Type</th>
            <th width="8%">Signing Date</th>
            <th width="13%">Acct. Manager</th>
            <th width="5%">Operation</th>
            <th width="4%">ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
        </div><b>Declined</b>
    </div>
    <table id="ListStop" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th width="3%">No.</th>
            <th width="3%"><input class=SelectAllId type=checkbox sname="id[]"></th>
            <th width="14%">Expo</th>
            <th width="12%">Company Name</th>
            <th width="15%">Decline Reason</th>
            <th width="12%">Remarks</th>
            <th width="13%">Decline Date</th>
            <th width="13%">Acct. Manager</th>
            <th width="6%">Operation</th>
            <th width="5%">ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <script>
        <?php if(!$islxr): ?>layui.use(['layer'], function(){
                var layer = layui.layer;
                var title='Add a Contact';
                var url = "<?php echo U('Home/Customer/addlianxiren');?>?cid=<?php echo ($czid); ?>";
                _layerOpen(url, title, '60%', '80%');
            });<?php endif; ?>
        layui.use('form', function() {
            var form = layui.form();
            form.on('select(searchselect)', function(data){
                var value = data.value;
                var col=$(data.elem).attr('col');
                if(value){
                    lianxijilu.column(col).search(value).draw();
                }else{
                    lianxijilu.column(col).search("").draw();
                }
            });
        });
        $(document).on("click",".upmember",function(){
            var czid=$(this).attr('id');
            var url="<?php echo U('Home/Customer/moren');?>";
            var data = {
                where:'member',
                czid:czid,
                cid:<?php echo ($view["id"]); ?>
            };
            $.post(url,data,function(data){
                // console.log(data);
                if(data = 1){
                    layer.msg('Modify success',{icon: 1});
                    lianxiren.ajax.reload(null, false);
                }else{
                    layer.msg('Modify failed',{icon: 2});
                }
            });
        });
        resetFrom();
        <?php if(($showD) != ""): ?>$("#ExpoView").hide();<?php endif; ?>
            //---------------------------响应订单相关操作---------------------------
        $(document).on("click",".ExpoOperations",function(){
            var title=$(this).attr('title');
            var url=$(this).attr('u');
            if(!url) {
                layer.msg(title+'开发中！',{icon:5});
            }else{
                var czid=$("#czid").val();
                var url = "/CRM/index.php/Home/" + url + "?cid=<?php echo ($czid); ?>"+"&title=<?php echo ($view["title"]); ?>";
                var wsize = $(this).attr('wsize');
                var hsize = $(this).attr('hsize');
                _layerOpen(url, title, wsize, hsize);
            }
        });
        $("#editFun").click(function(){
            var url = "<?php echo U('Home/Customer/add');?>?czid=<?php echo ($view["id"]); ?>";
            _layerOpen(url, 'Edit enterprise-><?php echo ($view["title"]); ?>', '90%', '90%');
        });
        /*重置表单*/
        resetFrom();
        var czid=$("#czid").val();
        /*联系人*/
        var lianxiren = $('#ListLianxiren').DataTable({
            stateSave: false,
            columnDefs:[{
                orderable:false,//禁用排序
                targets:[0,1]   //指定的列
            }],
            "order": [[2, 'asc']],
            "sDom": '<"top">rt<"bottom"ip><"clear">',
            bProcessing:true,
            bLengthChange: true,
            // bInfo:true,
            //bAutoWidth: true,
            paging:false,
            ordering: true,
            info:false,
            searching: false,
            autoWidth: false,
            //scrollY: 350,
            ajax: "?show=showMemberDataTbale&czid=<?php echo ($view["id"]); ?>",
        });
        _customSearch(lianxiren);
        /*联系记录*/
        var lianxijilu = $('#ListLianxiJilu').DataTable({
            "processing": true,//显示加载进度条
            "sDom": '<"top">rt<"bottom"ip><"clear">',
            "createdRow": function ( row, data, index ) {
                $('td', row).eq(2).css("text-align","left"); //标题单元格居左对齐
            },
            "order": [[4, 'desc']],
            columnDefs:[{
                orderable:false,//禁用排序
                targets:[0]   //指定的列
            }],
            "bServerSide": true,//开启服务器端模式
            ajax: "?show=showLianxiJiluDataTbale&czid=<?php echo ($view["id"]); ?>",
        });
        _customSearch(lianxijilu);

        var yxorders = $('#ListOrdersYxd').DataTable({
            "processing": true,
            "serverSide": true,
            stateSave: false,          //状态保存，使用了翻页或者改变了每页显示数据数量，会保存在cookie中，下回访问时会显示上一次关闭页面时的内容。
            bLengthChange: true,      //改变每页显示数据数量功能开启
            aLengthMenu: [10],        //设置每页显示数据数量
            "order": [[5, 'desc']],
            columnDefs:[{
                orderable:false,        //禁用排序
                targets:[0,1]             //指定的禁用排序列,多个用逗号隔开[0,1]
            }],
            sDom: '<"top">rt<"bottom"ip><"clear">',
            //改变页面上元素的位置
            //语法结构:*<>表示一个闭合DIV l - 每行显示的记录数 f- 搜索框 t- 表格 i- 表格信息 p- 分页条r- 加载时的进度条*/
            bProcessing:true,
            createdRow: function( row, data, dataIndex ) {
                $(row).children('td').eq(1).attr('style', 'text-align: left;')
            },
            paging:true,              //是否显示分页
            ordering: true,           //是否支持排序功能
            info:true,                //显示表格信息
            searching: true,          //开启刷选功能
            ajax: "?show=showOrdersYxdDataTbale&czid=<?php echo ($view["id"]); ?>"
        });
        _customSearch(yxorders);
        /*初始化表格*/
        var orders = $('#ListOrders').DataTable({
            "processing": true,
            "serverSide": true,
            stateSave: false,          //状态保存，使用了翻页或者改变了每页显示数据数量，会保存在cookie中，下回访问时会显示上一次关闭页面时的内容。
            bLengthChange: true,      //改变每页显示数据数量功能开启
            aLengthMenu: [10],        //设置每页显示数据数量
            "order": [[5, 'desc']],
            columnDefs:[{
                orderable:false,        //禁用排序
                targets:[0,1]             //指定的禁用排序列,多个用逗号隔开[0,1]
            }],
            sDom: '<"top">rt<"bottom"ip><"clear">',
            //改变页面上元素的位置
            //语法结构:*<>表示一个闭合DIV l - 每行显示的记录数 f- 搜索框 t- 表格 i- 表格信息 p- 分页条r- 加载时的进度条*/
            bProcessing:true,
            createdRow: function( row, data, dataIndex ) {
//                $(row).children('td').eq(1).attr('style', 'text-align: left;')
            },
            paging:true,              //是否显示分页
            ordering: true,           //是否支持排序功能
            info:true,                //显示表格信息
            searching: true,          //开启刷选功能
            autoWidth: false,
            ajax: "?show=showOrdersDataTbale&czid=<?php echo ($view["id"]); ?>"
        });
        _customSearch(orders);

        /*初始化表格*/
        var stop = $('#ListStop').DataTable({
            "processing": true,
            "serverSide": true,
            stateSave: false,          //状态保存，使用了翻页或者改变了每页显示数据数量，会保存在cookie中，下回访问时会显示上一次关闭页面时的内容。
            bLengthChange: true,      //改变每页显示数据数量功能开启
            aLengthMenu: [10],        //设置每页显示数据数量
            "order": [[5, 'desc']],
            columnDefs:[{
                orderable:false,        //禁用排序
                targets:[0,1]             //指定的禁用排序列,多个用逗号隔开[0,1]
            }],
            sDom: '<"top">rt<"bottom"ip><"clear">',
            //改变页面上元素的位置
            //语法结构:*<>表示一个闭合DIV l - 每行显示的记录数 f- 搜索框 t- 表格 i- 表格信息 p- 分页条r- 加载时的进度条*/
            bProcessing:true,
            createdRow: function( row, data, dataIndex ) {
                $(row).children('td').eq(1).attr('style', 'text-align: left;')
            },
            paging:true,              //是否显示分页
            ordering: true,           //是否支持排序功能
            info:true,                //显示表格信息
            searching: true,          //开启刷选功能
            autoWidth: false,
            ajax: "?show=showStopDataTbale&czid=<?php echo ($view["id"]); ?>"
        });
        _customSearch(stop);
        /*单击选择 */
        $('.table').on('click','tbody tr',function () {
            if($(this).find("td").html()!='No data available in table'){
                var czid=$(this).find("td:last").text();
                if($(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $('#czid').val(czid);
                }else{
                    $('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    $('#czid').val(czid);
                }
            }
        });
        /*双击调出编辑 */
        $('.tableEdit').on('dblclick','tbody tr',function () {
            if($(this).find("td").html()!='No data available in table'){
                if($(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $(this).find(":checkbox:first").prop("checked",false);
                }else{
                    $(this).addClass('selected');
                    $(this).find(":checkbox:first").prop("checked",true);
                    var url=$(this).parent().parent().attr("u");
                    var title=$(this).parent().parent().attr("title");
                    var wsize=$(this).parent().parent().attr("wsize");
                    var hsize=$(this).parent().parent().attr("hsize");
                    var czid=$(this).find("td:last").text();
                    if(!url) {
                        layer.msg(title+'开发中！',{icon:5});
                    }else{
                        var url = "/CRM/index.php/Home/" + url + "?cid=<?php echo ($czid); ?>&czid="+czid;
                        if (!wsize) {
                            wsize = '90%';
                        }
                        if (!hsize) {
                            hsize = '90%';
                        }
                        _layerOpen(url, title, wsize, hsize);
                    }
                }
            }
        });
        $(".addFun").click(function(){
            var where=$(this).attr("where");
            var wsize=$(this).attr("wsize");
            var hsize=$(this).attr("hsize");
            if(!wsize){
                var wsize='600px';
            }
            if(!hsize){
                var hsize='300px';
            }
            _layerOpen(where,'',wsize,hsize);
        });
        $(".editFun").click(function(){
            var where=$(this).attr("where");
            var czid=$(this).find("td:last").text();
            _layerOpen(where,czid,'600px','300px');
        });
        $(".delFun").click(function(){
            var czid=$("#czid").val();
            var where=$(this).attr("where");
            if(!czid) {
                layer.msg('Select line', function(){});
                return false;
            }else{
                $.ajax({
                    url: "/CRM/index.php/Home/Customer/add"+where+"?act=del&czid="+czid,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg(res.msg, {icon: res.code});
                            if(where=='lianxiren'){
                                lianxiren.ajax.reload(null, false);
                            }
                        } else {
                            layer.msg(res.msg, {icon: res.code});
                        }
                    }, error: function (error) {
                        layer.msg('Request error', {icon: 2});
                        console.log(error);
                    }
                });
            }
        });
        <!--添加意向单-->
        $(document).on("click","#addintention",function(){
            $.ajax({
                url: "<?php echo U('Home/Customer/ismember');?>?czid=<?php echo ($czid); ?>",
                dataType: 'json',
                type: "post",
                success: function (res) {
                    if(res.code==1){
                        var title="Turn to lead";
                        var url="<?php echo U('Home/Customer/addintention');?>?cid=<?php echo ($czid); ?>";
                        _layerOpen(url, title,'75%', '85%');
                    }else if(res.code==2){
                            layer.msg('Please add a contact');
                            var title='Add a Contact';
                            var url = "<?php echo U('Home/Customer/addlianxiren');?>?cid=<?php echo ($czid); ?>";
                            _layerOpen(url, title, '60%', '80%');
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
        });
        $("#addziji").click(function(){
            var czid=$('#qyid').val();
            $.ajax({
                url: "<?php echo U('Home/Customer/addziji');?>?cid="+czid,
                dataType: 'json',
                type: 'POST',
                success: function (res) {
                    if (res.code == 1) {
                        resetFrom();
                        location.reload();
                        layer.msg('Succeed in!', {icon: 1});
                    } else {
                        layer.msg('Fail in!', {icon: 2});
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
        });
        <!--添加联系记录-->
        $(document).on("click","#tjlxr",function(){
            $.ajax({
                url: "<?php echo U('Home/Customer/ismember');?>?czid=<?php echo ($czid); ?>",
                dataType: 'json',
                type: "post",
                success: function (res) {
                    if(res.code==1){
                        var title="Add contact record";
                        var url="<?php echo U('Home/Customer/addlianxijilu');?>?cid=<?php echo ($czid); ?>";
                        _layerOpen(url, title,'60%', '70%');
                    }else if(res.code==2){
                        layer.msg('Please add a contact');
                        var title='Adda Contact ';
                        var url = "<?php echo U('Home/Customer/addlianxiren');?>?cid=<?php echo ($czid); ?>";
                        _layerOpen(url, title, '60%', '80%');
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
        });
        /*编辑订单*/
        $(document).on('click','.edit',function(){
            var title = "Edit Order";
            var czid=$(this).attr('czid');
            var url ="<?php echo U('Orders/editOrders');?>?czid="+czid;
            _layerOpen(url, title, '70%', '75%');
        });
        /*转为订单*/
        $(document).on('click','.zdd',function(){
            var title = "Turn to order";
            var czid=$(this).attr('czid');
            var url ="<?php echo U('Orders/zhuandd');?>?czid="+czid;
            _layerOpen(url, title, '70%', '75%');
        });
        /*转为挂单*/
        $(document).on('click','.zgd',function(){
            var title = "转为挂单";
            var czid=$(this).attr('czid');
            var url ="<?php echo U('Orders/zhuangd');?>?czid="+czid;
            _layerOpen(url, title, '60%', '70%');
        });
//        订单修改
        $(document).on('click','.editdd',function(){
            var title = "Edit Order";
            var czid=$(this).attr('czid');
            var url ="<?php echo U('Orders/editdd');?>?czid="+czid;
            _layerOpen(url, title, '70%', '75%');
        });
//        订单删除
        /*单个删除方法*/
        function del(id){
            console.log(id);
            layer.confirm('Confirm delete？', {
                btn: ['confirm','cancel'] //按钮
            }, function() {
                $.ajax({
                    url: "?act=del&czid=" + id,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg(res.msg, {icon: res.code});
                            table.ajax.reload(null, false);
                        } else {
                            layer.msg(res.msg, {icon: res.code});
                        }
                    }, error: function (error) {
                        layer.msg('Request error', {icon: 2});
                        console.log(error);
                    }
                });
            });
            $('#czid').val('');
        }
        /*编辑意向单*/
        $(document).on('click','.edityxd',function(){
            var title = "Edit Intent list";
            var czid=$(this).attr('czid');
            var cid=$(this).attr('cid');
            var url ="<?php echo U('Customer/addintention');?>?czid="+czid+"&cid="+cid;
            _layerOpen(url, title, '70%', '75%');
        })
//        挂单删除
        $(document).on('click','.delgd',function(){
            var id=$(this).attr('czid');
            layer.confirm('Confirm delete?', {
                btn: ['Yes','No'] //按钮
            }, function() {
                $.ajax({
                    url: "/CRM/index.php/Home/Orders/stop?act=del&czid=" + id,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg('Delete success', {icon: res.code});
                            stop.ajax.reload(null, false);
                        } else {
                            layer.msg(res.msg, {icon: res.code});
                        }
                    }, error: function (error) {
                        layer.msg('Request error', {icon: 2});
                        console.log(error);
                    }
                });
            });
            $('#czid').val('');
        });
        /*编辑联系人*/
        $(document).on('click','.lxredit',function(){
            var title = "Edit Contact";
            var czid=$(this).attr('id');
            var url ="<?php echo U('Customer/addlianxiren');?>?czid="+czid;
            _layerOpen(url, title, '60%', '80%');
        });
        /*订单删除方法*/
        $(document).on('click','.deldd',function(){
            var id=$(this).attr('czid');
            layer.confirm('Confirm delete?', {
                btn: ['Yes','No'] //按钮
            }, function() {
                $.ajax({
                    url: "/CRM/index.php/Home/Orders?act=del&czid=" + id,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg('Delete success', {icon: res.code});
                            orders.ajax.reload(null, false);
                        } else {
                            layer.msg(res.msg, {icon: res.code});
                        }
                    }, error: function (error) {
                        layer.msg('Request error', {icon: 2});
                        console.log(error);
                    }
                });
            });
            $('#czid').val('');
        });
    </script>

        </div>
    </div>
  </section>
<script>
    /*重新加载表格数据*/
    function DatablesReload(msg){
        if(msg=='table'){
            table.ajax.reload(null, false);
        }
        if(msg=='lianxiren'){
            lianxiren.ajax.reload(null, false);
        }

    }
    layui.use('form', function(){
        var form = layui.form();
        /*国家城市联动*/
        form.on('select(s1)', function(data){
            $("#s2").empty();
            $("#s3").empty();
            $.ajax({
//                url: "/index.php/Home/Index/index?show=searchCountry",
                //url: "?show=searchCountry",
                url:"<?php echo U('Index/index',array('show' => 'searchCountry'));?>",
                data:{'s1': data.value},
                type: "post",
                //async:false,
                success: function (json) {
                    //alert(data.value);
                    if(json.length==0){
                        $("#s2").append($("<option>").val('').text(''));
                    }else{
                        $("#s2").append($("<option>").val('').text('Select'));
                        $.each(json, function (i, item) {
                            $("#s2").append($("<option>").val(item.id).text(item.classname));
                        });
                    }
                    form.render();
                }, error: function (error) {
                    console.log(error);
                }
            });
        });
        form.on('select(s2)', function(data){
            $("#s3").empty();
            $.ajax({
                url:"<?php echo U('Index/index',array('show' => 'searchCity'));?>",
                data:{'s2': data.value},
                type: "post",
                //async:false,
                success: function (json) {
                    //alert(data.value);
                    if(json.length==0){
                        $("#s3").append($("<option>").val('').text(''));
                    }else{
                        $.each(json, function (i, item) {
                            $("#s3").append($("<option>").val(item.id).text(item.classname));
                        });
                    }
                    form.render();
                }, error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>
</body>
</html>