<extend name="Public/base" />
<block name="main">
    <input type=hidden id="czid" checked>
    <div class="form-inline pull-right">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="管理按钮">
            <php>if(strpos(getUserCzqx(),"项目编辑")>-1){</php>
                <button class="btn btn-primary editFun"><i class="fa fa-edit"></i> Edit Item</button>
            <php>}</php>
            <button class="btn btn-info refreshBtn"><i class="fa fa-refresh"></i> </button>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="active"><a href="">{$modular}</a></li>
    </ul>
  <table class="table table-striped table-bordered hover">
  <tr>
      <td align="right"><strong>Project</strong></td>
      <td colspan="3">{$view.title}</td>
  </tr>
  <tr>
      <td width="205" align="right"><strong>Location</strong></td>
      <td>{$view.s1}-{$view.s2}</td>
      <td width="150" align="right"><strong>Month In</strong></td>
      <td>{$view.pmonth}(The project will be held in the general month)</td>
  </tr>
  <tr>
      <td align="right"><strong>First Time</strong></td>
      <td>{$view.sjtime}</td>
      <td align="right"><strong>Holding Cycle</strong></td>
      <td>{$view.zhouqi}</td>
  </tr>
  <tr>
      <td align="right"><strong>Industry</strong></td>
      <td>{$view.hangye}</td>
      <td align="right"><strong>Project Manager</strong></td>
      <td>{$view.admin}</td>
  </tr>
  <tr>
      <td align="right"><strong>Project Description</strong></td>
      <td colspan="3">{$view.content}</td>
  </tr>
</table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
            <php>if(strpos(getUserCzqx(),"添加展会")>-1){</php>
                <button class="btn btn-sm btn-success addExpoFun">Add Exhibition</button>
            <php>}</php>
            <php>if(strpos(getUserCzqx(),"展会删除")>-1){</php>
                <button id="delFun" class="btn btn-sm btn-warning"> Delete</button>
            <php>}</php>
        </div><b>Current Project Exhibition</b>
    </div>
<table id="ListTbl" class="table table-striped table-bordered hover">
    <thead>
    <tr class="bg-info">
        <th width="5%">No.</th>
        <th width="2%"><input class=SelectAllId type=checkbox sname="expoid[]"></th>
        <th width="32%">Expo</th>
        <th width="12%">Industry</th>
        <th width="8%">Starttime</th>
        <th width="8%">Endtime</th>
        <th width="10%">Target Area</th>
        <th width="10%">Actual Area</th>
        <th width="6%">Operation</th>
        <th width="5%">ID</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
<script>
    /*重置表单*/
    resetFrom();
    $("#delFun").click(function(){
        var czid = '';
        $("input[name='expoid[]']:checked").each(function (i, n) {
            if (i == 0) {
                douhao = "";
            } else {
                douhao = ",";
            }
            czid += douhao + $(n).val();
        });
        layer.confirm('Confirm delete?', {
            btn: ['Yes','No'] //按钮
        }, function() {
            $.ajax({
                url: "?act=del&delid=" + czid,
                type: "post",
                success: function (res) {
                    if (res.code == 1) {
                        resetFrom();
                        layer.msg('Delete success', {icon: res.code});
                        table.ajax.reload(null, false);
                    } else {
                        layer.msg(res.msg, {icon: res.code});
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
        });
    });
    $(".addExpoFun").click(function(){
        var title = "Add Exhibition";
        var url ="{:U('Expo/add',array('czid'=>$czid))}";
        _layerOpen(url, title, '65%', '80%');
    });
    $(".editFun").click(function(){
        var title = "Edit Item";
        var url ="{:U('Project/edit',array('czid'=>$czid))}";
        _layerOpen(url, title, '65%', '80%');
    });
	 /*初始化表格*/
    var table = $('#ListTbl').DataTable({
        stateSave: false,
		columnDefs:[{
                orderable:false,//禁用排序
                targets:[0,1]   //指定的列
            }],
        "order": [[2, 'desc']],
        aLengthMenu: [50],
        "sDom": '<"top">rt<"bottom"ip><"clear">',
        bProcessing:false,
        bLengthChange: false,
        // bInfo:true,
        //bAutoWidth: true,
        paging:false,
        ordering: true,
        info:false,
        searching: false,
        autoWidth: false,
        ajax: "?show=showExpo&czid={$czid}"
    });
    /*调用自定义 */
    _customSearch(table);
    /*单击选择 */
    $('#ListTbl').on('click','tbody tr',function () {
        var czid=$(this).find("td:last").text();
        if($(this).find("td").html()!='暂无数据'){
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $(this).find(":checkbox:last").prop("checked",false);
            }else{
                $(this).addClass('selected');
                $(this).find(":checkbox:last").prop("checked",true);
            }
        }
    });
    $(document).on("click", ".edit", function () {
        var title = "Modify Exhibition Information";
        var czid=$(this).attr('czid');
        var url ="{:U('Expo/edit')}?czid="+czid;
        _layerOpen(url, title, '80%', '90%');
    });
</script>
</block>
