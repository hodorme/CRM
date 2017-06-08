<extend name="Public/base" />
<block name="main">
	<!--收款帐号操作界面-->
	<div class="footerbtn">
		<button class="btn btn-success" id="saveFun"><i class="fa fa-save"></i> Save</button>
		<button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i> Refresh</button>
		<button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
	</div>
	<form method='post' id="addForm" action=''>
		<input type=hidden id="czid" value="{$czid}" checked>
		<table class='table table-striped'>
			<tr>
				<td align="right"><strong><font color="red" style="font-size:18px;">*</font>Roll out Reason</strong></td>
				<td>
					<textarea id="sharingnote" name="sharingnote" rows="3" class="form-control"></textarea>
				</td>
			</tr>
		</table>
	</form>
	<script>
		$(function () {
			/*重置表单*/
			resetFrom();
			var czid=$("#czid").val();
			var act="edit";
			$("#saveFun").click(function(){
				_save(act);
			});
			/*响应添加 修改*/
			function _save(act) {
				var czid=$("#czid").val();
				var param = $("#addForm").serialize();
				var sharingnote = $("#sharingnote");
				if (sharingnote.val() == "") {
					layer.tips('The reason is not empty', '#sharingnote', {
						tips: 3
					});
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
						if(res.code==1){
							var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
							parent.location.reload();
							parent.layer.msg(res.msg, {icon: res.code});
							//parent.zhanguan.ajax.reload(null,false);
							parent.layer.close(index);
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
	</script>
</block>
