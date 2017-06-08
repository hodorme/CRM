<extend name="Public/base" />
<block name="main">
    <!--展会操作界面-->
    <div class="footerbtn">
        <button class="btn btn-success" id="saveFun"><i class="fa fa-save"></i> 保存</button>
        <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i> 刷新</button>
        <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> 关闭</button>
    </div>
    <form method='post' id="addForm" action='' class="layui-form">
        <input type=hidden id="czid" value="{$czid}" checked>
        <input type=hidden id="cid" name="cid" value="{$cid}" checked>
        <table class='table table-striped'>
            <tr>
                <td width="15%" align="right"><strong>所属公司</strong></td>
                <td width="35%" >
                    <volist name=":ShowList('company','id='.$cid,'id')" id="vo">
                        {$vo.title}
                    </volist>
                    <span id="cname"></span>
                </td>
                <td width="15%"  align="right"><strong>联系电话</strong></td>
                <td width="35%" class="form-inline">
          <span class="input-group">
            <input id="telarea" name="telarea" type="text" class="form-control" size="5"/>
          </span>
          <span class="input-group">
            -
          </span>
          <span class="input-group">
            <input id="tel" name="tel" type="text" class="form-control" />
          </span>
          <span class="input-group">
            -
          </span>
          <span class="input-group">
            <input id="fenji" name="fenji" type="text" class="form-control"  size="5"/>
          </span>

                </td>
            </tr>
            <tr>
                <td align="right"><strong>会员账号</strong></td>
                <td>
                    <input id="username" name="username" type="text" class="form-control" />
                </td>
                <td align="right"><b>传真号码</b></td>
                <td class="form-inline">
          <span class="input-group">
             <input id="faxarea" name="faxarea" type="text" class="form-control" size="5"/>
          </span>
          <span class="input-group">
            -
          </span>
          <span class="input-group">
             <input id="fax" name="fax" type="text" class="form-control" />
          </span>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>会员密码</strong></td>
                <td><input id="password" name="password" type="text" class="form-control" /></td>
                <td align="right"><strong>手机号码</strong></td>
                <td><input id="mobile"  name="mobile" type="text" class="form-control" /></td>
            </tr>
            <tr>
                <td align="right"><strong>姓名</strong></td>
                <td><input id="fullname" name="fullname" type="text" class="form-control" /></td>
                <td align="right"><strong>邮箱</strong></td>
                <td><input id="email"  name="email" type="text" class="form-control" /></td>
            </tr>
            <tr>
                <td align="right"><strong>部门</strong></td>
                <td><input id="bumen" name="bumen" type="text" class="form-control" /></td>
                <td align="right"><strong>QQ</strong></td>
                <td><input id="qq"  name="qq" type="text" class="form-control" /></td>
            </tr>
            <tr>
                <td align="right"><strong>职位</strong></td>
                <td><input id="zhiwei" name="zhiwei" type="text" class="form-control" /></td>
                <td align="right"><strong>SKYPE</strong></td>
                <td><input id="skype"  name="skype" type="text" class="form-control" /></td>
            </tr>
            <tr>
                <td align="right"><strong>名字拼音</strong></td>
                <td class="form-inline">
          <span class="input-group">
            <input id="xing" name="xing" type="text" class="form-control" />
          </span>
          <span class="input-group">
            (姓)
          </span>
          <span class="input-group">
            <input id="ming" name="ming" type="text" class="form-control" />
          </span>
          <span class="input-group">
           （名）
          </span>
                </td>
                <td align="right"><strong>是否主要联系人</strong></td>
                <td>
                    <input id="setdefault" name="setdefault" type="radio" value="0" title="主要联系人">
                    <input id="setdefault1" name="setdefault" type="radio" value="1" title="非主要联系人">
                </td>
            </tr>
            <tr>
                <td align="right"><strong>性别</strong></td>
                <td>
                    <input id="sex1" name="sex" type="radio" value="男" title="男">
                    <input id="sex2" name="sex" type="radio" value="女" title="女">
                </td>
                <td align="right"><strong>是否展会后期负责人</strong></td>
                <td>
                    <input id="setdefault1a" name="setdefault1" type="radio" value="0" title="主要联系人">
                    <input id="setdefault1b" name="setdefault1" type="radio" value="1" title="非主要联系人">
                </td>
            </tr>
            <tr>
                <td align="right"><strong>护照类型</strong></td>
                <td colspan="3">
                    <input id="hz_type" name="hz_type" type="radio" value="1" title="外交护照">
                    <input id="hz_type2" name="hz_type" type="radio" value="2" title="公务护照">
                    <input id="hz_type3" name="hz_type" type="radio" value="3" title="因公普通护照">
                    <input id="hz_type4" name="hz_type" type="radio" value="4" title="因私普通护照">
                </td>
            </tr>
            <tr>
                <td align="right"><strong>护照号码</strong></td>
                <td>
                    <input id="hz_no" name="hz_no" type="text" class="form-control" />
                </td>
                <td align="right"><strong>出生日期</strong></td>
                <td  class="form-inline">
                    <div class="input-group">
                        <input id="birth" name="birth" type="text" class="form-control" onclick="layui.laydate({elem: this, festival: true})"/>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>出生地点</strong></td>
                <td>
                    <input id="hz_csd" name="hz_csd" type="text" class="form-control" />
                </td>
                <td align="right"><strong>签发地点</strong></td>
                <td>
                    <input id="hz_qfd" name="hz_qfd" type="text" class="form-control" />
                </td>
            </tr>
            <tr>
                <td align="right"><strong>签发时间</strong></td>
                <td  class="form-inline">
                    <div class="input-group">
                        <input id="hz_qfdate" name="hz_qfdate" type="text" class="form-control"  onclick="layui.laydate({elem: this, festival: true})"/>
                    </div>
                </td>
                <td align="right"><strong>护照有效期</strong></td>
                <td>
                    <input id="hz_date" name="hz_date" type="text" class="form-control" />
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><strong>照片/护照</strong></td>
                <td colspan="2" valign="top" class="form-inline">
                    <div class="input-group">
                        <input id="huzhao" name="huzhao" type="text" class="form-control" size="58"/>
                    </div>
                    <div class="input-group">
                        <input type="file" name="photo" id="photo" class="layui-upload-file">
                    </div>
                </td>
                <td>
                    <a href="" id="a_a" target="_blank"><img id="img_a" src="" alt="" width="100px" height="100px"></a>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><strong>备注</strong></td>
                <td colspan="3" valign="top"><textarea id="memo" name="memo" rows="5" class="form-control"></textarea></td>
            </tr>
            <if condition="$czid">
                <input type="hidden" name="updatedtime" id="time">
                <else/>
                <input type="hidden" name="posttime" id="time">
            </if>
        </table>
    </form>
    <br>
    <script>
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
            $("#time").val($timeStr) ;
        });
        $(function () {
            layui.use('upload', function(){
                layui.upload({
                    url: '/index.php/Home/LayUpload/index'
                    ,elem: '#photo'
                    ,method: 'post'
                    ,title: '上传图片'
                    ,ext: 'jpg|gif|png|jpeg|peg|bmp|pdf'
                    ,success: function(res){
                        if(res.code==1){ //返回成功
                            $("#huzhao").val(res.url);
                        }
                        layer.msg(res.msg, {icon: res.code});
                    }
                });
            });
            /*重置表单*/
            resetFrom();
            var act="create";
            var czid=$("#czid").val();
            if(czid){
                $('#PageT').html("编辑");
                //获取编辑数据
                $.ajax({
                    url: "?show=edit&czid="+czid,
                    type: "post",
                    success: function (json) {
                        $.each(json, function (i,item) {
                            $("#cid").val(item.cid);
                            $("#cname").text(item.cname);
                            $("#telarea").val(item.telarea);
                            $("#tel").val(item.tel);
                            $("#fenji").val(item.fenji);
                            $("#username").val(item.username);
                            $("#faxarea").val(item.faxarea);
                            $("#fax").val(item.fax);
                            $("#password").val(item.password);
                            $("#mobile").val(item.mobile);
                            $("#fullname").val(item.fullname);
                            $("#email").val(item.email);
                            $("#bumen").val(item.bumen);
                            $("#qq").val(item.qq);
                            $("#zhiwei").val(item.zhiwei);
                            $("#skype").val(item.skype);
                            $("#xing").val(item.xing);
                            $("#ming").val(item.ming);
                            $("#hz_no").val(item.hz_no);
                            $("#birth").val(item.birth);
                            $("#hz_csd").val(item.hz_csd);
                            $("#hz_qfd").val(item.hz_qfd);
                            $("#hz_qfdate").val(item.hz_qfdate);
                            $("#hz_date").val(item.hz_date);
                            $("#huzhao").val(item.huzhao);
                            $("#memo").val(item.memo);
                            $("#img_a").attr("src", item.huzhao);
                            $("#a_a").attr("href", item.huzhao);
                            layui.use('form', function(){
                            var form = layui.form();
                            if (item.sex=='男') {
                                $("#sex1").prop("checked",true);
                            }else if(item.sex=='女'){
                                $("#sex2").prop("checked",true);
                            };
                            form.render();
                            if (item.setdefault==0) {
                                $("#setdefault").prop("checked",true);
                            }else if(item.setdefault==1){
                                $("#setdefault1").prop("checked",true);
                            };
                            form.render();
                            if (item.setdefault1==0) {
                                $("#setdefault1a").prop("checked",true);
                            }else if(item.setdefault1==1){
                                $("#setdefault1b").prop("checked",true);
                            };
                            form.render();
                            if (item.hz_type==1) {
                                $("#hz_type").prop("checked",true);
                            }else if(item.hz_type==2){
                                $("#hz_type2").prop("checked",true);
                            }else if(item.hz_type==3){
                                $("#hz_type3").prop("checked",true);
                            }else if(item.hz_type==4){
                                $("#hz_type4").prop("checked",true);
                            };
                            form.render();
                            });
                        });
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
                var param = $("#addForm").serialize();
                $.ajax({
                    url: "?act="+act+"&czid="+czid+"&list={$list}",
                    data: param,
                    dataType: 'json',
                    type: 'POST',
                    success: function (res) {
                        if(res.code==1){
                            var index = parent.layer.getFrameIndex(window.name); 		//获取窗口索引
                            parent.layer.msg(res.msg, {icon: res.code}); 				 //显示提示消息
                            if(res.list=='gys'){
                                window.parent.DatablesReload("lianxiren");				//刷新父层ListZhanGuan表格的DataTable数据
                            }else if(res.list=='expoview'){
                                window.parent.DatablesReload("table");				//刷新父层ListZhanGuan表格的DataTable数据
                            }else{
                                window.parent.DatablesReload("renyuan");				//刷新父层ListZhanGuan表格的DataTable数据
                            }
                            parent.layer.close(index);
                        } else {
                            layer.msg(res.msg, {icon: res.code});
                        }
                    }, error: function (error) {
                        layer.msg('请求错误', {icon: 2});
                        console.log(error);
                    }
                });
            }
        });
    </script>
</block>
