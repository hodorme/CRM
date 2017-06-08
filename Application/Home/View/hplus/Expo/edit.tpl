<extend name="Public/base" />
<block name="main">
  <!--展会操作界面-->
    <div class="footerbtn">
        <button id="saveFun" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i>Refresh</button>
        <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
    </div>
    <form id="addForm" action='' class="layui-form">
    <input  name="from" type="hidden"  value="{$from}" />
    <table class='table table-striped'>
      <tr>
        <td align="right"><strong>Subordinate Item</strong></td>
        <td colspan="3" style="line-height:32px;   ">
            <input id="title" name="title" type="text" class="layui-input" value="{$res['title']}" style="width: 470px;"/>
        </td>
      </tr>
      <tr>
        <td align="right"><b>Target Area</b></td>

        <td>
            <div class="input-group" style="width: 200px">
                <input id="mbmianji" name="mbmianji" type="text" class="layui-input" value="{$res.mbmianji}" />
                <span class="input-group-addon">㎡</span>
            <div>
        </td>
      </tr>
      <tr>
        <td align="right"><strong>Project Time</strong></td>
        <td colspan="3" class="form-inline"><div class="input-group">
			  <span class="input-group-addon">start&nbsp;time</span><input id="starttime" name="starttime" value="{$res.starttime}"  type="text" class='layui-input' lay-verify="required" onclick="layui.laydate({elem: this, festival: true})" />
			  </div>
		<div class="input-group">
			  <span class="input-group-addon">end&nbsp;time</span>
            <input id="endtime" name="endtime" type="text" class='layui-input' value="{$res.endtime}" onclick="layui.laydate({elem: this, festival: true})" />
			   </div>
			  </td>
      </tr>
      <tr>
        <td align="right"><strong>Official Website</strong></td>
        <td colspan="3" class="form-inline">
            <input id="website" name="website" type="text" size="40" value="{$res.website}" class="form-control layui-input" />
            <span class="addmsg">(Example:"www.jrexpo.com")</span></td>
      </tr>
      <tr>
        <td align="right"><strong>Exhibition Name</strong></td>
        <td colspan="3" class="form-inline">
            <input id="hallname" name="hallname" value="{$res.hallname}" type="text" size="40" class="form-control layui-input" />
          </td>
      </tr>
      <tr>
        <td align="right"><strong>Exhibition Address</strong></td>
        <td colspan="3" class="form-inline">
            <input id="halladd" name="halladd" type="text" value="{$res.halladd}" style="width: 275px"  class="form-control layui-input" />
            <span class="addmsg">(Google Maps)</span>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top"><strong>Exhibition Introduction</strong></td>
        <td colspan="3"><textarea id="profile" name="profile" rows="5" class="layui-textarea" style="width: 650px">{$res.profile}</textarea>
         </td>
      </tr>
        <input type="hidden" name="uptime" id="time">
    </table>
  </form>
  <br>
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
                  if (res.code == 1 && !res.from) {
                      var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                      window.parent.DatablesReload("table");
                      parent.layer.msg('Update success', {icon: res.code});
                      parent.layer.close(index);
                  } else if(res.code == 1 && res.from=='view') {
                      var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                      parent.layer.msg('Update success', {icon: res.code});
                      parent.location.reload();
                      parent.layer.close(index);
                  }else {
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
