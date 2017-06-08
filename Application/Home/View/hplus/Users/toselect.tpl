<extend name="Public/base" />
<block name="main">
    <input type=hidden id="czid" checked>
    <input type=hidden id="title" checked>
    <div class="footerbtn">
        <button class="btn btn-success selectFun"><i class="fa fa-check-square-o"></i> 选择</button>
        <button class="btn btn-info refreshBtn"><i class="fa fa-refresh"></i> 刷新</button>
        <button class="btn btn-danger closeBtn"><i class="fa fa-close"></i> 关闭</button>
    </div>
     <div class="listUsers layui-form">
        {$list}
     </div>
    <br><br><br>
<script>
    $(".selectFun").click(function(){
        var iid='';
        var title='';
        $("input[name='sid[]']:checked").each(function (i, n) {
            if(i==0){
                douhao="";
            }else{
                douhao=",";
            }
            iid+=douhao+$(n).val();
            title+=douhao+$(n).attr('title');
        });
        //alert(iid);
        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
        parent.$('#{$sname}').val(iid);
        parent.$('#{$iname}').val(title);
        //parent.$('#expoidtext').html();
        parent.layer.tips('已选择人员', '#{$iname}', {tips: [1, '#0FA6D8']});
        parent.layer.close(index);
    });
</script>
</block>
