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
        <span class="input-group-addon">名称</span>
        <input type="text" value="{$keyword}" id="keyword" placeholder="输入查询关键字" class="form-control sbtn" col="1">
      </div>
    </div>
  </div>
  <table id="ListTbl" class="table table-striped table-bordered hover">
    <thead class="bg-info">
      <tr>
        <th>序号</th>
        <th>角色名称</th>
        <th>角色备注</th>
        <th width="400">权限</th>
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
        <td width="150">角色名称</td>
        <td><input id="name" name="name" type="text" class="form-control" placeholder="填写角色名称"></td>
        <td>角色备注</td>
        <td><input id="note" name="note" type="text" class="form-control" placeholder="角色备注"></td>
        <td>显示排序</td>
        <td><input id="seq" name="seq" type="text" class="form-control" placeholder="填写显示排序"></td>
      </tr>
      <volist name=":ShowList('sys_menu','sid=0','seq')" id="ft">
      <tr>
        <td><label><input value='{$ft.id}' id="qx{$ft.id}" name="qx[]" class="ft{$ft.id}" type="checkbox"> {$ft.title}</label></td>
        <td colspan="5">
          <volist name=":ShowList('sys_menu','sid='.$ft['id'],'seq')" id="sd">
            <table>
              <td><label><input value='{$sd.id}' id="qx{$sd.id}" name="qx[]" fid="{$ft.id}" class="sd{$ft.id}" type="checkbox"> {$sd.title}</label>
              </td>
              <td style="text-align: left; padding-left: 20px;">
                <volist name=":ShowList('sys_menu','sid='.$sd['id'],'seq')" id="td">
                  <label><input value='{$td.id}' id="qx{$td.id}" name="qx[]" fid="{$ft.id}" class="td{$ft.id}" type="checkbox"> {$td.title}</label>
          </volist>
                <volist name=":ShowList('Quanxian','sid='.$sd['id'],'id')" id="td">
                  <label><input value='{$td.id}' id="czqx{$td.id}" name="czqx[]" fid="{$ft.id}" class="td{$ft.id}" type="checkbox"> {$td.qx}</label>
                </volist>
              </td>
              </table>
          </volist>
      </td>
      </tr>
      </volist>
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
                var arr="";
                if(item.qx){
                  var arr = item.qx.split(',');
                  $("input[name='qx[]']").each(function(){
                    var aaa=$(this).val();
                    if(arr.indexOf(aaa)!=-1){
                      $("#qx"+aaa+"").prop("checked",true);
                    }else{
                      $("#qx"+aaa+"").prop("checked",false);
                    }
                  })
                }else{
                  $("input[name='qx[]']").prop("checked",false);
                }
              });
            }
          });
        }
      }
      layer.open({
        skin: 'layui-layer-lan', //默认皮肤
        type: 1,
        title: "{$modular}", //标题
        area: ['900px', '480px'], //宽高
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
    //input 子父层联动
    $("input[class*='ft']").click(function(){
      var fid=$(this).val();
      if($(this).is(':checked')){
        $(".sd"+fid).attr("checked",true);
        $(".td"+fid).attr("checked",true);
      }else{
        $(".sd"+fid).removeAttr("checked");
        $(".td"+fid).removeAttr("checked");
        //$(".sd"+fid).attr("checked",false);
        //$(".td"+fid).attr("checked",false);
      }
    });
  });
  </script>
</block>
