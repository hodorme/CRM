<extend name="Public/base" />
<block name="main">
    <form method='post' id="addForm" action='' class="layui-form">
    <div class="footerbtn">
        <button lay-submit lay-filter="saveFun" class="btn btn-success"><i class="fa fa-save"></i>Save</button>
        <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i>Refresh</button>
        <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
    </div>
        <input type=hidden id="czid" value="{$czid}" checked>
        <input type="hidden" id="cid" name="cid" value="{$cid}" id="cid" checked>
        <table class='table table-striped'>
            <tr>
                <td align="right"><font color="red" size=4>*</font>Intention Expo</td>
                <td>
                    <div class="layui-input-inline">
                        <select id="expoid" name="expoid" lay-search>
                            <option value="0">Please Select</option>
                            <volist name=":ShowList('expo','1=1','starttime desc')" id="vo">
                                <option value='{$vo.id}'<if condition="$result['expoid'] eq $vo['id']">selected="selected"</if>>{$vo.title}</option>
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
                <td align="right">Booth Type</td>
                <td colspan="3">
                    <div class="layui-input-inline">
                        <input type="radio" name="boothtype" title="Package Booth" value=1659 <if condition="$result['boothtype'] eq 1659">checked</if>>
                        <input type="radio" name="boothtype" title="Raw Space" value=1660 <if condition="$result['boothtype'] eq 1660">checked</if>>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">Sqm</td>
                <td  class="form-inline">
                    <div class="input-group">
                        <div class="layui-input-inline">
                            <input type="text" name="acreage" id="acreage" value="{$result['acreage']}" class="layui-input" style="width: 168px">
                        </div>
                        <input type="text" value="㎡" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
                    </div>
                </td>
                <td align="right">Unit Price</td>
                <td  class="form-inline">
                    <div class="input-group">
                        <input id="price" name="price" lay-verify="price" value="{$result['price']}" type="text" class='layui-input'  size="24"/>
                    </div>
                    <input type="text" value="$" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
                </td>
            </tr>
            <tr>
                <td align="right">Origin Cost</td>
                <td  class="form-inline" colspan="3">
                    <div class="input-group">
                        <div class="layui-input-inline">
                            <input type="text" name="cdcb" id="cdcb" value="{$result['cdcb']}" class="layui-input" style="width: 168px" readonly>
                        </div>
                        <input type="text" value="$" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">Discount</td>
                <td class="form-inline">
                    <div class="layui-input-inline">
                        <select id="discounttype" name="discounttype" lay-filter="discounttype" lay-search>
                            <option value="0">Please Select</option>
                            <option value="percentage" <if condition="$result['discounttype'] eq 'percentage'">selected="selected"</if>>percentage</option>
                            <option value="fixed amount" <if condition="$result['discounttype'] eq 'fixed amount'">selected="selected"</if>>fixed amount</option>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <input id="discount" name="discount" value="{$result['discount']}"  type="text" class="layui-input" size="24" <if condition="$result['discount'] eq 0">style="display: none"</if>>
                    </div>
                </td>
                <td align="right">Actual price</td>
                <td>
                    <div class="layui-input-inline">
                        <input id="actprice" name="actprice" value="{$result['actprice']}" class="layui-input" style="width: 168px" readonly>
                    </div>
                    <input type="text" value="$" style="width: 30px;height: 25px;position: relative;left: -31px;top: 1px;text-align: center" disabled>
                </td>
            </tr>
            <tr>
                <td align="right">Special Offer</td>
                <td>
                    <div class="input-group">
                        <input id="special" name="special"  value="{$result['special']}" type="text" class="layui-input" size="24">
                    </div>
                </td>
                <td align="right"><font color="red" style="font-size:18px;">*</font>Booth Number</td>
                <td  class="form-inline">
                    <div class="input-group">
                        <input id="boothno" name="boothno" value="{$result['boothno']}" lay-verify="boothno" type="text" class='layui-input'  size="24"/>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right"><font color="red" style="font-size:18px;">*</font>Signing date</td>
                <td>
                    <input id="qydate" name="qydate"  lay-verify="qydate" value="{$result['qydate']}" class="layui-input" onclick="layui.laydate({elem: this, festival: true})" style="width: 168px" >
                </td>
                <td align="right">Est. payment date</td>
                <td>
                    <input id="paymentdate" name="paymentdate" value="{$result['paymentdate']}"  class="layui-input" onclick="layui.laydate({elem: this, festival: true})" style="width: 168px" >
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
            <input type="hidden" name="uptime" id="time">
        </table>
    </form>
    <script>
        resetFrom();
        layui.use('form', function() {
            var form = layui.form();
            form.on('select(discounttype)', function(data){
                $("#discount").show();
            });
            form.verify({
                price: function(value){
                    if(!value){
                        return 'The amount can not be empty';
                    }
                }
                ,boothno: function(value){
                    if(!value){
                        return 'Booth number may not be empty';
                    }
                }
                ,qydate: function(value){
                    if(!value){
                        return 'The date of signing must not be empty';
                    }
                }
            });
            form.on('submit(saveFun)', function(data){
                var param = $("#addForm").serialize();
                var p=window.open('about:blank');
                $.ajax({
                    url: "?act=edit&czid={$czid}",
                    data: param,
                    dataType: 'json',
                    type: 'POST',
                    success: function (res) {
                        if(res.code==1){
                            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
//                        window.parent.DatablesReload("table");
                            parent.location.reload();
                            parent.layer.msg(res.msg, {icon: res.code});
                            parent.layer.close(index);
                            p.location="/CRM/index.php/Home/Orders/view?czid="+res.oid;
                        } else {
                            layer.msg(res.msg, {icon: res.code});
                        }
                    }, error: function (error) {
                        layer.msg('Request error', {icon: 2});
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
            return str;
        }
        $(function(){
            var $timeStr=showtime();
            $("#time").val($timeStr) ;
        });
        $("#acreage,#price").blur(function(){
            if($("#acreage").val() && $("#price").val()){
                var zong=$("#acreage").val()*$("#price").val();
                $("#cdcb").val(zong);
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
