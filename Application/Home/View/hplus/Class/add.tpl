<extend name="Public/base" />
<block name="main">
    <!--签证管理添加快递界面-->
    <div class="footerbtn">
        <button id="saveFun" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i>Refresh</button>
        <button id="closeFun" class="btn btn-danger"><i class="fa fa-close"></i> Close</button>
    </div>
    <form class="layui-form" id="addForm">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label" style="padding-top: 1px">类别名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="classname" placeholder="请输入类别名称"  class="layui-input">
                </div>
            </div>
        </div>
    </form>
    <script>
        $("#saveFun").click(function(){
            var param=$('form').serialize();
            $.ajax({
               url: "{:U('add?act=create',array('flid'=>$flid))}",
                type: "post",
                data:param,
                success: function (res) {
                    if (res.code == 1) {
                        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                        window.parent.DatablesReload("table");
                        parent.layer.msg(res.msg, {icon: res.code});
                        parent.layer.close(index);
                    } else {
                        layer.msg(res.msg, {icon: res.code});
                    }
                }, error: function (error) {
                    layer.msg('请求错误', {icon: 2});
                    console.log(error);
                }
            });
        });
    </script>
</block>
