<extend name="Public/base" />
<block name="main">
  <!--航空操作界面-->
  <div class="footerbtn">
    <button class="btn btn-success" id="addFun"><i class="fa fa-save"></i> 保存</button>
    <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i> 刷新</button>
    <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> 关闭</button>
  </div>
  <form action='' method='post' id="addForm">
    <input type="hidden" id="czid" value="{$czid}">
    <input type="hidden" id="djid" name="djid" value="{$djid}">
    <table class='table table-striped'>
      <tr>
        <td style=" vertical-align:middle;" align="right"><strong><font color="red">*</font>部门名称</strong></td>
        <td class="form-inline"><input id="classname" name="classname" type="text" class="form-control" size="50"></td>
      </tr>
      <tr>
        <td style=" vertical-align:middle;" align="right">备注</strong></td>
        <td class="form-inline"><input id="note" name="note" type="text" class="form-control" size="50"></td>
      </tr>
    </table>
  </form>
  <script>
    /*重置表单*/
    resetFrom();
    var act="create";
	var czid=$("#czid").val();
	var djid=$("#djid").val();
	if(czid){
		$('#PageT').html("编辑");
		//获取编辑数据
      $.ajax({
        url: "?show=edit&czid="+czid,
        type: "post",
        success: function (json) {
        $.each(json, function (i, item) {
          $("#classname").val(item.classname);
          $("#note").val(item.note);

        });
      }
    });
		var act="edit";
	}
	$("#addFun").click(function(){
        _save(act);
    });
    /*响应添加 修改*/
    function _save(act) {
      var czid=$("#czid").val();
      var param = $("#addForm").serialize();
      var classname = $("#classname");
      if (classname.val() == "") {
        layer.msg('必须填写部门名!');
        console.log(error);
      }
      //表单验证
      if(!_inputcheck()){
        return false;
      }
      $.ajax({
        url: "?act="+act+"&czid="+czid,
        data: param,
        dataType: 'json',
        type: 'POST',
        success: function (res) {
          console.log(res);
          if(res.code==1){
            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
            parent.layer.msg(res.msg, {icon: res.code});
              window.parent.DatablesReload("table");
            //parent.zhanguan.ajax.reload(null,false);
            parent.layer.close(index);
          } else {
            layer.msg(res.msg, {icon: res.code});
          }
        }, error: function (error) {
          layer.msg('请求错误', {icon: 2});
          console.log(error);
        }
      });
    }
</script>
</block>
