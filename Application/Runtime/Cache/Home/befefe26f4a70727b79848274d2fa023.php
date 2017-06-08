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
          
          
    <!--意向单操作界面-->
    <form method='post' id="addForm" action='' class="layui-form">
    <div class="footerbtn">
        <button lay-submit lay-filter="saveFun" class="btn btn-success"><i class="fa fa-save"></i>Preservation</button>
        <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i>Refresh</button>
        <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
    </div>
        <input type=hidden id="czid" value="<?php echo ($czid); ?>" checked>
        <input type="hidden" id="cid" name="cid" value="<?php echo ($cid); ?>" id="cid" checked>
        <table class='table table-striped'>
            <tr>
                <td align="right"><font color="red" size=4>*</font>Intention Expo</td>
                <td>
                    <div class="layui-input-inline">
                        <select id="expoid" name="expoid" lay-search>
                            <option value="0">Please Select</option>
                            <?php $_result=ShowList('expo','1=1','starttime desc');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo["id"]); ?>'<?php if($result['expoid'] == $vo['id']): ?>selected="selected"<?php endif; ?>><?php echo ($vo["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </td>
                <td align="right">Company Name</td>
                <td>
                    <?php $_result=ShowList('company','id='.$cid,'id');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["title"]); endforeach; endif; else: echo "" ;endif; ?>
                </td>
            </tr>
            <tr>
                <td align="right">Booth Type</td>
                <td colspan="3">
                    <div class="layui-input-inline">
                        <input type="radio" name="boothtype" title="Package Booth" value=1659 <?php if($result['boothtype'] == 1659): ?>checked<?php endif; ?>>
                        <input type="radio" name="boothtype" title="Raw Space" value=1660 <?php if($result['boothtype'] == 1660): ?>checked<?php endif; ?>>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right"><font color="red" style="font-size:18px;">*</font>Sqm</td>
                <td  class="form-inline">
                    <div class="input-group">
                        <div class="layui-input-inline">
                            <input type="text" name="acreage" id="acreage" lay-verify="acreage" value="<?php echo ($result['acreage']); ?>" class="layui-input" style="width: 168px">
                        </div>
                        <input type="text" value="㎡" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
                    </div>
                </td>
                <td align="right"><font color="red" style="font-size:18px;">*</font>Unit Price</td>
                <td  class="form-inline">
                    <div class="input-group">
                        <input id="price" name="price" lay-verify="price" value="<?php echo ($result['price']); ?>" type="text" class='layui-input'  size="24"/>
                    </div>
                    <input type="text" value="$" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
                </td>
            </tr>
            <tr>
                <td align="right">Origin Cost</td>
                <td  class="form-inline" colspan="3">
                    <div class="input-group">
                        <div class="layui-input-inline">
                            <input type="text" name="cdcb" id="cdcb" value="<?php echo ($result['cdcb']); ?>" class="layui-input" style="width: 168px">
                        </div>
                        <input type="text" value="$" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">Discount</td>
                <td class="form-inline">
                    <div class="layui-input-inline">
                        <select id="discounttype" name="discounttype" lay-search>
                            <option value="0">Please Select</option>
                            <option value="percentage" <?php if($result['discounttype'] == 'percentage'): ?>selected="selected"<?php endif; ?>>percentage</option>
                            <option value="fixed amount" <?php if($result['discounttype'] == 'fixed amount'): ?>selected="selected"<?php endif; ?>>fixed amount</option>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <input id="discount" name="discount" value="<?php echo ($result['discount']); ?>"  type="text" class="layui-input" size="24">
                    </div>
                </td>
                <td align="right">Actual price</td>
                <td>
                    <div class="layui-input-inline">
                        <input id="actprice" name="actprice" value="<?php echo ($result['actprice']); ?>" class="layui-input" style="width: 168px" >
                    </div>
                    <input type="text" value="$" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
                </td>
            </tr>
            <tr>
                <td align="right">Special Offer</td>
                <td>
                    <div class="input-group">
                        <input id="special" name="special"  value="<?php echo ($result['special']); ?>" type="text" class="layui-input" size="24">
                    </div>
                </td>
                <td align="right"><font color="red" style="font-size:18px;">*</font>Booth Number</td>
                <td  class="form-inline">
                    <div class="input-group">
                        <input id="boothno" name="boothno" value="<?php echo ($result['boothno']); ?>" lay-verify="boothno" type="text" class='layui-input'  size="24"/>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right"><font color="red" style="font-size:18px;">*</font>Signing date</td>
                <td>
                    <input id="qydate" name="qydate"  lay-verify="qydate" class="layui-input" onclick="layui.laydate({elem: this, festival: true})" style="width: 168px" >
                </td>
                <td align="right">Est. payment date</td>
                <td>
                    <input id="paymentdate" name="paymentdate"  class="layui-input" onclick="layui.laydate({elem: this, festival: true})" style="width: 168px" >
                </td>
            </tr>
            <tr>
                <td align="right">Acct. Manager</td>
                <td colspan="3">
                    <input type="hidden" id="userid" name="userid" value="<?php echo ($request["userid"]); ?>">
					<span id="username">
						<?php $_result=ShowList('users','id='.$request['userid'],'id');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["username"]); endforeach; endif; else: echo "" ;endif; ?>
					</span>
                </td>
            </tr>
                <input type="hidden" name="uptime" id="time">
        </table>
    </form>
    <script>
        resetFrom();
        layui.use('form', function() {
            var form = layui.form();
            form.verify({
                acreage: function(value){
                    if(!value){
                        return 'Area is not empty';
                    }
                }
                ,price: function(value){
                    if(!value){
                        return 'The amount can not be empty';
                    }
                }
                ,boothno: function(value){
                    if(!value){
                        return 'Booth number may not be empty';
                    }
                }
                ,qydate: function(value){
                    if(!value){
                        return 'The date of signing must not be empty';
                    }
                }
            });
            form.on('submit(saveFun)', function(data){
                var param = $("#addForm").serialize();
                var p=window.open('about:blank');
                $.ajax({
                    url: "?act=edit&czid=<?php echo ($czid); ?>",
                    data: param,
                    dataType: 'json',
                    type: 'POST',
                    success: function (res) {
                        if(res.code==1){
                            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
//                        window.parent.DatablesReload("table");
                            parent.location.reload();
                            parent.layer.msg(res.msg, {icon: res.code});
                            parent.layer.close(index);
                            p.location="/CRM/index.php/Home/Orders/view?czid="+res.oid;
                        } else {
                            layer.msg(res.msg, {icon: res.code});
                        }
                    }, error: function (error) {
                        layer.msg('Request error', {icon: 2});
                        console.log(error);
                    }
                });
                return false;
            });
        });
        function showtime(){
            var d=new Date();
            str='';
            str +=d.getFullYear()+'-'; //获取当前年份
            str +=d.getMonth()+1+'-'; //获取当前月份（0——11）
            str +=d.getDate()+'     ';
            str +=d.getHours()+':';
            str +=d.getMinutes()+':';
            str +=d.getSeconds();
            return str; }
        function current(){
            var d=new Date();
            var date=d.getDate();
            var month=d.getMonth()+1;
            str='';
            str +=d.getFullYear()+'-'; //获取当前年份
            if(month<10){
                str =str+"0"+month+'-';
            }else{
                str +=month+'-';
            }
            if(date<10){
                str =str+"0"+date;
            }else{
                str +=date;
            }
            return str;
        }
        $(function(){
            var $timeStr=showtime();
            var $dateStr=current();
            $("#qydate").val($dateStr) ;
            $("#time").val($timeStr) ;
        });
        $("#acreage,#price").blur(function(){
            if($("#acreage").val() && $("#price").val()){
                var zong=$("#acreage").val()*$("#price").val();
                $("#cdcb").val(zong);
            }
        });
        $("#discount").blur(function(){
            if($("#cdcb").val() && $("#discount").val()){
                if($("#discounttype").val()=='percentage'){
                    var sum=$("#cdcb").val()-($("#cdcb").val()*($("#discount").val()/100));
                    $("#actprice").val(sum);
                }else if($("#discounttype").val()=='fixed amount'){
                    var sum=$("#cdcb").val()-$("#discount").val();
                    $("#actprice").val(sum);
                }
            }
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