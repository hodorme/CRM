<extend name="Public/base" />
<block name="main">
  <!--展会操作界面-->
    <form id="addForm" action='' class="layui-form">
    <div class="footerbtn">
        <button lay-submit lay-filter="saveFun" class="btn btn-success"><i class="fa fa-save"></i>Save</button>
        <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i>Refresh</button>
        <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
    </div>
    <input type=hidden id="pid" name="pid" value="{$pid}" checked>
    <table class='table table-striped'>
      <tr>
        <td align="right"><strong>Subordinate Item</strong></td>
        <td colspan="3"><input id="project" name="title"  value="{$project}" type="text" class="layui-input" style="width: 500px" /></td>
      </tr>
      <tr>
        <td align="right"><b>Target Area</b></td>

        <td>
            <div class="input-group" style="width: 200px">
                <input id="mbmianji" name="mbmianji" type="text" class="layui-input" />
                <span class="input-group-addon">㎡</span>
            <div>
        </td>
      </tr>
      <tr>
        <td align="right"><strong><font color="red">*</font>Project Time</strong></td>
        <td colspan="3" class="form-inline"><div class="input-group">
			  <span class="input-group-addon">start&nbsp;time</span><input id="starttime" name="starttime" lay-verify="starttime" type="text" class='layui-input' lay-verify="required" onclick="layui.laydate({elem: this, festival: true})" />
			  </div>
		<div class="input-group">
			  <span class="input-group-addon">end&nbsp;time</span>
            <input id="endtime" name="endtime" type="text" class='layui-input' lay-verify="endtime" onclick="layui.laydate({elem: this, festival: true})" />
			   </div>
			  </td>
      </tr>
      <tr>
        <td align="right"><strong>Official Website</strong></td>
        <td colspan="3" class="form-inline"><input id="website" name="website" type="text" size="40" class="form-control layui-input" />
          <span class="addmsg">(Example:"www.jrexpo.com")</span></td>
      </tr>
      <tr>
        <td align="right"><strong>Exhibition Name</strong></td>
        <td colspan="3" class="form-inline">
            <input id="hallname" name="hallname" type="text" size="40" class="form-control layui-input" />
          </td>
      </tr>
      <tr>
        <td align="right"><strong>Exhibition Address</strong></td>
        <td colspan="3">
            <input id="halladd" name="halladd" type="text" style="width: 500px"  class="layui-input" />
            <span class="addmsg">(Google Maps)</span>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top"><strong>Exhibition Introduction</strong></td>
        <td colspan="3"><textarea id="profile" name="profile" rows="5" class="layui-textarea" style="width: 650px"></textarea>
         </td>
      </tr>
        <input type="hidden" name="posttime" id="time">
    </table>
  </form>
  <br>
  <script>
      layui.use('form', function() {
          var form = layui.form();
          form.verify({
              starttime: function(value){
                  if(!value){
                      return 'The start time is not empty';
                  }
              }
              ,endtime: function(value){
                  if(!value){
                      return 'The end time is not empty';
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
                          p.location="/CRM/index.php/Home/Expo/view?czid="+res.expoid;
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
