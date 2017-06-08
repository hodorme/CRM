<extend name="Public/base" />
<block name="main">
  <!--联系记录操作界面-->
	<div class="footerbtn">
		<button class="btn btn-success" id="addFun"><i class="fa fa-save"></i> Save</button>
		<button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i> Refresh</button>
		<button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
	</div>
	<form method='post' id="addForm" action=''>
		<table class='table table-striped'>
			<if condition="$info">
			<tr>
				<td>ID</td>
				<td>Expo</td>
				<td>Close Probability </td>
			</tr>
			<tr>
				<td>{$info.id}</td>
				<td>
					<if condition="$info['expoid']">
					<volist name=":ShowList('expo','id='.$info['expoid'],'id')" id="vo">
						<a href="{:U('Home/Expo/view')}?czid={$info.expoid}" target="_blank">{$vo.title}</a>
					</volist>
					</if>
				</td>
				<td class="layui-form">
					<div class="layui-input-inline">
						<select id="probability" name="probability" lay-verify="probability" lay-search>
							<option value="0">Please Select</option>
							<volist name=":ShowList('class','parid=1652','id')" id="vo">
								<option value='{$vo.id}' <if condition="$info['probability'] eq $vo['id']">selected</if>>{$vo.classname}</option>
							</volist>
						</select>
					</div>
				</td>
			</tr>
			</if>
			<tr>
				<td width="150" align="right"><font color="red" style="font-size:18px;">*</font>Next Contact Time</td>
				<td>
					<input type="text" id="nexttime" name="nexttime" class="laydate-icon datee"><span id="count"></span>
				</td>
				<td></td>
			</tr>
			<tr>
				<td width="150" align="right"><font color="red" style="font-size:18px;">*</font>Record Content</td>
				<td >
					<textarea name="note" id="note" cols="60" rows="3"></textarea>
					<input id="cid" name="cid" type="hidden" class="form-control" value="{$cid}">
				</td>
				<td></td>
			</tr>
			<tr>
				<td width="150" align="right">This Contact</td>
				<td class="layui-form">
					<div class="layui-input-inline">
						<select id='contact' name='contact' lay-filter="contact">
							<volist name=":ShowList('member','cid='.$cid,'id')" id="vo">
								<option value="{$vo.id}">{$vo.fullname}</option>
							</volist>
						</select>
					</div>
				</td>
				<td></td>
			</tr>
			<tr>
				<td width="150" align="right"><font color="red" style="font-size:18px;">*</font>Contacting Method</td>
				<td class="layui-form">
					<div class="layui-input-inline">
						<select id='contacting' name='contacting' lay-filter="contacting">
								<option value="0">Please Select</option>
							<volist name=":ShowList('class','parid=1666','id')" id="vo">
								<option value="{$vo.id}">{$vo.classname}</option>
							</volist>
						</select>
					</div>
				</td>
				<td></td>
			</tr>
		</table>
		<input type="hidden" id="posttime" name="posttime">
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
		  $("#posttime").val($timeStr) ;
	  });
	  layui.use('form', function() {
		  var form = layui.form();
		  $(".datee").click(function(){
			  layui.laydate({
				  elem: this,
				  festival: true,
				  choose:function(dates){
					  var value = dates;
					  var col=$(".datee").attr('col');
					  if(value){
							var cid=$("#cid").val();
							$.ajax({
								  url: "{:U('Home/Customer/nexttime')}?nexttime="+value+"&cid="+cid,
								  type: "post",
								  success: function (json) {
									  $("#count").html('<b> <font style="color:red;">'+json+'</font></b>Company(s) Arranged on Selected Date');
								  }
							});
					  }
				  }
			  });
		  });
	  });
    /*重置表单*/
    resetFrom();
	var act="create";
	var czid=$("#czid").val();
	$("#addFun").click(function(){
        _save(act);
    });
    /*响应添加 修改*/
    function _save(act) {
		var param = $("#addForm").serialize();
		//表单验证
		var nexttime = $("#nexttime");
		if (nexttime.val() == '') {
			layer.msg('The Next Contact Time Required!');
			console.log(error);
		}
		var note = $("#note");
		if (note.val() == '') {
			layer.msg('Contact Content Cannot be Empty!');
			console.log(error);
		}
		var note = $("#note");
		if (note.val() == '') {
			layer.msg('Contact Content Cannot be Empty!');
			console.log(error);
		}
		var contacting = $("#contacting");
		if (contacting.val() == '') {
			layer.msg('Contact Cannot be Empty!');
			console.log(error);
		}
		if(!_inputcheck()){
		  return false;
		}
		$.ajax({
			url: "?act="+act+"&oid={$info.id}&cid={$data.id}",
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
</script>
</block>
