<extend name="Public/base" />
<block name="main">
  <!--项目操作界面-->
	<form  action='' class="layui-form">
	<div class="footerbtn">
		<button lay-submit lay-filter="saveFun" class="btn btn-success"><i class="fa fa-save"></i>Save</button>
		<button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i>Refresh</button>
		<button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
	</div>
    <table class='table table-striped'>
	  	<tr>
            <td width="120" align="right"><strong><font color="red">*</font>Project Item</strong></td>
            <td colspan="3">
				<input id="title" name="title" lay-verify="title"  type="text" class="layui-input" style="width: 400px" placeholder="Please enter a project name" />
			</td>
	  	</tr>
	  	<tr>
            <td align="right"><strong>month</strong></td>
            <td class="form-inline">
			  	<div class="input-group">
			  	<select name="pmonth" id="pmonth">
                	<option value="">Select</option>
					<for start="1" end="13">
						<option value="{$i}">{$i}</option>
					</for>
				</select>
			  <span class="input-group-addon">(The project will be held in the general month)</span>		      </div>            </td>
	  	</tr>
		<tr>
			<td align="right"><strong>First time</strong></td>
			<td class="form-inline">
				<div class="input-group">
					<input name="sjtime" id="sjtime" placeholder="Please enter the first time" type="text" class="layui-input" onclick="layui.laydate({elem: this, festival: true})" />
				</div>
				<div class="input-group">
					<span class="input-group-addon">Holding cycle</span>
					<select id='zhouqi' name="zhouqi" class=''>
						<option value=''>Select</option>
						<volist name=":ShowList('class','parid=1635','id')" id="vo">
							<option value='{$vo.id}'>{$vo.classname}</option>
						</volist>
					</select>
				</div>
			</td>
		</tr>
        <tr>
          	<td align="right"><strong><strong><font color="red">*</font>Countries</strong></td>
			<td>
			  	<div class="layui-input-inline" style="width: 150px;">
				  	<select id='s1' name='s1' lay-verify="s1" lay-filter="s1">
					 	<option value=''>Select</option>
					 	<volist name=":ShowList('class','parid=1619','id')" id="vo">
							<option value='{$vo.id}'>{$vo.classname}</option>
						</volist>
				  	</select>
			  	</div>
			  	<div class="layui-input-inline">
					  <select id='s2' name='s2' lay-verify="s2" lay-filter="s2">
						  <option value="">Select</option>
					  </select>
			  	</div>
			</td>
        </tr>
		<tr>
			<td align="right"><strong>Project industry</strong></td>
			<td class="layui-input-inline">
				<select id='hangye' name='hangye' style="width: 150px;">
					<option value=''>Select</option>
					<volist name=":ShowList('class','parid=1626','id')" id="vo">
						<option value='{$vo.id}'>{$vo.classname}</option>
					</volist>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"><strong>Project Description</strong></td>
			<td colspan="3"><textarea name="content" id="content" class="layui-textarea"></textarea></td>
		</tr>
		<input type="hidden" name="posttime" id="time">
	  </table>

  </form>
<script>
	layui.use('form', function() {
		var form = layui.form();
		form.verify({
			title: function(value){
				if(!value){
					return 'The project name should not be empty';
				}
			}
			,s1: function(value){
				if(!value){
					return 'Please fill in the continent';
				}
			}
			,s2: function(value){
				if(!value){
					return 'The state may not be empty';
				}
			}
		});
		form.on('submit(saveFun)', function(data){
			var param=$('form').serialize();
			var p=window.open('about:blank');
			$.ajax({
				url: "{:U('add?act=create')}",
				type: "post",
				data:param,
				success: function (res) {
					if (res.code == 1) {
						var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
						window.parent.DatablesReload("table");
						parent.layer.msg(res.msg, {icon: res.code});
						parent.layer.close(index);
						p.location="/CRM/index.php/Home/Project/view?czid="+res.hid;
					} else {
						layer.msg(res.msg, {icon: res.code});
					}
				}, error: function (error) {
					layer.msg('请求错误', {icon: 2});
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
	$(function(){
		var $timeStr=showtime();
		$("#time").val($timeStr) ;
	});
</script>
</block>
