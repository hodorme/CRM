<extend name="Public/base" />
<block name="main">
  <input type=hidden id="czid" checked>
  <input type=hidden id="djid" checked>
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
        <input type="text" value="{$keyword}" id="keyword" placeholder="输入查询关键字" class="form-control sbtn" col="2">
      </div>
      <select id='ssid' class='form-control sselect' col="1">
        <option value=''>所属部门</option>
        <volist name=":ShowList('Bumen','parid=0','id')" id="ft">
          <option value='{$ft.classname}'>{$ft.classname}</option>
          <volist name=":ShowList('Bumen','parid='.$ft['id'],'id')" id="sd">
            <option value='{$sd.classname}'>┗━ {$sd.classname}</option>
          </volist>
        </volist>
      </select>
    </div>
  </div>
  <table id="ListTbl" class="table table-striped table-bordered hover">
    <thead class="bg-info">
      <tr>
        <th>序号</th>
        <th>部门名称(子部门数)</th>
        <th>类别备注</th>
        <th>上移</th>
        <th>下移</th>
        <th>操作</th>
        <th>ID</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  <script>
    /*基础设置*/
    resetFrom();
    $("#djid").val('');
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
      "bAutoWidth":false,     //是否自动计算列宽
      ajax: "?show=showDataTbale"
    });
    /*调用自定义 */
    _customSearch(table);
    $(document).on("click",".zfl",function(){
      if($.fn.DataTable.isDataTable('#ListTbl')){
        $('#ListTbl').DataTable().destroy();
      }
      var bmid=$(this).attr("id");
      var parid=$(this).attr("parid");
      $("#djid").val(bmid);
      var table = $('#ListTbl').DataTable({
        stateSave: false,
        "sDom": '<"top">rt<"bottom"ip><"clear">',
        bProcessing:true,
        bLengthChange: true,
        paging:true,
        ordering: true,
        info:true,
        searching: true,
        "bAutoWidth":false,     //是否自动计算列宽
        ajax: "?show=showDataTbale&bmid="+bmid+"&parid="+parid
      });
      /*调用自定义 */
      _customSearch(table);
    });
    /*单击选择 */
    $('#ListTbl').on('click','tbody tr',function () {
      var czid=$(this).find("td:last").text();
      if($(this).hasClass('selected')) {
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
      if(act=='edit'){
        var czid = $("#czid").val();
        var canshu="czid="+czid;
        var title='编辑部门';
        if(!czid){
          layer.msg('未选中操作ID', {icon: 2});
          console.log(error);
        }
      }else{
        var title='添加部门';
        var djid=$("#djid").val();
        var canshu="djid="+djid;
      }
      layer.open({
        skin: 'layui-layer-lan', //默认皮肤
        type:2,
        title:title, //标题
        area: ['50%', '70%'], //宽高
        shade: 0.8,//遮罩
        zIndex:1,
        content: "{:U('Home/Bumen/add')}?"+canshu
      });
    }
  </script>
</block>
