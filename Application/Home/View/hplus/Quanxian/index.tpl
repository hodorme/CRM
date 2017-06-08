<extend name="Public/base" />
<block name="main">
  <input type=hidden id="czid" checked>
  <ul class="nav nav-tabs">
    <volist name=":ShowList('sys_menu','flag=2 and sid in(9,10,11,12,13) and display_flag=1','seq')" id="vo">
      <li class=<if condition="$vo['title'] eq $modular">active</if>> <a href="/CRM/index.php/Home/{$vo.url}">{$vo.title}</a></li>
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
        <span class="input-group-addon">名称</span>
        <input type="text" value="{$keyword}" id="keyword" placeholder="输入查询关键字" class="form-control sbtn" col="1">
      </div>
      <select id='ssid' class='form-control sselect' col="1">
        <option value=''>权限所属模块</option>
        <volist name=":ShowList('sys_menu','sid=0','id')" id="ft">
          <option value='{$ft.title}'>{$ft.title}</option>
          <volist name=":ShowList('sys_menu','sid='.$ft['id'],'id')" id="sd">
            <option value='{$sd.title}'>┗━ {$sd.title}</option>
          </volist>
        </volist>
      </select>
    </div>
  </div>
  <table id="ListTbl" class="table table-striped table-bordered hover">
    <thead>
      <tr class="bg-info">
        <th>序号</th>
        <th>权限所属模块</th>
        <th>权限备注</th>
        <th width="700">权限子项</th>
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
        <td width="100">自定义权限名称</td>
        <td><select id='sid' name="sid" class='form-control'>
            <option value=''>权限所属模块</option>
            <volist name=":ShowList('sys_menu','sid=0','id')" id="ft">
              <option value='{$ft.id}'>{$ft.title}</option>
              <volist name=":ShowList('sys_menu','sid='.$ft['id'],'id')" id="sd">
                <option value='{$sd.id}'>┗━ {$sd.title}</option>
              </volist>
            </volist>
          </select></td>
      </tr>
      <tr>
        <td width="100">自定义权限备注</td>
        <td><input id="note" name="note" type="text" class="form-control" placeholder="填写权限备注"></td>
      </tr>
      <tr>
        <td>自定义权限子项</td>
        <td class=text-red><textarea id="qx" name="qx" class="form-control" rows="8"></textarea><br>填写权限子项,多个子项用 @ 标签隔开</td>
      </tr>
    </table>
  </form>
  <script>
  $(function () {
    /*基础设置*/
    resetFrom();
    $("#addForm").hide();
    $("#addFun").click(function(){
      _save("create");
    });
    $("#editFun").click(function(){
      _save("edit");
    });
    $("#delFun").click(function(){
      _singledel(table);
    });
    var table = $('#ListTbl').DataTable({
      stateSave: false,
      "sDom": '<"top">rt<"bottom"ip><"clear">',
      "createdRow": function ( row, data, index ) {
        $('td', row).eq(3).css("text-align","left"); //标题单元格居左对齐
      },
      columnDefs:[{
        orderable:false,//禁用排序
        targets:[0]   //指定的列
      }],
      aLengthMenu: [50],
      bProcessing:true,
      bLengthChange: true,
      paging:true,
      ordering: true,
      info:true,
      searching: true,
      "bAutoWidth":false,     //是否自动计算列宽
      scrollX: 1500,
      scrollY: 350,
      ajax: "?show=showDataTbale"
    });
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
                $("#sid").val(item.sid);
                $("#qx").val(item.qx);
                $("#note").val(item.note);
              });
            }
          });
        }
      }
      layer.open({
        skin: 'layui-layer-lan', //默认皮肤
        type: 1,
        title: "{$modular}", //标题
        area: ['600px', '450px'], //宽高
        shade: 0.8,//遮罩
        zIndex:1,
        content: $('#addForm'), //捕获的元素
        btn: ['保存', '关闭']
        ,yes: function(index, layero){
          var param = $("#addForm").serialize();
          $.ajax({
            url: "?act="+act+"&czid="+czid,
            data: param,
            dataType: 'json',
            type: 'POST',
            success: function (res) {
              if(res.code==1){
                resetFrom();
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