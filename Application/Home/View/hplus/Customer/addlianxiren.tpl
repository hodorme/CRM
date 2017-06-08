<extend name="Public/base" />
<block name="main">
  <!--联系人操作界面-->
	<div class="footerbtn">
		<button class="btn btn-success" id="addFun"><i class="fa fa-save"></i> Save</button>
		<button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i> Refresh</button>
		<button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
	</div>
	<form action='' method='post' id="addForm">
		<input type=hidden id="czid" value="{$czid}" checked>
		<table class='table table-striped'>
			<tr>
				<td align="right"><strong>Prefix</strong></td>
				<td class="layui-form" colspan="3">
					<div class="layui-input-inline">
						<select id='prefix' name='prefix' lay-filter="prefix">
							<option value='0'>Please Select</option>
							<volist name=":ShowList('class','parid=1655','id')" id="vo">
								<option value='{$vo.id}'>-{$vo.classname}</option>
							</volist>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right"><strong><font color="red" style="font-size:18px;">*</font>First Name</strong></td>
				<td width="10%">
					<if condition="$cid">
						<input id="cid" name="cid" type="hidden" class="layui-input" value="{$cid}" style="width: 140px;">
					</if>
                        <span class="input-group pull-left">
                            <input id="fullname" name="fullname" type="text" class="layui-input" style="width: 140px;">
                        </span>
                </td>
                <td align="right" width="240px"><strong class="pull-left" style="margin-top: 3px;">&nbsp;&nbsp;Middle Name&nbsp;&nbsp;</strong>
                    <span class="input-group pull-left">
                        <input id="middlename" name="middlename" type="text" class="layui-input" style="width: 120px;">
                    </span>
                </td>
                <td align="right"><strong class="pull-left" style="margin-top: 3px;">&nbsp;&nbsp;Last Name&nbsp;&nbsp;</strong>
                    <span class="input-group pull-left">
                        <input id="familyname" name="familyname" type="text" class="layui-input" style="width: 130px;">
                    </span>
				</td>
			</tr>
			<tr>
				<td align="right"><strong style="margin-top: 3px;">Position</strong></td>
				<td class="layui-form">
					<span class="input-group">
						<input id="position" name="position" type="text" class="layui-input" style="width: 170px;">
					</span>
				</td>
				<td align="right"><strong style="margin-top: 3px;">Department</strong></td>
				<td>
					<span class="input-group">
						<input id="bumen" name="bumen" type="text" class="layui-input" style="width: 170px;">
					</span>
				</td>
			</tr>
			<tr>
				<td align="right"><b><font color="red" style="font-size:18px;">*</font>Language</b></td>
				<td class="layui-form" colspan="3">
					<volist name=":ShowList('class','parid=1649','id')" id="vo">
						<input style="width: 170px;" type="radio" name="language" value="{$vo.id}" title="{$vo.classname}" <if condition="$czid"><if condition="$vo['id'] eq $edit['language']">checked</if></if>>
					</volist>
				</td>
			</tr>
			<tr>
				<td align="right"><strong>Contact Number1</strong></td>
				<td class="form-inline" colspan="3">
					<span class="input-group num">
						<input id="telarea" name="telarea" type="text" class="layui-input" size="8"/>
					</span>
					<span class="input-group num">
						<input id="tel" name="tel" type="text" class="layui-input" size="15">
					</span>
					<span class="input-group num">
						<input id="fenji" name="fenji" type="text" class="layui-input" size="8">
					</span>
				</td>
			</tr>
			<tr>
				<td align="right"><strong>Contact Number2</strong></td>
				<td class="form-inline" colspan="3">
					<span class="input-group num">
						<input id="telarea1" name="telarea1" type="text" class="layui-input" size="8"/>
					</span>
					<span class="input-group num">
						<input id="tel1" name="tel1" type="text" class="layui-input" size="15">
					</span>
					<span class="input-group num">
						<input id="fenji1" name="fenji1" type="text" class="layui-input" size="8">
					</span>
				</td>
			</tr>
			<tr>
				<td align="right"><strong>Fax</strong></td>
				<td class="form-inline" colspan="3">
					<span class="input-group num">
						<input id="faxarea" name="faxarea" type="text" class="layui-input" size="8" />
					</span>
					<span class="input-group num">
						<input id="fax" name="fax" type="text" class="layui-input" size="20">
					</span>
				</td>
			</tr>
			<tr>
				<td align="right"><strong>Mobile Phone</strong></td>
				<td class="form-inline" colspan="3">
					<span class="input-group num">
						<input id="marea" name="marea" type="text" class="layui-input" size="8">
					</span>
					<span class="input-group num">
						<input id="mobile" name="mobile" type="text" class="layui-input" size="20">
					</span>
				</td>
			</tr>
			<tr>
				<td align="right"><strong>Email1</strong></td>
				<td class="form-inline">
					<span class="input-group">
						<input id="email" name="email" type="text" class="layui-input" size="40">
					</span>
				</td>
				<td align="right"><strong>Email2</strong></td>
				<td class="form-inline">
					<span class="input-group">
						<input id="email1" name="email1" type="text" class="layui-input" size="40">
					</span>
				</td>
			</tr>
			<if condition="$czid">
				<input type="hidden" name="posttime" id="time">
			<else/>
				<input type="hidden" name="updatedtime" id="time">
			</if>
		</table>
	</form>
	<script>
			$("#email").blur(function(){
				var email=$("#email").val();
				var sear=new RegExp('@');
				if(!sear.test(email)){
					layer.msg('Email1 Incorrect format!');
					console.log(error);
				}
			});
			$("#email1").blur(function(){
				var email1=$("#email1").val();
				var sear=new RegExp('@');
				if(!sear.test(email1)){
					layer.msg('Email2 Incorrect format!');
					console.log(error);
				}
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
		$(function () {
			/*重置表单*/
			resetFrom();
			var act="create";
			var czid=$("#czid").val();
			<!--客户姓名不能为空-->

			if(czid){
				//获取编辑数据
				$.ajax({
					url: "?show=edit&czid="+czid,
					type: "post",
					success: function (json) {
						$.each(json, function (i, item) {
							$("#fullname").val(item.fullname);
							$("#middlename").val(item.middlename);
							$("#familyname").val(item.familyname);
							$("#position").val(item.position);
							$("#bumen").val(item.bumen);
							$("#telarea").val(item.telarea);
							$("#telarea1").val(item.telarea1);
							$("#tel").val(item.tel);
							$("#tel1").val(item.tel1);
							$("#faxarea").val(item.faxarea);
							$("#fax").val(item.fax);
							$("#fenji").val(item.fenji);
							$("#fenji1").val(item.fenji1);
							$("#marea").val(item.marea);
							$("#mobile").val(item.mobile);
							$("#email").val(item.email);
							$("#email1").val(item.email1);
							layui.use('form', function(){
								var form = layui.form();
								if(item.prefix){
									$("#prefix").val(item.prefix);
									form.render();
								}
							});
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
				var t = $("#fullname");
				if (t.val() == "") {
					layer.msg('Customer name cannot be empty');
					console.log(error);
				}
				var language = $("#language");
				if (language.val() == "") {
					layer.msg('Must fill');
					console.log(error);
				}
				var email=$("#email").val();
				if(email){
					var sear=new RegExp('@');
					if(!sear.test(email)){
						layer.msg('Email1 Incorrect format!');
						console.log(error);
					}
				}
				var email1=$("#email1").val();
				if(email1){
					var sear1=new RegExp('@');
					if(!sear1.test(email1)){
						layer.msg('Email2 Incorrect format!');
						console.log(error);
					}
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
							parent.layer.msg(res.msg, {icon: res.code});
							parent.location.reload();
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
