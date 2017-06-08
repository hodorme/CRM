<extend name="Public/base" />
<block name="main">
  <div class="footerbtn">
    <button id="saveFun" class="btn btn-success"><i class="fa fa-save"></i>Save</button>
    <button type="button" id="refreshBtn" class="btn btn-info"><i class="fa fa-refresh"></i> Close</button>
  </div>
  <form action='' id="addForm">
    <input type=hidden id="czid" value="{$Think.session.uid}" checked>
    <form action='' method='post' id="addForm" class="layui-form">
      <div class="col-md-4">
        <div class="site-demo-upload">
          <img id="tu_img" src="/Img/none.jpg" width="100%" height="300">
          <input name="portrait" type="hidden" id="portrait" class="form-control" />
          <div class="site-demo-upbar">
            <input type="file" name="photo" id="photo" class="layui-upload-file">
          </div>
        </div>
      </div>
      <div class="col-md-8">
    <table class='table table-striped'>
      <tr>
        <td width="100">Job No.</td>
        <td><input id="usercode" name="usercode" type="text" class="form-control" disabled></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><input id="password" name="password" type="text" class="form-control"></td>
      </tr>
      <tr>
        <td>Name</td>
        <td><input id="username" name="username" type="text" class="form-control" placeholder="Please fill in the name"></td>
      </tr>
      <tr>
        <td>Mobile Phone</td>
        <td><input id="u_mob" name="u_mob" type="text" class="form-control" placeholder="please fill in cell phone number"></td>
      </tr>
      <tr>
        <td>Mailbox</td>
        <td><input id="u_cmail" name="u_cmail" type="text" class="form-control" placeholder=""></td>
      </tr>
    </table>
    </div>
  </form>
    <script>
      layui.use('upload', function(){
        layui.upload({
          title:'Upload Photos'
          ,url: '/CRM/index.php/Home/LayUpload'
          ,elem: '#photo'
          ,method: 'post'
          ,success: function(res){
            if(res.code==1){ //返回成功
              $("#tu_img").val(""+res.url);
              $("#portrait").val(res.url);
              tu_img.src = res.url;
            }
            layer.msg(res.msg, {icon: res.code});
          }
        });
      });
      $.ajax({
        url: "?show=read",
        type: "post",
        success: function (json) {
            $("#usercode").val(json.usercode);
            $("#username").val(json.username);
            $("#password").val(json.password);
            $("#u_mob").val(json.u_mob);
            $("#u_cmail").val(json.u_cmail);
            $("#portrait").attr("value","/crm"+json.portrait+"");
            $("#tu_img").attr("src","/crm"+json.portrait+"");
        }
      });
      $("#saveFun").click(function(){
        _save("edit");
      });
      /*响应添加 修改*/
      function _save(act) {
        var czid = $("#czid").val();
        var param = $("#addForm").serialize();
        $.ajax({
          url: "?act=edit&czid="+czid,
          data: param,
          dataType: 'json',
          type: 'POST',
          success: function (res) {
            if(res.code==1){
              layer.msg(res.msg, {icon: res.code});
            } else {
              layer.msg(res.msg, {icon: res.code});
            }
          }, error: function (error) {
            layer.msg('请求错误', {icon: 2});
            console.log(error);
          }
        });
      };
	</script> 
</block>
