<extend name="Public/base" />
<block name="main">
  <!--意向单操作界面-->
  <div class="footerbtn">
    <button id="saveFun" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
    <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i>Refresh</button>
    <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
  </div>
  <form method='post' id="addForm" action='' class="layui-form">
      <input type=hidden id="czid" value="{$czid}" checked>
      <input type="hidden" id="cid" name="cid" value="{$cid}" id="cid" checked>
      <table class='table table-striped'>
          <tr>
              <td align="right"><font color="red" size=4></font>Intention Item</td>
              <td colspan="3" style="line-height: 27px">{$result['expo']}</td>
          </tr>
          <tr>
              <td align="right">Intentional Enterprise</td>
              <td>
                  <volist name=":ShowList('company','id='.$cid,'id')" id="vo">
                      {$vo.title}
                  </volist>
              </td>
              <td align="right">Est. Close</td>
              <td>
                  <input id="estclose" name="estclose" value="{$result['estclose']}" class="layui-input" onclick="layui.laydate({elem: this, festival: true})" style="width: 168px" >
              </td>
          </tr>
          <tr>
              <td align="right">Intention Source</td>
              <td>
                  <div class="layui-input-inline">
                      <select id="source" name="source" lay-verify="source" lay-search>
                          <option value="0">Please Select</option>
                          <volist name=":ShowList('class','parid=1646','id')" id="vo">
                          <option value='{$vo.id}' <if condition="$result['source'] eq $vo['id']">selected</if>>{$vo.classname}</option>
                          </volist>
                      </select>
                  </div>
              </td>
              <td align="right">Intention Probability</td>
              <td>
                  <div class="layui-input-inline">
                      <select id="probability" name="probability" lay-verify="probability" lay-search>
                          <option value="0">Please Select</option>
                          <volist name=":ShowList('class','parid=1652','id')" id="vo">
                          <option value='{$vo.id}' <if condition="$result['probability'] eq $vo['id']">selected</if>>{$vo.classname}</option>
                          </volist>
                      </select>
                  </div>
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
              <td align="right">Contacts</td>
              <td>
                  <div class="layui-input-inline">
                          <select id="memberid" name="memberid" lay-verify="memberid" lay-search>
                          <option value="0">Please Select</option>
                          <volist name=":ShowList('member','cid='.$cid,'id')" id="vo">
                          <option value='{$vo.id}'<if condition="$result['memberid'] eq $vo['id']">selected</if>>{$vo.fullname}</option>
                          </volist>
                      </select>
                  </div>
              </td>
              <td align="right">Sqm</td>
              <td  class="form-inline">
                  <div class="layui-input-inline">
                      <input type="text" name="acreage" id="acreage" class="layui-input" value="{$result.acreage}" style="width: 168px">
                  </div>
              </td>
          </tr>
          <input type="hidden" name="uptime" id="time">
      </table>
  </form>
  <script>
    /*重置表单*/
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
    resetFrom();
    $(document).on('blur',"#acreage",function(){
        var str=$(this).val();
        if(str){
            var a=str.replace(/,/,"");
            var b=a.replace('.00',"");
            $(this).val(b);
            var re = /^[0-9]+.?[0-9]*$/;
            if(!re.test($(this).val())){
              layer.msg('Please enter a numeric format');
            }
        }
    });
    $("#saveFun").click(function(){
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
//            window.parent.DatablesReload("table");
            parent.location.reload();
            parent.layer.msg(res.msg, {icon: res.code});
            parent.layer.close(index);
            p.location="/CRM/index.php/Home/Orders/view?czid="+res.oid;
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
