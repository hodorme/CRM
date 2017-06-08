<extend name="Public/base" />
<block name="main">
	<!--意向单操作界面-->
	<div class="footerbtn">
		<button class="btn btn-success" id="addFun"><i class="fa fa-save"></i> Save</button>
		<button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i> Refresh</button>
		<button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
	</div>
	<form method='post' id="addForm" action='' class="layui-form">
		<input type=hidden id="czid" value="{$czid}" checked>
		<input type="hidden" id="cid" name="cid" value="{$cid}" id="cid" checked>
		<table class='table table-striped'>
			<tr>
				<td align="right"><font color="red" size=4>*</font>Intention Expo</td>
				<td>
					<div class="layui-input-inline">
						<select id="expoid" name="expoid" lay-search>
							<option value="">Please Select</option>
							<option value="">Please Select</option>
							<volist name=":ShowList('expo','1=1','starttime desc')" id="vo">
								<option value='{$vo.id}'<if condition="$res['title'] eq $vo['title']">selected="selected"</if>>{$vo.title}</option>
							</volist>
						</select>
					</div>
				</td>
				<td align="right">Company Name</td>
				<td>
					<volist name=":ShowList('company','id='.$cid,'id')" id="vo">
						{$vo.title}
					</volist>
				</td>
			</tr>
			<tr>
				<td align="right"><font color="red" size=4>*</font>Est. Close</td>
				<td>
					<input id="estclose" name="estclose" class="layui-input" onclick="layui.laydate({elem: this, festival: true})" style="width: 168px" >
				</td>
				<td align="right">Contacts</td>
				<td>
					<div class="layui-input-inline">
						<select id="memberid" name="memberid" lay-verify="memberid" lay-search>
							<option value="">Please Select</option>
							<option value="">Please Select</option>
							<volist name=":ShowList('member','cid='.$cid,'id')" id="vo">
								<option value='{$vo.id}'<if condition="!$czid"><if condition="$default['id'] eq $vo['id']">selected="selected"</if></if>>{$vo.fullname}</option>
							</volist>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right">Lead Source</td>
				<td>
					<div class="layui-input-inline">
						<select id="source" name="source" lay-verify="source" lay-search>
							<option value="">Please Select</option>
							<option value="">Please Select</option>
							<volist name=":ShowList('class','parid=1646','id')" id="vo">
								<option value='{$vo.id}'<if condition="!$czid"><if condition="$request['source'] eq $vo['id']">selected</if></if>>{$vo.classname}</option>
							</volist>
						</select>
					</div>
				</td>
				<td align="right">Close Probability </td>
				<td>
					<div class="layui-input-inline">
						<select id="probability" name="probability" lay-verify="probability" lay-search>
							<option value="">Please Select</option>
							<option value="">Please Select</option>
							<volist name=":ShowList('class','parid=1652','id')" id="vo">
								<option value='{$vo.id}'>{$vo.classname}</option>
							</volist>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right"><font color="red" size=4>*</font>Booth Type</td>
				<td colspan="3">
					<div class="layui-input-inline">
						<input type="radio" name="boothtype" title="Package Booth" value=1659>
						<input type="radio" name="boothtype" title="Raw Space" value=1660>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right">Sqm</td>
				<td  class="form-inline">
					<div class="input-group">
						<div class="layui-input-inline">
							<input type="text" name="acreage" id="acreage" class="layui-input" style="width: 168px">
						</div>
						<input type="text" value="㎡" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
					</div>
				</td>
				<td align="right">Unit Price</td>
				<td  class="form-inline">
					<div class="input-group">
						<input id="price" name="price" lay-verify="price" type="text" class='layui-input'  size="24"/>
					</div>
					<input type="text" value="$" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
				</td>
			</tr>
			<tr>
				<td align="right">Origin Cost</td>
				<td  class="form-inline">
					<div class="input-group">
						<div class="layui-input-inline">
							<input type="text" name="cdcb" id="cdcb" class="layui-input" style="width: 168px" readonly>
						</div>
						<input type="text" value="$" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
					</div>
				</td>
				<td align="right">Status</td>
				<td>
					<div class="layui-input-inline">
						<select id="status" name="status" lay-search>
							<option value="0">Please Select</option>
							<option value="open" selected>open</option>
							<option value="close-won">close-won</option>
							<option value="close-lost">close-lost</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right">Discount</td>
				<td class="form-inline">
					<div class="layui-input-inline">
						<select id="discounttype" name="discounttype" lay-filter="discounttype" lay-search>
							<option value=''>Please Select</option>
							<option value=''>Please Select</option>
							<option value="percentage">percentage</option>
							<option value="fixed amount">fixed amount</option>
						</select>
					</div>
					<div class="layui-input-inline">
						<input id="discount" name="discount" style="display: none"  type="text" class="layui-input" size="24">
					</div>
				</td>
				<td align="right">Actual Price</td>
				<td>
					<div class="layui-input-inline">
						<input id="actprice" name="actprice" class="layui-input" style="width: 168px" readonly>
					</div>
					<input type="text" value="$" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
				</td>
			</tr>
			<tr>
				<td align="right">Special Offer</td>
				<td>
					<div class="input-group">
						<input id="special" name="special"  type="text" class="layui-input" size="24">
					</div>
				</td>
				<td align="right">Booth Number</td>
				<td  class="form-inline">
					<div class="input-group">
						<input id="boothno" name="boothno" lay-verify="boothno" type="text" class='layui-input'  size="24"/>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right">Acct. Manager</td>
				<td colspan="3">
					<input type="hidden" id="userid" name="userid" value="{$request.userid}">
					<span id="username">
						<volist name=":ShowList('users','id='.$request['userid'],'id')" id="vo">
							{$vo.username}
						</volist>
					</span>
				</td>
			</tr>
			<if condition="$czid">
				<input type="hidden" name="uptime" id="time">
				<else/>
				<input type="hidden" name="posttime" id="time">
			</if>
		</table>
	</form>
	<script>
		layui.use('form', function() {
			var form = layui.form();
                form.on('select(discounttype)', function(data){
                    if(data.value!=""){
                        $("#discount").show();
                    } else {
                        $("#discount").val("");
                        var actprice = $("#cdcb").val();
                        $("#actprice").val(actprice);
                        $("#discount").hide();
                    }
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
			/*重置表单*/
		resetFrom();
		function GetDateStr(AddDayCount){
			var d=new Date();
			d.setDate(d.getDate()+AddDayCount);//获取AddDayCount天后的日期
			var date=d.getDate();
			var m=d.getMonth()+1;
			if(m<10){
				m="0"+m;
			}
			str='';
			str +=d.getFullYear()+'-'; //获取当前年份
			str +=m+'-'; //获取当前月份（0——11）

			if(date<10){
				str =str+"0"+date;
			}else{
				str +=date;
			}
			return str;
		}
		$(function () {
			var $timeStr=GetDateStr(14);
			$("#estclose").val($timeStr);
		});
		$(document).on('blur',"#acreage",function(){
			var str=$(this).val();
			if(str){
				var re = /^[0-9]+.?[0-9]*$/;
				if(!re.test($(this).val())){
					layer.msg('Please enter a numeric format');
				}
			}
		});
		var act="create";
		var czid=$("#czid").val();

		if(czid){
			//获取编辑数据
			$.ajax({
				url: "?show=read&czid="+czid,
				type: "post",
				success: function (json) {
					$.each(json, function (i, item) {
						layui.use('form', function() {
							var form = layui.form();
							if (item.expoid) {
								$("#expoid").val(item.expoid);
							}
							if (item.memberid) {
								$("#memberid").val(item.memberid);
							}
							if (item.source) {
								$("#source").val(item.source);
							}
							if (item.probability) {
								$("#probability").val(item.probability);
							}
							if (item.discounttype) {
								$("#discounttype").val(item.discounttype);
								$("#discount").show();
							}
							$("input[name='boothtype'][value="+item.boothtype+"]").attr("checked",true);
							form.render();
						});
						$("#cid").val(item.cid);
						$("#estclose").val(item.estclose);
						$("#price").val(item.price);
						$("#acreage").val(item.acreage);
						$("#cdcb").val(item.cdcb);
						$("#actprice").val(item.actprice);
						$("#boothno").val(item.boothno);
						$("#special").val(item.special);
						$("#discount").val(item.discount);
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
			var expoid = $("#expoid");
			var rad=$("input[name='boothtype']");
			var b2=true;
			for(var j=0;j<rad.length;j++){
				if(rad[j].checked) {
					b2=false;
					break;
				}
			}
			if(b2){
				layer.msg('Booth type not empty!');
				console.log(error);
			}
			if (expoid.val() == "" || expoid.val() == 0) {
				layer.msg('Must fill in Expo');
				console.log(error);
			}
			var estclose = $("#estclose");
			if (estclose.val() == "") {
				layer.msg('Must fill in language');
				console.log(error);
			}
			//表单验证
			if(!_inputcheck()){
				return false;
			}
			var p=window.open('about:blank');
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
						p.location="/CRM/index.php/Home/Orders/view?detil=leads&czid="+res.oid;
					} else {
						layer.msg(res.msg, {icon: res.code});
					}
				}, error: function (error) {
					layer.msg('Request error', {icon: 2});
					console.log(error);
				}
			});
		}
		$("#acreage,#price").blur(function(){
			if($("#acreage").val() && $("#price").val()){
				var zong=$("#acreage").val()*$("#price").val();
				$("#cdcb").val(zong);
                var cdcb = $("#cdcb").val();
                if($("#discount").val() == ''){
                    $("#actprice").val(zong);
                } else if($("#discounttype").val()=='percentage') {
                    var total = $("#cdcb").val()-($("#cdcb").val()*($("#discount").val()/100));
                    $("#actprice").val(total);
                } else {
					var sum=$("#cdcb").val()-$("#discount").val();
					$("#actprice").val(sum);
				}
			}
		});
		$("#discount").blur(function(){
			if($("#cdcb").val() && $("#discount").val()){
				if($("#discounttype").val()=='percentage'){
					var sum=$("#cdcb").val()-($("#cdcb").val()*($("#discount").val()/100));
					var num=sum.toFixed(2);
					$("#actprice").val(num);
				}else if($("#discounttype").val()=='fixed amount'){
					var sum=$("#cdcb").val()-$("#discount").val();
					$("#actprice").val(sum);
				}
			}
		});
	</script>
</block>
