<extend name="Public/base" />
<block name="main">
  <div class="footerbtn">
    <button type="button" class="btn btn-info refreshBtn"><i class="fa fa-refresh"></i> 刷新</button>
    <button type="button" class="btn btn-danger closeBtn"><i class="fa fa-close"></i> 关闭</button>
  </div>
      <div class="col-md-4">
          <img src="{$view.filename1|default="/Img/none.jpg"}" style="margin: auto; max-width: 100%;">
      </div>
      <div class="col-md-8">
    <table class='table table-striped'>
      <tr>
        <td width="100">工号</td>
        <td>{$view.usercode}</td>
        <td width="100">姓名</td>
        <td>{$view.username}</td>
      </tr>
      <tr>
        <td>手机号码</td>
        <td>{$view.u_mob}</td>
        <td>公司座机</td>
        <td>{$view.u_ctel}-{$view.u_cfenji}</td>
      </tr>
      <tr>
        <td>个人邮箱</td>
        <td>{$view.u_cmail}</td>
        <td> 私人QQ</td>
        <td>{$view.u_pqq}</td>
      </tr>
      <tr>
        <td>现居住地址</td>
        <td colspan="3">{$view.u_address}</td>
      </tr>
      <tr>
        <td>名字拼音</td>
        <td>{$view.xing}{$view.ming}</td>
        <td>英文名</td>
        <td></td>
      </tr>
      <tr>
        <td>护照类型</td>
        <td>{$view.hz_type}</td>
        <td>护照号码</td>
        <td>{$view.hz_no}</td>
      </tr>
      <tr>
        <td>出生日期</td>
        <td>{$view.u_birthday}</td>
        <td>出生地点</td>
        <td>{$view.hz_csd}</td>
      </tr>
      <tr>
        <td>签发地点</td>
        <td>{$view.hz_qfd}</td>
        <td>签发时间</td>
        <td>{$view.hz_qfdate}</td>
      </tr>
      <tr>
        <td>护照有效期</td>
        <td>{$view.hz_date}</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>护照扫描件</td>
        <td colspan="3"><img src="{$view.huzhao|default="/Img/none.jpg"}" style="margin: auto; max-width: 100%;"></td>
      </tr>
    </table>
    </div>
    <script>
	</script> 
</block>
