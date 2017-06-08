<extend name="Public/base" />
<block name="main">
    <!--挂单添加界面-->
    <div class="footerbtn">
        <button id="saveFun" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i>Refresh</button>
        <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
    </div>
    <form method='post' id="addForm" action='' class="layui-form">
        <input type=hidden id="oid" name="oid" value="{$oid}" checked>
        <table class='table table-striped'>
            <tr>
                <td width="120" align="right"><font color="red" style="font-size:18px;">*</font>Lost reason</td>
                <td>
                    <div class="layui-input-inline">
                        <select id="why" name="why" col="2" size="15" lay-filter="why">
                            <option value="">Lost reason</option>
                            <volist name=":ShowList('class','parid=1661','id')" id="vo">
                                <option value="{$vo.id}"<if condition="$vo['id'] eq 1861">selected="selected"</if>>{$vo.classname}</option>
                            </volist>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="120" align="right">Remarks</td>
                <td>
                    <textarea id="memo" name="memo" cols="60" rows="3"></textarea>
                    <input type="hidden" id="aa">
                </td>
            </tr>
            <input type="hidden" name="posttime" id="time">
        </table>
    </form>
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
        $("#saveFun").click(function(){
            var s2 = $("#why");
            if (s2.val() == "") {
                layer.msg('Lost reason not empty!');
                console.log(error);
            }
            var param = $("#addForm").serialize();
            $.ajax({
                url: "?act=create",
                data: param,
                dataType: 'json',
                type: 'POST',
                success: function (res) {
                    if (res.code == 1) {
                        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                        parent.location.reload();
                        parent.layer.msg(res.msg, {icon: res.code});
                        //parent.zhanguan.ajax.reload(null,false);
                        parent.layer.close(index);
                    } else {
                        layer.msg(res.msg, {icon: res.code});
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
        })
    </script>
</block>
