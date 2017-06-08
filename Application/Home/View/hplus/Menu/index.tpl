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
                <span class="input-group-addon">功能名称</span>
                <input type="text" id="keyword" placeholder="输入查询关键字" class="form-control sbtn" col="1">
            </div>
        </div>
        <select id='ssid' class='form-control sselect' col="4">
        <option value=''>父级功能</option>
            <volist name=":ShowList('sys_menu','sid=0','id')" id="ft">
            <option value='{$ft.title}'>{$ft.title}</option>
            <volist name=":ShowList('sys_menu','sid='.$ft['id'],'id')" id="sd">
                <option value='{$sd.title}'>┗━ {$sd.title}</option>
            </volist>
        </volist>
        </select>
        <select id="sflag" class='form-control sselect' col="5">
            <option value=''>功能定义</option>
            <foreach name="flagset" item="v" key="k">
                <option value="{$v}">{$v}</option>
            </foreach>
        </select>
    </div>
        <table id="ListTbl" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
          <th>排序</th>
          <th>功能名称</th>
          <th>图标</th>
          <th>URL</th>
            <th>父级功能</th>
            <th>功能定义</th>
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
          <td width="100">功能名称</td>
          <td><input id="title" name="title" type="text" class="form-control" placeholder="填写栏目功能名称"></td>
        </tr>
          <tr>
              <td>功能URL</td>
              <td><input id="url" name="url" type="text" class="form-control" placeholder="填写模块URL，必须是英文"></td>
          </tr>
        <tr>
          <td>功能图标</td>
          <td><input id="icon" name="icon" type="text" class="form-control" placeholder="填写栏目图标代码"></td>
        </tr>
        <tr>
          <td>功能图片</td>
            <td class="form-inline" colspan="3"><div class="input-group">
                    <input name="tu" type="text" id="tu" value="" size="100" class="form-control" />
        <span class="input-group-addon">
        <input type="button" iid="tu" value="更新图片" class="btn_search upimg" />
        </span> </div></td>
        </tr>
        <tr>
          <td>排序</td>
          <td class="form-inline"><input id="seq" name="seq" type="text" class="form-control" placeholder="填写显示排序">
              <label><input type="checkbox" name="display_flag" id="display_flag" value="1">启用</label></td>
          </tr>
        <tr>
          <td>父级功能</td>
          <td class="form-inline"><select name='sid' id='sid' class="form-control">
            <option value='0'>父级</option>
                  <volist name=":ShowList('sys_menu','sid=0','id')" id="ft">
                      <option value='{$ft.id}'>{$ft.title}</option>
                      <volist name=":ShowList('sys_menu','sid='.$ft['id'],'id')" id="sd">
                          <option value='{$sd.id}'>┗ {$sd.title}</option>
						  <volist name=":ShowList('sys_menu','sid='.$sd['id'],'id')" id="td">
                          <option value='{$td.id}'>&nbsp;&nbsp;┗ {$td.title}</option>
                      </volist>
                      </volist>
                  </volist>
          </select>
          <select id="flag" name="flag" class="form-control">
              <foreach name="flagset" item="v" key="k">
                  <eq name="k" value="$flag">
                      <option value="{$k}" selected>{$v}</option>
                      <else/>
                      <option value="{$k}">{$v}</option>
                  </eq>
              </foreach>
          </select></td>
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
            bProcessing:true,
            bLengthChange: true,
            paging:true,
            ordering: true,
            info:true,
            searching: true,
            ajax: "?show=showDataTbale"
        });
        _customSearch(table);
        /*单击选择 */
        $('#ListTbl').on('click','tbody tr',function () {
            var czid=$(this).find("td:last").text();
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
                                $("#title").val(item.title);
                                $("#sid").val(item.sid);
                                $("#icon").val(item.icon);
                                $("#url").val(item.url);
                                $("#seq").val(item.seq);
                                $("#flag").val(item.flag);
                                if(item.display_flag == 1){
                                    $("#display_flag").prop("checked",true);
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
                area: ['600px', '410px'], //宽高
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
    });
    </script>
</block>
