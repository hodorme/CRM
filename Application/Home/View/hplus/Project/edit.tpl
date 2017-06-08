<extend name="Public/base" />
<block name="main">
  <!--项目操作界面-->
	<div class="footerbtn">
		<button id="saveFun" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
		<button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i>Refresh</button>
		<button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
	</div>
	<form  action='' class="layui-form">
    <table class='table table-striped'>
	  	<tr>
            <td width="120" align="right"><strong>Project Item</strong></td>
            <td colspan="3"><input id="title" name="title" type="text" class="layui-input" style="width: 400px" placeholder="Please enter a project name" value="{$res.title}" /></td>
	  	</tr>
	  	<tr>
            <td align="right"><strong>month</strong></td>
            <td class="form-inline">
			  	<div class="input-group">
			  	<select name="pmonth" id="pmonth" lay-verify="required">
                	<option value="">Select</option>
					<for start="1" end="13">
						<option value="{$i}"<if condition="$res['pmonth'] eq $i">selected="selected"</if>>{$i}</option>
					</for>
				</select>
			  <span class="input-group-addon">(The project will be held in the general month)</span>		      </div>            </td>
	  	</tr>
		<tr>
			<td align="right"><strong>First time</strong></td>
			<td class="form-inline">
				<div class="input-group">
					<input name="sjtime" id="sjtime" placeholder="Please enter the first time" type="text" class="layui-input" value="{$res.sjtime}" onclick="layui.laydate({elem: this, festival: true})" />
				</div>
				<div class="input-group">
					<span class="input-group-addon">Holding cycle</span>
					<select id='zhouqi' name="zhouqi" class=''>
						<option value=''>Select</option>
						<volist name=":ShowList('class','parid=1635','id')" id="vo">
							<option value='{$vo.id}'<if condition="$res['zhouqi'] eq $vo['id']">selected="selected"</if>>{$vo.classname}</option>
						</volist>
					</select>
				</div>
			</td>
		</tr>
        <tr>
          	<td align="right"><strong>Countries</strong></td>
			<td>
			  	<div class="layui-input-inline" style="width: 150px;">
				  	<select id='s1' name='s1' lay-filter="s1" lay-verify="required">
					 	<option value=''>请选择</option>
					 	<volist name=":ShowList('class','parid=1619','id')" id="vo">
							<option value='{$vo.id}'<if condition="$res['s1'] eq $vo['id']">selected="selected"</if>>{$vo.classname}</option>
						</volist>
				  	</select>
			  	</div>
			  	<div class="layui-input-inline">
					  <select id='s2' name='s2' lay-filter="s2" lay-verify="required">
						  <option value="{$res['s2']}">{$res.country}</option>
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
						<option value='{$vo.id}'<if condition="$res['hangye'] eq $vo['id']">selected="selected"</if>>{$vo.classname}</option>
					</volist>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"><strong>Project Description</strong></td>
			<td colspan="3"><textarea name="content" id="content" class="layui-textarea">{$res.content}</textarea></td>
		</tr>
		<input type="hidden" name="uptime" id="time">
	  </table>
  </form>
<script>
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
	$("#saveFun").click(function(){
		var param=$('form').serialize();
		$.ajax({
			url: "{:U('edit?act=edit',array('czid'=>$czid))}",
			type: "post",
			data:param,
			success: function (res) {
				if (res.code == 1) {
					var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
					parent.layer.msg('Save success', {icon: res.code});
					parent.location.reload();
				} else {
					layer.msg('Update success', {icon: res.code});
				}
			}, error: function (error) {
				layer.msg('Request error', {icon: 2});
				console.log(error);
			}
		});
	});
</script>
</block>
