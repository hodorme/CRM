<php>if(session('?uno')==null){header('Location:/index.php/Home/index/login');return false;}</php>
<!DOCTYPE html>
<html lang='zh-CN'>
<head>
<meta charset='utf-8'>
<title>{$modular}</title>
<link rel='icon' href='/favicon.ico'>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href='//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css'rel='stylesheet' />
<link href='//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.css' rel='stylesheet' />
<link href='//cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet' />
<link href='__ADDONS__/Bootstrap/css/bootstrap.min.css' rel='stylesheet' />
<link href='__ADDONS__/Bootstrap/css/bootstrap-theme.css' rel='stylesheet' />
<link href='__ADDONS__/AdminLTE/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' />
<link href='__ADDONS__/AdminLTE/plugins/datatables/jquery.dataTables.css' rel='stylesheet' />
<link href='__ADDONS__/AdminLTE/dist/css/AdminLTE.min.css' rel='stylesheet' />
<link href='__ADDONS__/AdminLTE/dist/css/skins/_all-skins.min.css' rel='stylesheet' />
<link href='__ADDONS__/AdminLTE/plugins/morris/morris.css' rel='stylesheet' />
<link href="__ADDONS__/layui/css/layui.css" rel="stylesheet">
<link href='__CSS__/2015.css' rel='stylesheet' type='text/css' />
<link href='__CSS__/adm.css' rel='stylesheet' type='text/css' />
<link href='__CSS__/animate.css' rel='stylesheet' type='text/css' />
<link href='__CSS1__/default.css' rel='stylesheet' type='text/css' />
<link href='__ADDONS__/Easyform/easyform.css' rel='stylesheet' type='text/css' />
<script src='__JS__/data.js'></script>
<script src='__JS__/wwcms.js'></script>
<script src='__ADDONS__/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js'></script>
<script src='__ADDONS__/AdminLTE/plugins/datatables/jquery.dataTables.min.js'></script>
<script src='__ADDONS__/AdminLTE/plugins/fastclick/fastclick.min.js'></script>
<script src='__ADDONS__/AdminLTE/dist/js/app.min.js'></script>
<script src='__ADDONS__/Bootstrap/js/bootstrap.min.js'></script>
<script src='__ADDONS__/Layer/layer.js'></script>
<script src="__ADDONS__/Lodop6/LodopFuncs.js"></script>
<script src='__ADDONS__/tableExport/tableExport.js'></script>
<script src='__ADDONS__/tableExport/jquery.base64.js'></script>
<script src='__ADDONS__/tableExport/html2canvas.js'></script>
<script src='__ADDONS__/tableExport/jspdf/libs/sprintf.js'></script>
<script src='__ADDONS__/tableExport/jspdf/jspdf.js'></script>
<script src='__ADDONS__/tableExport/jspdf/libs/base64.js'></script>
<!--[if lt IE 9]>
<script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
<![endif]-->
<script src='/Wwedit/themes/default/default.css' rel='stylesheet' type='text/css'></script>
<script src='/Wwedit/kindeditor-min.js'></script>
<script src='/Wwedit/lang/zh_CN.js'></script>
<script>
KindEditor.ready(function(K) {
    var editor = K.editor({
        allowFileManager : true
    });
    K('.upimg').click(function() {
        var whatid=$(this).attr("iid");
        editor.loadPlugin('image', function() {
            editor.plugin.imageDialog({
                imageUrl : K('#'+whatid).val(),
                clickFn : function(url, title, width, height, border, align) {
                    K('#'+whatid).val(url);
                    editor.hideDialog();
                }
            });
        });
    });
	K('.insertfile').click(function() {
		var whatid=$(this).attr("iid");
		editor.loadPlugin('insertfile', function() {
			editor.plugin.fileDialog({
				fileUrl : K('#'+whatid).val(),
				clickFn : function(url, title) {
					K('#'+whatid).val(url);
					editor.hideDialog();
				}
			});
		});
	});
});
$(function () {
	/*洲/国家/城市联动*/
    $("#s1").change(function(){
        $("#s2").empty();
		$("#s3").empty();
        var s1=$(this).val();
        $.ajax({
            url: "?show=searchCountryOrCity",
            data: {'parid': s1},
            type: "post",
            success: function (json) {
				$("#s2").append($("<option>").val('').text('请选择'));
                $.each(json,function(i,item){
                    $("#s2").append($("<option>").val(item.id).text(item.classname));
                });
            }, error: function (error) {
                console.log(error);
            }
        });
    });
	$("#s2").change(function(){
        $("#s3").empty();
        var s2=$(this).val();
        $.ajax({
            url: "?show=searchCountryOrCity",
            data: {'parid': s2},
            type: "post",
            success: function (json) {
                $.each(json,function(i,item){
                    $("#s3").append($("<option>").val(item.id).text(item.classname));
                });
            }, error: function (error) {
                console.log(error);
            }
        });
    });
    $(".tbExbtn").click(function(){
        var extype=$(this).attr("id");
        $('#ListTbl').tableExport({type:extype,escape:'false'});
    });
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
	$("#closeFun").click(function(){
       var index=parent.layer.getFrameIndex(window.name); //获取窗口索引
		//parent.location.reload();
		parent.layer.msg('已关闭');
		parent.layer.close(index);
    });
	/*弹窗选择*/
	$(".selectOpen").click(function(){
		var url=$(this).attr('url');   		//调用模块地址
		var what=$(this).attr('what');  	//多选还是单选
		var iname=$(this).attr('iname');   	//回调input的ID
		layer.open({
			skin: 'layui-layer-lan', //默认皮肤
			type: 2,
			title: false, //标题
			closeBtn:0,
			area: ['90%', '90%'], //宽高
			shade: 0.8,
			zIndex:1,
			scrollbar: false,
			content: "/index.php/Home/"+url+"/toselect?what="+what+"&iname="+iname
		});
	});
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
function _del(table) {
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
function _view(url) {
    var czid=$("#czid").val();
    if(czid=='') {
        layer.msg('请选择要查看的行', function(){});
        return false;
    }else{
        window.open(url+"?czid="+czid,"_blank");
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
</script>
</head>
<body id="Bstyle" class='skin-blue sidebar-collapse sidebar-mini'>
<!-- 框架开始 -->
  <!-- 正文 -->
  <section class='content'>
    <div id="tishi"></div>
    <div class="row">
        <div class="col-xs-12">
          <block name="location"></block>
          <block name="main">内容</block>
        </div>
    </div>
  </section>
<script>
</script>
</body>
</html>