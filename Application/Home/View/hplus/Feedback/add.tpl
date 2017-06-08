<extend name="Public/base" />
<block name="main">
  <script src="__JS__/jquery.range.js"></script>
  <link rel="stylesheet" href="__JS__/jquery.range.css">
  <script>
    $(function(){
      $('.single-slider').jRange({
        from: 0,
        to: 100,
        step: 1,
        scale: [0,25,50,75,100],
        format: '%s',
        width: 300,
        showLabels: true,
        showScale: true
      });
      $('.range-slider').jRange({
        from: 0,
        to: 100,
        step: 1,
        scale: [0,25,50,75,100],
        format: '%s',
        width: 300,
        showLabels: true,
        isRange : true
      });
    });
  </script>
  <div class="footerbtn">
    <button class="btn btn-success" id="addFun"><i class="fa fa-save"></i> Save</button>
    <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i> Refresh</button>
    <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
  </div>
  <form action='' method='post' id="addForm">
    <table class='table table-striped'>
      <tr>
        <td style=" vertical-align:middle;" align="right"><strong><font color="red">*</font>Score</strong></td>
        <td class="form-inline">
          <div class="demo">
            <input id="score" name="score" type="hidden" class="single-slider" value="100" />
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <span style="margin-left:135px;">
            After 35 working days, AEG Engineers give me birth on <span style="background:#c7ddef">15 April</span>.<br>
          </span><br>
          <span style="margin-left:135px;">
          I am your assistant <span style="background:#c7ddef">AC1.0</span>,glad to assist you to be the <span style="background:#c7ddef">No.1</span> Exhibition Group in America.<br>
          </span><br>
          <span style="margin-left:135px;">
            Now please rate my service from 0-100 of your satisfaction <span style="background:#c7ddef">(0=Bad 100=Excellent)</span> and send me your comment here.<br>
          </span><br>
          <span style="margin-left:135px;">
            You deserve every happy days!
          </span>
        </td>
      </tr>
      <tr>
        <td style=" vertical-align:middle;" align="right">Feedback</strong></td>
        <td class="form-inline"><textarea name="note" id="note" cols="60" rows="10"></textarea></td>
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
      var note = $("#note");
      if (note.val() == "") {
        layer.msg('Please fill in the feedback!');
        console.log(error);
      }
      //表单验证
      if(!_inputcheck()){
        return false;
      }
      var aa = $(".single-slider").val();
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
