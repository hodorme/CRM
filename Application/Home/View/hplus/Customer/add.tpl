<extend name="Public/base" />
<block name="main">
  <!--会展客户操作界面-->
  <script src='__JS__/bootstrap-multiselect.js'></script>
  <div class="footerbtn">
    <button class="btn btn-success" id="saveFun"><i class="fa fa-save"></i> Save</button>
    <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i> Refresh</button>
    <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
  </div>
  <form method='post' id="addForm" action=''>
    <input type=hidden id="czid" value="{$czid}" checked>
    <input type=hidden id="hangye" value="{$hangye}" checked>
    <table class='table table-striped'>
      <tr>
        <td align="right"><strong><font color="red" style="font-size:18px;">*</font>Company Name</strong></td>
        <td colspan="3">
            <input id="title" name="title" type="text" class="layui-input" style="width: 638px;"/>
        </td>
      </tr>
      <tr>
        <td align="right"><strong><font color="red" style="font-size:18px;">*</font>Industry</strong></td>
        <td colspan="3">
          <div class=" layui-form layui-input-inline pull-left">
          <select name="industry" id="industry"  lay-filter="industry">
            <option value=''>Input search</option>
            <volist name=":ShowList('class','parid=1626','id')" id="vo">
            <option value='{$vo.id}' <if condition="!$czid"><if condition="$vo['id'] eq $hangye">selected</if></if>>{$vo.classname}</option>
            </volist>
          </select>
          </div>
          <div class="pro1627 pull-left">
            <select name="product" id="product" multiple="multiple">
              <volist name=":ShowList('class','parid =1627','id')" id="vo">
                <option value='{$vo.id}'>{$vo.classname}</option>
              </volist>
            </select>
          </div>
          <div class="pro1628 pull-left">
            <select name="product" id="product1" multiple="multiple">
              <volist name=":ShowList('class','parid =1628','id')" id="vo">
                <option value='{$vo.id}'>{$vo.classname}</option>
              </volist>
            </select>
          </div>
        </td>
      </tr>
      <tr>
        <td align="right"><strong><font color="red" style="font-size:18px;">*</font>Country</strong></td>
        <td  class="layui-form">
          <div class="layui-input-inline">
            <select id='s2' name='s2' lay-filter="s2" lay-search>
              <option value=''>Input search</option>
              <volist name=":ShowList('class','parid in(1620,1621,1622,1723,1724)','id')" id="vo">
                <option value='{$vo.id}'>{:strtolower($vo['classname'])}</option>
              </volist>
            </select>
          </div>
        </td>
        <td align="right" valign="top"><strong>Zip Code</strong></td>
        <td valign="top"><input type="text" id="ame" name="ame" class="layui-input" style="width: 170px;"/></td>
      </tr>
      <tr>
        <td align="right"><strong>Web</strong></td>
        <td>
          <input id="website" name="website" type="text" class="layui-input" style="width: 170px;"/>
        </td>
        <td align="right"><strong>Brand</strong></td>
        <td><input id="brand" name="brand" type="text" class="layui-input"  style="width: 170px;"/></td>
      </tr>
      <!--<tr>
        <td align="right"><b><font color="red" style="font-size:18px;">*</font>Language</b></td>
        <td class="layui-form" colspan="3">
            <volist name=":ShowList('class','parid=1649','id')" id="vo">
              <input type="radio" name="language" value="{$vo.id}" title="{$vo.classname}" <if condition="$czid"><if condition="$vo['id'] eq $edit['language']">checked</if></if> >
            </volist>
        </td>
      </tr>-->
      <tr>
        <td align="right"><strong>Business Nature</strong></td>
        <td class="layui-form">
          <div class="layui-input-inline">
          <select id='business' name='business' lay-filter="business">
            <option value='0'>Please select</option>
            <volist name=":ShowList('class','parid=1638','id')" id="vo">
              <option value='{$vo.id}'>{$vo.classname}</option>
            </volist>
          </select>
          </div>
        </td>
        <td align="right"><strong>Type</strong></td>
        <td class="layui-form">
          <div class="layui-input-inline">
          <select id='type' name='type' lay-filter="type" lay-search>
            <option value='0'>Please select</option>
            <volist name=":ShowList('class','parid=1642','id')" id="vo">
              <option value='{$vo.id}'>{$vo.classname}</option>
            </volist>
          </select>
          </div>
        </td>
      </tr>
      <tr>
        <td align="right"><strong>Data Source</strong></td>
        <td class="layui-form">
          <div class="layui-input-inline">
          <select id='source' name='source' lay-filter="source" lay-search>
            <option value='0'>Please select</option>
            <volist name=":ShowList('class','parid=1646','id')" id="vo">
              <option value='{$vo.id}'>{$vo.classname}</option>
            </volist>
          </select>
          </div>
        </td>
        <td align="right"><strong>Detailed Source Information</strong></td>
        <td>
          <input id="sourcedetails" name="sourcedetails" type="text" class="layui-input"  style="width: 170px;"/>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top"><strong>Detailed Address</strong></td>
        <td valign="top" colspan="3">
          <textarea id="address" name="address" rows="5" class="layui-textarea" style="width: 638px;"></textarea>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top"><strong>Company Background</strong></td>
        <td colspan="3" valign="top"><textarea id="memo" name="memo" rows="5" class="layui-textarea" style="width: 638px;"></textarea></td>
      </tr>
    </table>
    <if condition="$czid">
      <input type="hidden" name="updatedtime" id="updatedtime">
      <else/>
      <input type="hidden" name="posttime" id="posttime">
    </if>
  </form>
  <br>
  <script>
    var czid=$("#czid").val();
    if(!czid){
      var hangye=$("#hangye").val();
      if(hangye==1627){
        $(".pro1627").show();
        $(".pro1628").hide();
      }else if(hangye==1628){
        $(".pro1627").show();
        $(".pro1628").hide();
      }else{
        $(".pro1627").hide();
        $(".pro1628").hide();
      }
      layui.use('form', function() {
        var form = layui.form();
        form.on('select(industry)', function(data){
          var value = data.value;
          if(value== 1627){
            $(".pro1627").show();
            $(".pro1628").hide();
          }else if(value== 1628){
            $(".pro1628").show();
            $(".pro1627").hide();
          }else{
            $(".pro1627").hide();
            $(".pro1628").hide();
          }
        });
      });
    }
    $('#product').multiselect();
    $('#product1').multiselect();
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
      $("#posttime").val($timeStr) ;
      $("#updatedtime").val($timeStr) ;
    });
      /*重置表单*/
      resetFrom();
      var act="create";
      if(!czid){
        $("#title").blur(function(){
          var title = $("#title");
          if (title.val() == "") {
            layer.msg('Customer name cannot be empty');
            console.log(error);
          }
          var vtitle = $.trim($("#title").val());
          var url = '{:U('/Home/Customer/add?show=gysName')}';
          $.get(url,{vtitle:vtitle},function(data){
            if (data) {
              layer.msg('Customer already exists!');
              console.log(error);
            }
          });
        });
      }
      if(czid){
        //获取编辑数据
        $.ajax({
          url: "?show=edit&czid="+czid,
          type: "post",
          success: function (json) {
            $.each(json, function (i, item) {
              $("#title").val(item.title);
              layui.use('form', function(){
                var form = layui.form();
                if(item.s2){
                  $("#s2").val(item.s2);
                  form.render();
                }
                if(item.business){
                  $("#business").val(item.business);
                  form.render();
                }
                if(item.type){
                  $("#type").val(item.type);
                  form.render();
                }
                if(item.source){
                  $("#source").val(item.source);
                  form.render();
                }
                if(item.industry==1627){
                  if(item.product){
                    $('#product').val(item.product.split(","));
                    $(".pro1628").hide();
                    form.render();
                  }
                }else if(item.industry==1628){
                  if(item.product){
                    $('#product1').val(item.product.split(","));
                    $(".pro1627").hide();
                    form.render();
                  }
                }else{
                  $(".pro1627").hide();
                  $(".pro1628").hide();
                }
                if(item.industry){
                  $('#industry').val(item.industry);
                  form.render();
                }
              });
              $("#brand").val(item.brand);
              $("#memo").text(item.memo);
              $("#ame").val(item.ame);
              $("#website").val(item.website);
              $("#sourcedetails").val(item.sourcedetails);
              $("#address").text(item.address);
            });
            $('#product').multiselect("refresh");
          }
        });
        var act="edit";
      }
      $("#saveFun").click(function(){
        _save(act);
      });
      /*响应添加 修改*/
      function _save(act) {
        var czid=$("#czid").val();
        //var param = $("#addForm").serialize();
        var param = {
          'title': $("#title").val(),
          's2': $("#s2").val(),
          'website': $("#website").val(),
          'brand': $("#brand").val(),
          'business': $("#business").val(),
          'industry': $("#industry").val(),
          'type': $("#type").val(),
          'source': $("#source").val(),
          'sourcedetails': $("#sourcedetails").val(),
          'address': $("#address").val(),
          'ame': $("#ame").val(),
          'memo': $("#memo").val(),
          'product': ""+$("#product").val()+"",
          'posttime': $("#posttime").val(),
          'updatedtime': $("#updatedtime").val()
        };
        var title = $("#title");
        if (title.val() == "") {
          layer.msg('Customer name cannot be empty');
          console.log(error);
        }
        var s2 = $("#s2");
        if (s2.val() == "") {
          layer.msg('No country selected');
          console.log(error);
        }
        var industry = $("#industry");
        if (industry.val() == "") {
          layer.msg('No choice  industry');
          console.log(error);
        }
        if(!czid){
          var vtitle = $.trim($("#title").val());
          var url = '{:U('/Home/Customer/add?show=gysName')}';
          $.get(url,{vtitle:vtitle},function(data){
            if (data) {
              layer.msg('Customer already exists!');
              console.log(error);
            }
          });
        }
        //表单验证
        if(!_inputcheck()){
          return false;
        }
        var cfname='';
        if(czid) {
          var ztitle = $.trim($("#ztitle").val());
          var jtitle = $.trim($("#title").val());
          if (ztitle != jtitle) {
            cfname = jtitle;
          }
        }
        if(act == 'create'){
          var newTab=window.open('about:blank');
        }
        $.ajax({
          url: "?act="+act+"&czid="+czid+"&cfname="+cfname+"&table={$table}",
          data: param,
          dataType: 'json',
          type: 'POST',
          success: function (res) {
            if(res.code==1){
              var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
              parent.layer.msg(res.msg, {icon: res.code});
              if(res.table == 'table'){
                window.parent.DatablesReload("table");
                if(res.cid){
                  newTab.location="{:U('Home/Customer/view')}?czid="+res.cid;
                }
              }else{
                parent.location.reload();
              }
              //parent.zhanguan.ajax.reload(null,false);
              parent.layer.close(index);
            }else if(res.code==3){
              layer.tips('Customer already exists!', '#title', {
                tips: 3
              });
              console.log(error);
            } else {
              layer.msg(res.msg, {icon: res.code});
            }
          }, error: function (error) {
            layer.msg('Request error', {icon: 2});
            console.log(error);
          }
        });
      }
  </script>
</block>
