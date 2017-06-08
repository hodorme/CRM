<extend name="Public/base" />
<block name="main">
  <input type=text id="czid" checked>
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
        <span class="input-group-addon">名字</span>
        <input type="text" id="keyword" placeholder="输入查询关键字" class="form-control sbtn" col="1">
      </div>
      <select id='ssid' class='form-control sselect' col="4">
        <option value=''>所属部门</option>
        <volist name=":ShowList('Bumen','parid=0','id')" id="ft">
          <option value='{$ft.classname}'>{$ft.classname}</option>
          <volist name=":ShowList('Bumen','parid='.$ft['id'],'id')" id="sd">
            <option value='{$sd.classname}'>┗━ {$sd.classname}</option>
          </volist>
        </volist>
      </select>
    </div>
    <div class="form-group">
      <select id='sjuese' class='form-control sselect' col="5">
        <option value=''>全部角色</option>
        <volist name=":ShowList('Zhiwei','','id')" id="vo">
          <option value='{$vo.classname}'>{$vo.classname}</option>
        </volist>
      </select>
    </div>
  </div>
  <div class="tab-content">
    <table id="ListTbl" class="table table-striped table-bordered hover">
      <thead>
      <tr class="bg-info">
        <th>序</th>
        <th>工号</th>
        <th>名字</th>
        <th>所在部门</th>
        <th>所属岗位</th>
        <th>更新时间</th>
        <th>ID</th>
      </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  <!--客户修改编辑界面-->
  <form action='' method='post' id="addForm">
    <table class='table table-striped'>
      <tr>
        <td width="100">*工号</td>
        <td><input id="usercode" name="usercode" type="text" class="form-control required" placeholder="填写工号"></td>
      </tr>
      <tr>
        <td>密码</td>
        <td><input type="password" class="form-control" id="password" name="password" placeholder="填写密码"></td>
      </tr>
      <tr>
        <td>姓名</td>
        <td><input id="username" name="username" type="text" class="form-control" placeholder="填写名字"></td>
      </tr>
      <tr>
        <td>部门</td>
        <td>
            <select id='bmid' name="bmid" class='form-control'>
              <option value=''>所属部门</option>
              <volist name=":ShowList('bumen','','sequence')" id="vo">
                <option value='{$vo.id}'>{$vo.classname}</option>
              </volist>
            </select>
        </td>
      </tr>
      <tr>
        <td>岗位</td>
        <td>
          <select id='zwid' name="zwid" class='form-control'>
            <option value=''>职位角色</option>
            <volist name=":ShowList('bumen_zw','','sequence')" id="vo">
              <option value='{$vo.id}'>{$vo.classname}</option>
            </volist>
          </select>
        </td>
      </tr>
      <tr>
        <td>照片</td>
        <td>
          <div class="pull-left">
            <input type="text" id="portrait" name="portrait" class="form-control" size="60">
          </div>
          <div class="pull-left">
            <input type="file" name="photo" id="photo" class="layui-upload-file">
          </div>
        </td>
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
        layui.use('upload', function(){
          layui.upload({
            url: '{:U('Home/LayUpload/index')}'
            ,elem: '#photo'
            ,method: 'post'
            ,title: '上传照片'
            ,success: function(res){
              if(res.code==1){ //返回成功
                $("#portrait").val(res.url);
              }
              layer.msg(res.msg, {icon: res.code});
            }
          });
        });
      /*初始化表格*/
      var table = $('#ListTbl').DataTable({
        stateSave: false,
        "sDom": '<"top">rt<"bottom"ip><"clear">',
        bProcessing:true,
        createdRow: function( row, data, dataIndex ) {
        },
        bLengthChange: true,
        paging:true,
        ordering: true,
        info:true,
        searching: true,
        autoWidth: false,
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
        $("#password").attr('disabled',false);
        if(act=="edit"){
          if(!czid) {
            layer.msg('请选择要编辑的行', function(){});
            return false;
          }else {
            //获取编辑数据
            $.ajax({
              url: "?show=read&czid="+czid,
              type: "post",
              success: function (json) {
                $("#usercode").val(json.usercode);
                $("#password").val(json.password);
                $("#username").val(json.username);
                $("#bmid").val(json.bmid);
                $("#zwid").val(json.zwid);
                $("#portrait").val(json.portrait);
                $("#status").val(json.status);
                $("#password").attr('disabled',true);
                var roleid="";
                if(json.roleid){
                  var roleid = json.roleid.split(',');
                  $("input[name='roleid[]']").each(function(){
                    var aaa=$(this).val();
                    if(roleid.indexOf(aaa)!=-1){
                      $("#roleid"+aaa).prop("checked",true);
                    }else{
                      $("#roleid"+aaa).prop("checked",false);
                    }
                  })
                }else{
                  $("input[name='roleid[]']").prop("checked",false);
                }
              }
            });
          }
        }
        layer.open({
          skin: 'layui-layer-lan', //默认皮肤
          type: 1,
          title: "用户信息", //标题
          area: ['800px', '450px'], //宽高
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
