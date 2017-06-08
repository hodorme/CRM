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
          
          
    <input type="hidden" value="<?php echo ($czid); ?>" id="czid">
    <input type="hidden" id="czid" checked>
    <input type="hidden" id="expoid" checked value="<?php echo ($view["expoid"]); ?>">
    <input type="hidden" id="cid" checked value="<?php echo ($view["cid"]); ?>">
    <div class="pull-right btn-group pdl-10" role="group" aria-label="管理按钮">
        <?php if($view['orderstatus'] == '有效意向单'): ?><div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Operation <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="javascript:;" class="zdd"><i class="fa fa-plus-circle"></i>Turn to order</a></li>
                    <li><a href="javascript:;" class="zgd"><i class="fa fa-plus-circle"></i>Move to lost</a></li>
                </ul>
            </div>
            <?php elseif($view['orderstatus'] == '有效订单'): ?>
            <?php if(strpos(getUserCzqx(),"订单删除")>-1){ ?>
                <button type="button" id="delFun" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> Delete</button>
            <?php } ?>
            <?php if(strpos(getUserCzqx(),"订单编辑")>-1){ ?>
                <button type="button" id="editFun" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Edit</button>
            <?php } ?>
            <?php elseif($view['orderstatus'] == '已挂单'): ?>
            <?php if(strpos(getUserCzqx(),"挂单删除")>-1){ ?>
                <button type="button" id="delgd" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> Delete</button>
            <?php } endif; ?>
        <button class="btn btn-info refreshBtn"><i class="fa fa-refresh"></i> </button>
    </div>
    <div class="TitleOne showOrHide" where="ExpoView"><i class="fa fa-minus-square"></i><?php echo ($view["opclassidname"]); ?>Sale(<?php echo ($view["zhuangtai"]); ?>)</div>
    <table class="table table-striped table-bordered hover" id="ExpoView">
        <tr>
            <td width="15%" align="right"><strong>Order ID</strong></td>
            <td width="35%"><?php echo ($view["id"]); ?></td>
            <td width="15%" align="right"><strong>Acct. Manager</strong></td>
            <td width="35%"><?php echo ($view["username"]); ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Company Name</strong></td>
            <td><a href="/CRM/index.php/Home/Customer/view?czid=<?php echo ($view["cid"]); ?>" target="_blank"><?php echo ($view["cname"]); ?></a></td>
            <td align="right"><strong>Related Exhibition</strong></td>
            <td><a href="/CRM/index.php/Home/Expo/view?czid=<?php echo ($view["expoid"]); ?>" target="_blank"><?php echo ($view["ename"]); ?></a></td>
        </tr>
        <tr>
            <td align="right"><strong>Size</strong></td>
            <td><?php if($view['acreage']): echo ($view["acreage"]); ?>㎡<?php endif; ?></td>
            <td align="right"><strong>Unit Price</strong></td>
            <td><?php if($view['actprice']): ?>$<?php echo ($view["price"]); endif; ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Actual Price</strong></td>
            <td>$<?php echo ($view["actprice"]); ?></td>
            <td align="right"><strong>Booth Type</strong></td>
            <td><?php echo ($view["boothtype"]); ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Est. Close Date</strong></td>
            <td><?php echo ($view["estclose"]); ?></td>
            <td align="right"><strong>Probability</strong></td>
            <td><?php echo ($view["probability"]); ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Signing Time</strong></td>
            <td><?php echo ($view["qydate"]); ?></td>
            <td align="right"><strong>Status</strong></td>
            <td><?php if($view['orderstatus'] == '有效订单'): ?>Close-won
                    <?php elseif($view['orderstatus'] == '有效意向单'): ?>
                    Open
                    <?php else: ?>
                    Close-lost<?php endif; ?>
            </td>
        </tr>
        <tr>
            <td align="right"><strong>Remarks</strong></td>
            <td colspan="3"><?php echo ($view["memo"]); ?></td>
        </tr>
    </table>
    <?php if($view['orderstatus'] == '已挂单'): ?><div class="tabHeader">
            <b>Decline Information</b>
        </div>
        <table class="table table-striped table-bordered hover" id="ExpoView">
            <tr border="1">
                <td style="border-color: #0d8ddb" align="center" width="10%"><strong>Decline Reason</strong></td>
                <td style="border-color: #0d8ddb" width="20%"><?php echo ($res["whya"]); ?></td>
                <td style="border-color: #0d8ddb" align="center" width="10%"><strong>Remarks</strong></td>
                <td style="border-color: #0d8ddb" width="20%"><?php echo ($res["memo"]); ?></td>
            </tr>
        </table><?php endif; ?>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
            <button class="btn btn-sm btn-success ExpoOperations" u="Customer/addlianxijilu" where="lianxijilu"  wsize="60%" hsize="70%"><i class="fa fa-plus-circle"></i> Add contact record</button>
        </div><b>Contact record</b>
    </div>
    <table id="ListLianxiJilu" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th>No.</th>
            <th>Next Contact Time</th>
            <th>Expo</th>
            <th>Contacting method</th>
            <th>Contact Object</th>
            <th>Record Date</th>
            <th>Note-Taker</th>
            <th>ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <script>
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
            ajax: "?show=showLianxiJiluDataTbale&cid=<?php echo ($view["cid"]); ?>&czid=<?php echo ($czid); ?>",
        });
        _customSearch(lianxijilu);
        $(document).on("click",".ExpoOperations",function(){
            var title=$(this).attr('title');
            var url=$(this).attr('u');
            if(!url) {
                layer.msg(title+'开发中！',{icon:5});
            }else{
                var czid=$("#czid").val();
                var url = "/CRM/index.php/Home/" + url + "?cid=<?php echo ($view["cid"]); ?>";
                var wsize = $(this).attr('wsize');
                var hsize = $(this).attr('hsize');
                _layerOpen(url, title, wsize, hsize);
            }
        });
        /*转为订单*/
        $(document).on('click','.zdd',function(){
            var title = "Turn to order";
            var czid=$("#czid").val();
            var url ="<?php echo U('Orders/zhuandd');?>?czid="+czid;
            _layerOpen(url, title, '75%', '80%');
        })
        /*转为挂单*/
        $(document).on('click','.zgd',function(){
            var title = "转为挂单";

            var url ="<?php echo U('Orders/zhuangd');?>?czid="+czid;
            _layerOpen(url, title, '60%', '70%');
        })
//        修改订单
        $("#editFun").click(function(){
            var title = "Modify order";
            var czid=$("#czid").val();
            var url ="<?php echo U('Orders/editdd');?>?czid="+czid;
            _layerOpen(url, title, '75%', '70%');
        });
//        删除订单
        /*单个删除方法*/
        $("#delFun").click(function(){
            var id=$("#czid").val();
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
                            window.close();
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
//        挂单删除
        $("#delgd").click(function(){
            layer.confirm('Confirm delete?', {
                btn: ['Yes','No'] //按钮
            }, function() {
                $.ajax({
                    url: "/CRM/index.php/Home/Orders/stop?act=del&czid=<?php echo ($czid); ?>" ,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg('Delete success', {icon: res.code});
                            window.close();
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