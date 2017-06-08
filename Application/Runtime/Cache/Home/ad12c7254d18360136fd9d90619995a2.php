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
          
          
    <input type=hidden id="czid" checked>
    <div class="form-inline searchbar">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
            <?php if(strpos(getUserCzqx(),"意向删除")>-1){ ?>
                <button id="delFun" class="btn btn-danger">Delete</button>
            <?php } ?>
            <button type="button" class="btn btn-info" id="btnRefresh"><i class="fa fa-refresh"></i></button>
        </div>
        <form class="layui-form">
            <input type="hidden" name="showD" value="<?php echo ($showD); ?>">
            <div class="layui-input-inline" style="width: 150px">
                <input class="layui-input" type="text" placeholder="Company Name" name="company" id="company">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input class="layui-input" type="text" placeholder="Country" name="country" id="country">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="expo" id="expo">
                    <option value=0>Expo</option>
                    <?php $_result=ShowList('expo','','id');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$oi): $mod = ($i % 2 );++$i;?><option value="<?php echo ($oi["id"]); ?>"><?php echo ($oi["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="probability" id="probability">
                    <option value=0>Close probability</option>
                    <?php $_result=ShowList('class','parid=1652','id');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$oi): $mod = ($i % 2 );++$i;?><option value="<?php echo ($oi["id"]); ?>"><?php echo ($oi["classname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input  class="layui-input dates" placeholder="Est. start" name="starttime" id="starttime" onclick="layui.laydate({elem: this, festival: true})">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input  class="layui-input dates" placeholder="Est. close" name="endtime" id="endtime" onclick="layui.laydate({elem: this, festival: true})">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="khuser" id="khuser">
                    <option value=0>Acct. Manager</option>
                    <?php $_result=ShowList('users','','id');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$oi): $mod = ($i % 2 );++$i;?><option value="<?php echo ($oi["id"]); ?>"><?php echo ($oi["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="bumen" id="bumen">
                    <option value=0>Department</option>
                    <?php $_result=ShowList('bumen','','id');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$oi): $mod = ($i % 2 );++$i;?><option value="<?php echo ($oi["id"]); ?>"><?php echo ($oi["classname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="layui-input-inline">
                <a class="layui-btn layui-btn-small layui-btn-normal"  id="orderssub" >Search</a>
            </div>
        </form>
    </div>
    <ul class="nav nav-tabs">
        <li <?php if($showD == ''): ?>class=active<?php endif; ?>> <a href="?showD=">my leads</a></li>
        <li <?php if($showD == 'allleads'): ?>class=active<?php endif; ?>> <a href="?showD=allleads">all leads</a></li>
    </ul>
    <div class="bg-info msgbox">
        Under current searching conditions,
        total exhibiting space proposed:<b style="color:red;"><span id="count"></span></b> ㎡。
    </div>
    <table id="ListTbl" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th width="3%" style="line-height:30px">No.</th>
            <th width="2%"><input class=SelectAllId type=checkbox sname="yxid[]" style="margin-bottom:7px;"></th>
            <th width="13%" style="line-height:30px">Company Name</th>
            <th width="6%" style="line-height:30px">Country</th>
            <th width="13%" style="line-height:30px">Expo</th>
            <th width="5%">Close Probability</th>
            <th width="10%" style="line-height:30px">Est. Close Date</th>
            <th width="5%" style="line-height:30px">Size</th>
            <th width="8%">Last Contact Time</th>
            <th width="6%">Acct. Manager</th>
            <th width="6%" style="line-height:30px">Status</th>
            <th width="5%" style="line-height:30px">Operation</th>
            <th width="3%" style="line-height:30px">ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        /*基础设置*/
        resetFrom();
        $("#delFun").click(function(){
            _del(table,'yxid[]');
        });
        $("#orderssub").click(function(){
            var param=$("form").serialize();
            table.ajax.url("?show=showDataTbale&"+param).load();
        })
        /*初始化表格*/
        var table = $('#ListTbl').DataTable({
            "processing": true,
            "serverSide": true,
            stateSave: false,          //状态保存，使用了翻页或者改变了每页显示数据数量，会保存在cookie中，下回访问时会显示上一次关闭页面时的内容。
            bLengthChange: true,      //改变每页显示数据数量功能开启
            aLengthMenu: [10],        //设置每页显示数据数量
            "order": [[4, 'desc']],
            columnDefs:[{
                orderable:false,        //禁用排序
                targets:[0,1]             //指定的禁用排序列,多个用逗号隔开[0,1]
            }],
            sDom: '<"top">rt<"bottom"ip><"clear">',
            //改变页面上元素的位置
            //语法结构:*<>表示一个闭合DIV l - 每行显示的记录数 f- 搜索框 t- 表格 i- 表格信息 p- 分页条r- 加载时的进度条*/
            bProcessing:true,
            createdRow: function( row, data, dataIndex ) {
                $(row).children('td').eq(4).attr('style', 'text-align: left;')
            },
            paging:true,              //是否显示分页
            ordering: true,           //是否支持排序功能
            info:true,                //显示表格信息
            searching: true,          //开启刷选功能
            autoWidth: false,
//            ajax:"?show=showDataTbale"
            ajax:{
                //contentType: "application/json",   //这段代码不要加，我时延的是否后台会接受不到数据
                url:"?show=showDataTbale&showD=<?php echo ($showD); ?>",
                dataType:"json",
                "dataSrc": function ( json ) {
                    $('#count').html(json.sum);
                    return json.data;
                }
            },
        });
        var seach = "<div class='searchstyle'><input type='text' id='pagesvalue' style='width: 35px;height: 30px;' /><button class='layui-btn layui-btn-normal search-btn' id='search'>GO</button></div>";
        $('#ListTbl_info').after(seach);
        _customSearch(table);
        /*单击选择 */
        $('#ListTbl').on('click','tbody tr',function () {
            var czid=$(this).find("td:last").text();;
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#czid').val('');
            }else{
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#czid').val(czid);
            }
        });
        /*编辑意向单*/
       $(document).on('click','.edityxd',function(){
           var title = "Edit Intent list";
           var czid=$(this).attr('czid');
           var cid=$(this).attr('cid');
           var url ="<?php echo U('Customer/addintention');?>?czid="+czid+"&cid="+cid;
           _layerOpen(url, title, '80%', '100%');
       })
        /*转为订单*/
        $(document).on('click','.zdd',function(){
            var title = "Turn to order";
            var czid=$(this).attr('czid');
            var url ="<?php echo U('Orders/zhuandd');?>?czid="+czid;
            _layerOpen(url, title, '80%', '100%');
        })
        /*转为挂单*/
        $(document).on('click','.zgd',function(){
            var title = "Move to lost";
            var czid=$(this).attr('czid');
            var url ="<?php echo U('Orders/zhuangd');?>?czid="+czid;
            _layerOpen(url, title, '80%', '100%');
        })
        $('#search').click(function(){
            var value=$("#pagesvalue").val()-1;
            table.page(value).draw(false);
        });
        <!--添加联系记录-->
        $(document).on("click","#tjlxr",function(){
            var czid = $(this).attr('czid');
            $.ajax({
                url: "<?php echo U('Home/Customer/ismember');?>?czid="+czid,
                dataType: 'json',
                type: "post",
                success: function (res) {
                    if(res.code==1){
                        var title="Add contact record";
                        var url="<?php echo U('Home/Customer/addlianxijilu');?>?cid="+czid;
                        _layerOpen(url, title,'80%', '100%');
                    }else if(res.code==2){
                        layer.msg('Please add a contact');
                        var title='Add a Contact';
                        var url = "<?php echo U('Home/Customer/addlianxiren');?>?cid="+czid;
                        _layerOpen(url, title, '80%', '100%');
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
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