<extend name="Public/base" />
<block name="main">
  <input type=hidden id="czid" checked>
  <input type=hidden id="djid" checked>
  <div class="form-inline searchbar">
    <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
      <button class="btn btn-success" onClick ="$('#ListTbl').tableExport({type:'excel',escape:'false'});"><i class="fa fa-download"></i> Data Export</button>
      <button type="button" class="btn btn-info" id="btnRefresh"><i class="fa fa-refresh"></i> Refresh</button>
    </div>
    <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
    </div>
    <div class="form-group">
      <div class="input-group">
        <span class="input-group-addon">Name</span>
        <input type="text" value="{$keyword}" id="keyword" placeholder=" Enter the key word" class="form-control">
      </div>
      <select id='ssid' class='form-control sselect'>
        <option value=''>Industry</option>
        <volist name=":ShowList('Bumen','parid=0','id')" id="ft">
          <option value='{$ft.id}'>{$ft.classname}</option>
          <volist name=":ShowList('Bumen','parid='.$ft['id'],'id')" id="sd">
            <option value='{$sd.id}'>┗━ {$sd.classname}</option>
          </volist>
        </volist>
      </select>
        <select id="userid" class='form-control sselect'>
          <option value=0>Account Manager</option>
          <volist name=":ShowList('users','','id')" id="oi">
            <option value="{$oi.id}">{$oi.username}</option>
          </volist>
        </select>
    </div>
    <button id="searchBtn" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Search</button>
  </div>
  <table id="ListTbl" class="table table-striped table-bordered hover">
    <thead class="bg-info">
      <tr>
        <th>No.</th>
        <th>Company Name</th>
        <th>Country</th>
        <th>Contact Name</th>
        <th>Email1</th>
        <th>Email2</th>
        <th>Language</th>
        <th>Posttime</th>
        <th>Updatetime</th>
        <th>Contact Record</th>
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
    $(document).on("click","#searchBtn",function(){
      if($.fn.DataTable.isDataTable('#ListTbl')){
        $('#ListTbl').DataTable().destroy();
      }
      var keyword= $.trim($("#keyword").val());
      var ssid= $.trim($("#ssid").val());
      var userid= $.trim($("#userid").val());
        var table = $('#ListTbl').DataTable({
          stateSave: false,
          "sDom": '<"top">rt<"bottom"ip><"clear">',
          bProcessing:true,
          bLengthChange: true,
          paging:false,
          ordering: true,
          info:true,
          searching: true,
          "bAutoWidth":false,     //是否自动计算列宽
          ajax: "?show=showDataTbale&keyword="+keyword+"&ssid="+ssid+"&userid="+userid
        });
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
  </script>
</block>
