<extend name="Public/base" />
<block name="main">
    <input type=hidden id="czid" checked>
    <ul class="nav nav-tabs">
        <volist name=":ShowList('sys_menu','flag=2 and sid in(9,10,11,12,13)','seq')" id="vo">
            <li class=<if condition="$vo['title'] eq $modular">active</if>> <a href="/index.php/Home/{$vo.url}">{$vo.title}</a></li>
        </volist>
    </ul>
    <div class="form-inline searchbar">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
            <button id="editFun" class="btn btn-warning"><i class="fa fa-edit"></i> 修改</button>
            <button id="delFun" class="btn btn-danger"><i class="fa fa-remove"></i> 删除</button>
            <button type="button" class="btn btn-info" id="btnRefresh"><i class="fa fa-refresh"></i> 刷新</button>
        </div>
        <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
            <button id="addFun" class="btn btn-success"><i class="fa fa-plus"></i>添加</button>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">编码名称</span>
                <input type="text" value="{$keyword}" id="keyword" placeholder="输入查询关键字" class="form-control sbtn" col="1">
            </div>
        </div>
        <select id='ssid' class='form-control sselect' col="4">
            <option value=''>父级</option>
            <volist name=":SidType(0,'sys_code')" id="vo">
                <option value='{$vo.name}'>{$vo.name}</option>
                <volist name=":SidType($vo['id'],'sys_code')" id="vo">
                    <option value='{$vo.name}'>┗━ {$vo.name}</option>
                </volist>
            </volist>
        </select>
    </div>
      <table id="ListTbl" class="table table-striped table-bordered hover">
        <thead class="bg-info">
          <tr>
            <th>序号</th>
            <th>编码名称</th>
            <th>英文代码</th>
            <th>编码描述</th>
            <th>父级</th>
            <th>显示排序</th>
            <th>更新时间</th>
            <th>ID</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    <!--数据输入界面-->
    <form action='' method='post' id="addForm">
      <table class='table table-striped'>
        <tr>
          <td width="100">编码名称</td>
          <td><input id="name" name="name" type="text" class="form-control" placeholder="填写编码名称"></td>
        </tr>
      <tr>
          <td>英文代码</td>
          <td><input id="code" name="code" type="text" class="form-control" placeholder="填写英文代码"></td>
      </tr>
        <tr>
          <td>编码描述</td>
          <td><input id="note" name="note" type="text" class="form-control" placeholder="填写编码描述"></td>
        </tr>
        <tr>
          <td>显示排序</td>
          <td><input id="seq" name="seq" type="text" class="form-control" placeholder="填写显示排序" value="{$seq}"></td>
        </tr>
        <tr>
          <td>父级</td>
          <td><select id='sid' name='sid' class='form-control'>
                <option value=''>请选择</option>
                <volist name=":ShowList('sys_code','sid=0','seq')" id="vo">
                <option value='{$vo.id}'>┗ {$vo.name}</option>
                <volist name=":SidType($vo['id'],'sys_code')" id="vo">
                    <option value='{$vo.id}'<if condition="$ssid eq $vo['id']">selected</if>>┗━ {$vo.name}</option>
                    <volist name=":SidType($vo['id'],'sys_code')" id="vo">
                    <option value='{$vo.id}'<if condition="$ssid eq $vo['id']">selected</if>>┗━━ {$vo.name}</option>
                    </volist>
                </volist>
              </volist>
            </select></td>
        </tr>
      </table>
    </form>
  <script>
  $(function () {
      /*基础设置*/
      $("#addForm").hide();
      resetFrom();
      $("#addFun").click(function(){
          _save("create");
      });
      $("#editFun").click(function(){
          _save("edit");
      });
      $("#delFun").click(function(){
          _del(table);
      });
      /*初始化表格*/
      var table = $('#ListTbl').DataTable({
          stateSave: false,
          "sDom": '<"top">rt<"bottom"ip><"clear">',
          bProcessing:true,
          bLengthChange: true,
          paging:true,
          ordering: true,
          info:true,
          searching: true,
          scrollX: true,
          scrollY: 350,
          ajax: "?show=showDataTbale"
      });
      /*调用自定义 */
      _customSearch(table);
      /*单击选择 */
      $('#ListTbl').on('click','tbody tr',function () {
          var czid=$(this).find("td:last").text();;
          if($(this).hasClass('selected') ) {
              $(this).removeClass('selected');
              $('#czid').val('');
          }else{
              table.$('tr.selected').removeClass('selected');
              $(this).addClass('selected');
              $('#czid').val(czid);
          }
      });
      /*双击调出编辑*/
      $('#ListTbl').on('dblclick','tbody tr',function () {
          var czid=$(this).find("td:last").text();
          $('#czid').val(czid);
          _save("edit");
      });
      /*响应添加 修改*/
      function _save(act) {
          resetFrom();
          var czid = $("#czid").val();
          if(act=="edit"){
              if(!czid) {
                  layer.msg('请选择要编辑的行', function(){});
                  return false;
              }else {
                  //获取编辑数据
                  $.ajax({
                      url: "?show="+act+"&czid="+czid,
                      type: "post",
                      success: function (json) {
                          $.each(json, function (i, item) {
                              $("#name").val(item.name);
                              $("#seq").val(item.seq);
                              $("#note").val(item.note);
                              $("#code").val(item.code);
                              $("#sid").val(item.sid);
                          });
                      }
                  });
              }
          }
          layer.open({
              skin: 'layui-layer-lan', //默认皮肤
              type: 1,
              title: "{$modular}", //标题
              area: ['600px', '380px'], //宽高
              shade: 0.8,//遮罩
              zIndex:1,
              content: $('#addForm'), //捕获的元素
              btn: ['保存', '关闭']
              ,yes: function(index, layero){
                  //表单验证
                  if(!_inputcheck()){
                      return false;
                  }
                  $("#pwd").click(function(){
                      alert(1);
                      $(this).removeAttr("readonly");
                      //$(this).attr("disabled",false);
                  });
                  var param = $("#addForm").serialize();
                  $.ajax({
                      url: "?act="+act+"&czid="+czid,
                      data: param,
                      dataType: 'json',
                      type: 'POST',
                      success: function (res) {
                          if(res.code==1){
                              resetFrom();
                              location.reload();
                              layer.msg(res.msg, {icon: res.code});
                              layer.close(index);
                              table.ajax.reload(null,false);
                          } else {
                              layer.msg(res.msg, {icon: res.code});
                          }
                      }, error: function (error) {
                          layer.msg('请求错误', {icon: 2});
                          console.log(error);
                      }
                  });
                  $('#czid').val('');
              },btn2: function(index, layero){
                  layer.close(index);
              }
          });
      }
  });
  </script> 
</block>
